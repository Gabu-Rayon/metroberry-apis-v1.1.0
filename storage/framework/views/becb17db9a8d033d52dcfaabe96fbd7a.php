<form action="<?php echo e(route('vehicle.maintenance.service.categories.edit', $serviceCategory->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit <?php echo e($serviceCategory->name); ?></h4>
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
                        <input name="name" class="form-control" type="text" placeholder="Name" id="name"
                            required value="<?php echo e($serviceCategory->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="serviceType" class="col-sm-5 col-form-label">
                        Service Type
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="serviceType" class="form-control" id="serviceType" required>
                            <option value="" disabled>Select Service Type</option>
                            <?php $__currentLoopData = $serviceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($serviceType->id); ?>"
                                    <?php echo e($serviceCategory->service_type_id == $serviceType->id ? 'selected' : ''); ?>>
                                    <?php echo e($serviceType->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">
                        Description
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <textarea name="description" class="form-control" placeholder="Description" id="description" required rows="5"><?php echo e($serviceCategory->description); ?></textarea>
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
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle/maintenance/service/categories/edit.blade.php ENDPATH**/ ?>