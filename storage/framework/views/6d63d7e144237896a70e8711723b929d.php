<form action="<?php echo e(route('vehicle.assign.driver', $vehicle->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Assign Vehicle Driver</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="model" class="col-sm-5 col-form-label">Model <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->model); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="make" class="col-sm-5 col-form-label">Manufacturer <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->make); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="year" class="col-sm-5 col-form-label">Vehicle Year of Manufacturer <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->year); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="plate_number" class="col-sm-5 col-form-label">Number Plate <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->plate_number); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->fuel_type); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="engine_size" class="col-sm-5 col-form-label">Engine Size <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->engine_size); ?>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="color" class="col-sm-5 col-form-label">Vehicle Color <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->color); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="seats" class="col-sm-5 col-form-label">No of Seats <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <?php echo e($vehicle->seats); ?>

                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="vehicle_avatar" class="col-sm-5 col-form-label">Vehicle Avatar</label>
                    <div class="col-sm-7">
                        <?php if($vehicle->avatar): ?>
                            <img src="<?php echo e(asset('images/' . $vehicle->avatar)); ?>" alt="Vehicle Avatar"
                                class="img-thumbnail mt-2" style="max-height: 150px;">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="driver_id" class="col-sm-5 col-form-label">Driver</label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single select2" name="driver_id" id="driver_id" tabindex="-1"
                            aria-hidden="true">
                            <option value="">Please select one</option>
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>"><?php echo e($driver->user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Update</button>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle/assign-driver.blade.php ENDPATH**/ ?>