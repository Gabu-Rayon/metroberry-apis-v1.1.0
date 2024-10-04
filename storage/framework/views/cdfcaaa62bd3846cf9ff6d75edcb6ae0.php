<form action="<?php echo e($trip->id); ?>/details" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php
        $billable = (bool) $trip->is_billable;
    ?>
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Billing Details</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="customer" class="col-sm-5 col-form-label">
                        Customer
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="customer" readonly class="form-control" type="text" placeholder="Customer"
                            id="customer" value="<?php echo e($trip->customer->user->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="driver" class="col-sm-5 col-form-label">
                        Driver
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="driver" readonly class="form-control" type="text" placeholder="Driver"
                            id="driver" value="<?php echo e($trip->vehicle->driver->user->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="pick_up_time" class="col-sm-5 col-form-label">
                        Pick up Time
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="pick_up_time" readonly class="form-control" type="text"
                            placeholder="Pick Up Time" id="pick_up_time" value="<?php echo e($trip->pick_up_time); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="vehicle_mileage" class="col-sm-5 col-form-label">
                        Vehicle Mileage (KM)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="vehicle_mileage" <?php echo e($trip->vehicle_mileage ? 'readonly' : ''); ?> required
                            class="form-control" type="number" placeholder="Vehicle Mileage" id="vehicle_mileage"
                            value="<?php echo e($trip->vehicle_mileage ?? old('vehicle_mileage')); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="engine_hours" class="col-sm-5 col-form-label">
                        Engine Hours (Hrs)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="engine_hours" <?php echo e($trip->engine_hours ? 'readonly' : ''); ?> required
                            class="form-control" type="number" placeholder="Engine Hours" id="engine_hours"
                            value="<?php echo e($trip->engine_hours ?? old('engine_hours')); ?>" />
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="national_id_no" class="col-sm-5 col-form-label">
                        Customer ID
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="national_id_no" readonly class="form-control" type="text"
                            placeholder="Customer ID" id="national_id_no"
                            value="<?php echo e($trip->customer->national_id_no); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="driving_license_no" class="col-sm-5 col-form-label">
                        Driver License
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="driving_license_no" readonly class="form-control" type="text"
                            placeholder="Driver License" id="driving_license_no"
                            value="<?php echo e($trip->vehicle->driver->license->driving_license_no); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="drop_off_time" class="col-sm-5 col-form-label">
                        Drop Off Time
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="drop_off_time" readonly class="form-control" type="text"
                            placeholder="Drop Off Time" id="drop_off_time" value="<?php echo e($trip->drop_off_time); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="fuel_consumed" class="col-sm-5 col-form-label">
                        Fuel Consumed (L)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="fuel_consumed" <?php echo e($trip->fuel_consumed ? 'readonly' : ''); ?> required
                            class="form-control" type="number" placeholder="Fuel Consumed" id="fuel_consumed"
                            value="<?php echo e($trip->fuel_consumed ?? old('fuel_consumed')); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="idle_time" class="col-sm-5 col-form-label">
                        Idle Time (Hrs)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="idle_time" <?php echo e($trip->idle_time ? 'readonly' : ''); ?> required
                            class="form-control" type="number" placeholder="Idle Time" id="idle_time"
                            value="<?php echo e($trip->idle_time ?? old('idle_time')); ?>" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit" <?php echo e($trip->is_billable ? 'disabled' : ''); ?>>
            Save
        </button>
    </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/trips/details.blade.php ENDPATH**/ ?>