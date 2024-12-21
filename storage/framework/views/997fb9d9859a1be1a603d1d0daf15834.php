

<?php $__env->startSection('title', 'Vehicle Registration | Driver'); ?>
<?php $__env->startSection('content'); ?>
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    <?php
        $user = Auth::user();
        $driver = $user->driver;

        \Log::debug('Driver Vehicle:', [
            'organisation_id' => $driver->vehicle->organisation_id ?? 'null',
            'manufacture_id' => $driver->vehicle->manufacturer_id ?? 'null',
            'fuel_type_id' => $driver->vehicle->fuel_type_id ?? 'null',
            'class_id' => $driver->vehicle->class ?? 'null',
        ]);

    ?>

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="text-center header-icons-container">
                <a href="<?php echo e(route('driver.vehicle.docs.registration')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <?php if($driver->status == 'inactive'): ?>
                    <span> Account Deactivated</span>
                <?php else: ?>
                    <span>Vehicle Registration/(Assigned)</span>
                <?php endif; ?>

                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title">
                    <span>Vehicle Registration</span>
                    
                    <?php if($driver->vehicle->status == 'inactive'): ?>
                        <span class="badge badge-pill fs-6 badge-danger">Inactive</span>
                    <?php else: ?>
                        <span class="badge badge-pill fs-6 badge-success">Active</span>
                    <?php endif; ?>

                </div>

                <?php if(session('success')): ?>
                    <div id="success-message" class="alert alert-success" style="display: none;">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div id="error-message" class="alert alert-danger" style="display: none;">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <!--Driver's License Fields Container Start-->
                <div class="all-container all-container-with-classes">
                    <form class="width-100"
                        action="<?php echo e($driver->vehicle ? route('driver.registration.vehicle.update', $driver->vehicle->id) : route('driver.registration.vehicle.store')); ?>"
                        method="POST" enctype="multipart/form-data">

                        <?php echo csrf_field(); ?>
                        <?php if($driver->vehicle): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php else: ?>
                            <?php echo method_field('POST'); ?>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Vehicle Model</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="text" name="driver_vehicle_model"
                                    value="<?php echo e(old('driver_vehicle_model', $driver->vehicle->model ?? '')); ?>"
                                    placeholder="Toyota Auris" />
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Vehicle Plate No.</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="text" name="driver_vehicle_plate_number"
                                    value="<?php echo e(old('driver_vehicle_plate_number', $driver->vehicle->plate_number ?? '')); ?>"
                                    placeholder="KDR 999Z" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Vehicle Seats No.</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="number" name="driver_vehicle_seats_no"
                                    value="<?php echo e(old('driver_vehicle_seats_no', $driver->vehicle->seats ?? '')); ?>"
                                    placeholder="4" />
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="driver_vehicle_avatar" id="national-id-back-input" />
                                    </span>
                                    <span class="text-uppercase">Vehicle</span>
                                    <span class="delete-btn" id="national-id-back-delete">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img id="national-id-back-preview"
                                                        src="<?php echo e($driver->vehicle && $driver->vehicle->avatar ? asset($driver->vehicle->avatar) : asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                        alt="Back"
                                                        onerror="this.onerror=null; this.src='<?php echo e(asset('mobile-app-assets/icons/photocamera.svg')); ?>';" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!--Input Field Container Start-->

                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Current Vehicle Organisation</span>
                                <span class="car-info-wrap display-block">


                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_organisation">
                                        <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($organisation->id); ?>"
                                                <?php echo e(old('driver_vehicle_organisation', $driver->vehicle->organisation_id ?? '') == $organisation->id ? 'selected' : ''); ?>>
                                                <?php echo e($organisation->user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>



                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Current Vehicle Class</span>
                                <span class="car-info-wrap display-block">


                                    <select class="custom-select font-weight-light car-info" name="driver_vehicle_class">
                                        <?php $__currentLoopData = $vehicleClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vehicleClass->id); ?>"
                                                <?php echo e(old('driver_vehicle_class', $driver->vehicle->class ?? '') == $vehicleClass->name ? 'selected' : ''); ?>>
                                                <?php echo e($vehicleClass->name); ?>(<?php echo e($vehicleClass->max_passengers); ?> seater)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>


                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Fuel Type</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_fuel_type">
                                        <?php $__currentLoopData = $vehicleFuelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fuelType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fuelType->id); ?>"
                                                <?php echo e(old('driver_vehicle_fuel_type', $driver->vehicle->fuel_type_id ?? '') == $fuelType->id ? 'selected' : ''); ?>>
                                                <?php echo e($fuelType->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Year of Manufacture


                                    <i>Current : </i>
                                    <span class="text-primary"><?php echo e($driver->vehicle->year ?? null); ?></span>

                                </label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="number" name="driver_vehicle_date_of_manufacture"
                                    value="<?php echo e(old('driver_vehicle_date_of_manufacture', $driver->vehicle->year ?? '')); ?>"
                                    placeholder="2022" min="1900" max="<?php echo e(date('Y')); ?>" />
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Manufacturer</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_manufacturer">
                                        <?php $__currentLoopData = $VehicleManufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($manufacturer->id); ?>"
                                                <?php echo e(old('driver_vehicle_manufacturer', $driver->vehicle->manufacturer_id ?? '') == $manufacturer->id ? 'selected' : ''); ?>>
                                                <?php echo e($manufacturer->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Engine Size</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="number" name="driver_vehicle_engine_size"
                                    value="<?php echo e(old('driver_vehicle_engine_size', $driver->vehicle->engine_size ?? '')); ?>"
                                    placeholder="2000cc" />
                            </div>
                        </div>

                        <div class="text-center form-submit-button">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                <?php echo e($driver->vehicle ? 'Update' : 'Register Now'); ?>

                            </button>
                        </div>
                    </form>
                </div>
                <!--Driver's License Fields Container End-->
            </div>
        </div>


        <!--Terms And Conditions Agreement Container Start-->
        <div class="text-center col-xs-12 col-sm-12 sms-rate-text font-roboto flex-end margin-bottom-30">
            <div class="container-sms-rate-text width-100 font-11">
                <span class="light-gray font-weight-light">
                </span>
                <br />
                <a href="#" class="dark-link">
                    <span class="font-weight-light">Metroberry Tours & Travel</span>
                </a>
            </div>
        </div>
        <!--Terms And Conditions Agreement Container End-->

        <!--Main Menu Start-->
        <?php echo $__env->make('components.driver-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--Main Menu End-->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/vehicle-registration.blade.php ENDPATH**/ ?>