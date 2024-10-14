<form action="license/<?php echo e($license->id); ?>/update" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit <?php echo e($license->driver->user->name); ?>'s License Details</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="license_no" class="col-sm-5 col-form-label">
                        License Number
                    </label>
                    <div class="col-sm-7">
                        <input name="license_no" readonly class="form-control" type="text"
                            placeholder="License Number" id="license_no" value="<?php echo e($license->driving_license_no); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="driving_license_date_of_issue" class="col-sm-5 col-form-label">
                        Issue Date
                    </label>
                    <div class="col-sm-7">
                        <input name="driving_license_date_of_issue" required class="form-control" type="date"
                            placeholder="Issue Date" id="driving_license_date_of_issue"
                            value="<?php echo e($license->driving_license_date_of_issue); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="driving_license_avatar_front" class="col-sm-5 col-form-label">
                        Front Page License Picture
                    </label>
                    <div class="col-sm-7">
                        <input name="driving_license_avatar_front" class="form-control" type="file"
                            placeholder="Front Page License Picture" id="driving_license_avatar_front" value="" />
                        <?php if($license->driving_license_avatar_front): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(url('storage/' . $license->driving_license_avatar_front)); ?>"
                                    download>Download Front Page License Picture</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="driver" class="col-sm-5 col-form-label">
                        Driver
                    </label>
                    <div class="col-sm-7">
                        <input name="driver" readonly class="form-control" type="text" placeholder="Driver"
                            id="driver" value="<?php echo e($license->driver->user->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="driving_license_date_of_expiry" class="col-sm-5 col-form-label">
                        Expiry Date
                    </label>
                    <div class="col-sm-7">
                        <input name="driving_license_date_of_expiry" required class="form-control" type="date"
                            placeholder="Expiry Date" id="driving_license_date_of_expiry"
                            value="<?php echo e($license->driving_license_date_of_expiry); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="driving_license_avatar_back" class="col-sm-5 col-form-label">
                        Back Page License Picture
                    </label>
                    <div class="col-sm-7">
                        <input name="driving_license_avatar_back" class="form-control" type="file"
                            placeholder="Back Page License Picture" id="driving_license_avatar_back" value="" />
                        <?php if($license->driving_license_avatar_back): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(url('storage/' . $license->driving_license_avatar_back)); ?>"
                                    download>Download Back Page License Picture</a>
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
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver/license/edit.blade.php ENDPATH**/ ?>