'
<table style="padding:0;margin:0" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td style="font-size:0"><span></span></td>
            <td style="width:640px;max-width:640px" valign="top" align="left">
                <table style="padding:0;margin:0;border:0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                    <tbody>
                        <tr>
                            <td style="padding:32px 63px 0 63px" align="left">
                                <h2>Hi, </h2>
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
                                                <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '$token=' . urlencode($token) . '" style="font-family:Helvetica,Arial,sans-serif;font-size:16px;color:#ffffff;background-color:#d90007;border-radius:3px;text-align:center;text-decoration:none;display:block;margin:0">
                                                    Verify my email
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <p style="font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#777777;padding:0;margin:33px 0 20px 0;text-align:left">
                                    Didn’t work? Copy the link below into your web browser:
                                    <br>
                                    ' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '$token=' . urlencode($token) . '
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
'


'Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . $token . '">Activate</a>'