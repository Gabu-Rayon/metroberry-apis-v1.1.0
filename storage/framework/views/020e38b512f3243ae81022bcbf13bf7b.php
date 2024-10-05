<form action="<?php echo e(route('organisation.update', $organisation->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit <?php echo e($organisation->user->name); ?>'s Details</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">
                        Name
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="name" required class="form-control" type="text" placeholder="Name"
                            id="name" value="<?php echo e($organisation->user->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="phone" class="col-sm-5 col-form-label">
                        Phone
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="phone" required class="form-control" type="text" placeholder="Phone"
                            id="phone" value="<?php echo e($organisation->user->phone); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="organisation_code" class="col-sm-5 col-form-label">
                        Organisation Code
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="organisation_code" required class="form-control" type="text"
                            placeholder="Organisation Code" id="organisation_code"
                            value="<?php echo e($organisation->organisation_code); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="logo" class="col-sm-5 col-form-label">
                        Logo
                    </label>
                    <div class="col-sm-7">
                        <input name="logo" class="form-control" type="file" placeholder="Logo" id="logo"
                            value="" />
                        <img src="<?php echo e(url('storage/' . $organisation->user->avatar)); ?>" alt="Avatar"
                            class="form-control" />
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="email" class="col-sm-5 col-form-label">
                        Email
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="email" required class="form-control" type="email" placeholder="Email"
                            id="email" value="<?php echo e($organisation->user->email); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="address" class="col-sm-5 col-form-label">
                        Address
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="address" required class="form-control" type="text" placeholder="Address"
                            id="address" value="<?php echo e($organisation->user->address); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="certificate_of_organisation" class="col-sm-5 col-form-label">
                        Certificate of Organisation
                    </label>
                    <div class="col-sm-7">
                        <input name="certificate_of_organisation" class="form-control" type="file"
                            placeholder="Certificate of Organisation" id="certificate_of_organisation" value="" />
                        <?php if($organisation->certificate_of_organisation): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(url('storage/' . $organisation->certificate_of_organisation)); ?>"
                                    download>Download Certificate of Organisation</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/organisation/edit.blade.php ENDPATH**/ ?>