<form action="driver/<?php echo e($driver->id); ?>/update" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit <?php echo e($driver->user->name); ?>'s Details</h4>
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
                            id="name" value="<?php echo e($driver->user->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="phone" class="col-sm-5 col-form-label">
                        Phone
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="phone" required class="form-control" type="text" placeholder="Phone"
                            id="phone" value="<?php echo e($driver->user->phone); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="organisation" class="col-sm-5 col-form-label">
                        Organisation
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="organisation" id="organisation" class="form-control" required>
                            <option value="">Select Organisation</option>
                            <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($organisation->organisation_code); ?>"
                                    <?php echo e($driver->organisation_id == $organisation->id ? 'selected' : ''); ?>>
                                    <?php echo e($organisation->user->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="front_page_id" class="col-sm-5 col-form-label">
                        Front Page ID Picture
                    </label>
                    <div class="col-sm-7">
                        <input name="front_page_id" class="form-control" type="file"
                            placeholder="Front Page ID Picture" id="front_page_id" value="" />
                        <?php if($driver->national_id_front_avatar): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(url('storage/' . $driver->national_id_front_avatar)); ?>" download>Download
                                    Front Page ID</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="avatar" class="col-sm-5 col-form-label">
                        Avatar
                    </label>
                    <div class="col-sm-7">
                        <input name="avatar" class="form-control" type="file" placeholder="Avatar" id="avatar"
                            value="" />
                        <img src="<?php echo e(url('storage/' . $driver->user->avatar)); ?>" alt="Avatar" class="form-control" />
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
                            id="email" value="<?php echo e($driver->user->email); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="address" class="col-sm-5 col-form-label">
                        Address
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="address" required class="form-control" type="text" placeholder="Address"
                            id="address" value="<?php echo e($driver->user->address); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="national_id_no" class="col-sm-5 col-form-label">
                        ID Number
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="national_id_no" required class="form-control" type="text"
                            placeholder="ID Number" id="national_id_no" value="<?php echo e($driver->national_id_no); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="back_page_id" class="col-sm-5 col-form-label">
                        Back Page ID Picture
                    </label>
                    <div class="col-sm-7">
                        <input name="back_page_id" class="form-control" type="file"
                            placeholder="Back Page ID Picture" id="back_page_id" value="" />
                        <?php if($driver->national_id_behind_avatar): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(url('storage/' . $driver->national_id_behind_avatar)); ?>" download>Download
                                    Back Page ID</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($driver->vehicle): ?>
                    <div class="form-group row my-2">
                        <label for="vehicle" class="col-sm-5 col-form-label">
                            Vehicle
                        </label>
                        <div class="col-sm-7">
                            <input name="vehicle" class="form-control" type="text" placeholder="Vehicle"
                                id="vehicle" readonly value="<?php echo e($driver->vehicle->plate_number); ?>" />
                            <img src="<?php echo e(asset('images/' . $driver->vehicle->avatar)); ?>" alt="Vehicle"
                                class="form-control" />
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/driver/edit.blade.php ENDPATH**/ ?>