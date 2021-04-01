<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi success
            $this->_login();
        }
    }

    private function _login()
    {
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');

        $user       = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            // if user exist
            if ($user['is_active'] == 1) {
                // Check password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong password!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                This email has not been activated!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!</div>');
            redirect('auth');
        }
    }

    public function registration()
    {

        if ($this->session->userdata('email')) {
            redirect('user');
        }

        // set rules validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]); //[user.email] from tabel database
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'password dont match!',
            'min_length' => 'password to short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Information';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name'          => htmlspecialchars($this->input->post('name', true)),
                'email'         => htmlspecialchars($email),
                'image'         => 'default.jpg',
                'password'      => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id'       => 2,
                'is_active'     => 0,
                'date_created'  => time()
            ];

            // siapkan token buat email
            $token = base64_encode(openssl_random_pseudo_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! your account has been created. Please activate your account!</div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'YOUREMAIL@GMAIL.COM',
            'smtp_pass' => 'YOUR PASSWORD EMAIL ',
            'smtp_port' =>  465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('YOUREMAIL@GMAIL.COM', 'Hamidi Team');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('SPOOSH Email Verification Required');
            $this->email->message('
            <table style="padding:0;margin:0" width="100%" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr>
                        <td style="font-size:0"><span></span></td>
                        <td style="width:640px;max-width:640px" valign="top" align="left">
                            <table style="padding:0;margin:0;border:0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                                <tbody>
                                    <tr>
                                        <td style="padding:32px 63px 0 63px" align="left">
                                            <h2>Hi, ' . $this->input->post('name') . ' </h2>
                                            <h1 style="font-family:Helvetica,Arial,sans-serif;font-size:24px;line-height:31px;color:#777777;padding:0;margin:28px 0 32px 0;font-weight:400;text-align:left;text-decoration:none">
                                                <a style="text-decoration:none;color:#777777" target="_blank">
                                                    <span style="display:block">' . $this->input->post('email') . '</span></a>
                                            </h1>
            
                                            <p style="font-size:16px;line-height:20px;color:#333333;padding:0;margin:0 0 33px 0;text-align:left;font-family:Helvetica,Arial,sans-serif">
                                                You have one more step remaining to activate your SPOOSH account.
                                                &nbsp;
                                                Click on the button below to verify your email address:</p>
            
                                            <table style="padding:0;margin:0;border:0;width:213px" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="border-radius:3px;padding:12px 20px 16px 20px;background-color:#d90007" valign="top" align="center">
                                                            <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '" style="font-family:Helvetica,Arial,sans-serif;font-size:16px;color:#ffffff;background-color:#d90007;border-radius:3px;text-align:center;text-decoration:none;display:block;margin:0">
                                                                Verify my email
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
            
                                            <p style="font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#777777;padding:0;margin:33px 0 20px 0;text-align:left">
                                                Didn’t work? Copy the link below into your web browser:
                                                <br>
                                                "' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"
                                            </p>
            
                                            <p style="font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#333333;padding:0;margin:35px 0 0 0;text-align:left">
                                                Best regards,<br>— Team SPOOSH
                                            </p>
            
            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="font-size:0"><span></span></td>
                    </tr>
            
            
                    <tr>
                        <td style="font-size:0"><span></span></td>
                        <td style="width:640px;max-width:640px;padding:25px 0 28px 0" id="m_4668446291475384322copyrights-block" valign="middle" align="center">
                            <p style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:20px;color:#999999;padding:0;margin:4px 0 22px 0">SPOOSH Limited 2020 </p>
                            <table style="padding:0;margin:0;border:0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:0 8px"><a href="https://www.twitter.com/nurdiansyahham1" style="text-decoration:none" target="_blank"><img alt="" src="https://mail.google.com/mail/u/3?ui=2&amp;ik=db923c013b&amp;attid=0.4&amp;permmsgid=msg-f:1668397579160161739&amp;th=172756c239f68dcb&amp;view=fimg&amp;sz=s0-l75-ft&amp;attbid=ANGjdJ_a6cnZ9HObZqExPLk0sASz81uhuWM1Kfuu6oGQoIEPB3jFl79i7AIVAn3cG9WlT77SfHQQT41KXm3EJKEZ8-eMN1gkAO8Lsi7C8hBiKa7rXM2OPGpwfBLSZ1k&amp;disp=emb" data-image-whitelisted="" class="CToWUd" width="24"></a></td>
                                        <td style="padding:0 8px"><a href="https://www.facebook.com/nurdiansyah.hamidi" style="text-decoration:none" target="_blank"><img alt="" src="https://mail.google.com/mail/u/3?ui=2&amp;ik=db923c013b&amp;attid=0.2&amp;permmsgid=msg-f:1668397579160161739&amp;th=172756c239f68dcb&amp;view=fimg&amp;sz=s0-l75-ft&amp;attbid=ANGjdJ-BCNgNEfhJ8g2qReWvWiGwCWumL1Se3YqVssfYA0RW1WBfjuurkR_wRtnSmwQ20-KAXrt2TatoemiFis7fqHTZUuBoRUv5DgYtDpCp-9K3tmz7LUW2DEljcsM&amp;disp=emb" data-image-whitelisted="" class="CToWUd" width="24"></a></td>
                                        <td style="padding:0 8px"><a href="https://mega.nz/" style="text-decoration:none" target="_blank"><img alt="" src="https://mail.google.com/mail/u/3?ui=2&amp;ik=db923c013b&amp;attid=0.3&amp;permmsgid=msg-f:1668397579160161739&amp;th=172756c239f68dcb&amp;view=fimg&amp;sz=s0-l75-ft&amp;attbid=ANGjdJ9O076g55wq14xEjHX09k48c9se0gsLhptjRx-rNZkz_zdEB7bYhaybc13XKEAZR8qEcHa4uyUGRxeIWwjukdxjtKgb6Q3yfy4hSXqixGBQiHGP3WU7DDkfWZQ&amp;disp=emb" data-image-whitelisted="" class="CToWUd" width="24"></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="font-size:0"><span></span></td>
                    </tr>
            
            
                </tbody>
            </table>
            ');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die();
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {

            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {

                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please login.</div>');
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Account activation failed! Token Expired.  </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token invalid.  </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
           Account activation failed! Wrong email.  </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
           You have been logout! </div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
