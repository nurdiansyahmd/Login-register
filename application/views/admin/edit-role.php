<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <form action="<?= base_url('admin/editrole'); ?>" method="post">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Role Name : </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="editrole1" name="editrole1" value="<?= $role['role'] ?>">
                        <?= form_error('editrole1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <div class="col-sm-10">
                        <button class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->