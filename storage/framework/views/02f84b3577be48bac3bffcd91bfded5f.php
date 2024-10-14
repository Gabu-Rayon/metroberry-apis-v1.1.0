<?php $__env->startSection('title', 'Vehicle Status | Driver'); ?>

<?php $__env->startSection('content'); ?>
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="<?php echo e(route('driver.dashboard')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                    <span>Vehicle | <?php echo e($driver->status == 'inactive' ? 'Inactive' : 'Active'); ?></span>

                    <a href="#">
                        <span class="float-right menu-open closed">
                            <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                        </span>
                    </a>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="scan-your-card-container-none">
                    <div class="clearfix"></div>

                    <?php if($driver->vehicle): ?>
                        <!--Upload Car Pictures Container Start-->
                        <div class="scan-your-card-prompt">
                            <div class="position-relative">
                                <div class="upload-picture-container mb-0">
                                    <div class="upload-camera-container text-center">
                                        <span class="camera">
                                            <img src="<?php echo e(asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                alt="Camera Icon" />
                                        </span>
                                    </div>
                                </div>
                                <input class="scan-prompt" type="file" accept="image/*" />
                            </div>
                            <div class="upload-picture-buttons-append">
                                <span class="float-left position-relative upload-btn">
                                    <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                    <input class="scan-prompt" type="file" accept="image/*" />
                                </span>
                                <span class="float-right delete-btn">
                                    <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                </span>
                                <span class="clearfix"></span>
                            </div>
                        </div>
                        <!--Upload Car Pictures Container End-->

                        <div class="font-awesome-container"></div>

                        <!--Car Registration Info Container Start-->
                        <div class="car-info-container car-info-container-top font-weight-light">
                            <div class="card-number">
                                <!--Car Registration Two Fields Container Start-->
                                <div class="multi-form-container display-flex justify-content-between">
                                    <!--Car Registration Field Start-->
                                    <div class="form-group">
                                        <label class="width-100">
                                            <span class="label-title">Current Organisation</span>
                                            <span class="car-info-wrap display-block">
                                                <select class="custom-select font-weight-light car-info" name="organisation_id">
                                                    <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($organisation->id); ?>"
                                                            <?php echo e($driver->vehicle->organisation_id == $organisation->id ? 'selected' : ''); ?>>
                                                            <?php echo e($organisation->user->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                        </label>
                                    </div>
                                    <!--Car Registration Field End-->

                                    <!--Car Registration Field Start-->
                                    <div class="form-group">
                                        <label class="width-100">
                                            <span class="label-title">Current Vehicle Class</span>
                                            <span class="car-info-wrap display-block">
                                                <select class="custom-select font-weight-light car-info"
                                                    name="vehicle_class_id">
                                                    <?php $__currentLoopData = $vehicleClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($vehicleClass->id); ?>"
                                                            <?php echo e($driver->vehicle->class_id == $vehicleClass->id ? 'selected' : ''); ?>>
                                                            <?php echo e($vehicleClass->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <!--Car Registration Field End-->

                                <!--Car Registration Two Fields Container Start-->
                                <div class="multi-form-container display-flex justify-content-between">
                                    <div class="form-group">
                                        <label class="width-100">
                                            <span class="label-title">Car Registration Number</span>
                                            <input class="form-control text-input font-weight-light" type="text"
                                                autocomplete="off" name="car-registration-num"
                                                value="<?php echo e($driver->vehicle->plate_number); ?>" />
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="width-100">
                                            <span class="label-title"> Fuel Type</span>
                                            <input class="form-control text-input font-weight-light" type="text"
                                                autocomplete="off" name="fuel_type"
                                                value="<?php echo e($driver->vehicle->fuel_type); ?>" />
                                        </label>
                                    </div>
                                </div>
                                <!--Car Registration Two Fields Container End-->

                                <!--Car Registration Two Fields Container Start-->
                                <div class="multi-form-container display-flex justify-content-between">
                                    <div class="form-group">
                                        <label class="width-100 mb-0">
                                            <span class="label-title">Date of Manufacture</span>
                                        </label>
                                        <div class="input-group light-field">
                                            <div class="input-group-prepend">
                                                <span class="far fa-calendar-alt"></span>
                                            </div>
                                            <input class="form-control" type="text" name="year"
                                                value="<?php echo e($driver->vehicle->year); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="width-100 mb-0">
                                            <span class="label-title">Engine Size</span>
                                        </label>
                                        <div class="input-group light-field">
                                            <div class="input-group-prepend"></div>
                                            <input class="form-control" type="number" name="engine_size"
                                                value="<?php echo e($driver->vehicle->engine_size); ?>" />
                                        </div>
                                    </div>
                                </div>
                                <!--Car Registration Two Fields Container Start-->
                                <div class="multi-form-container display-flex justify-content-between">
                                    <div class="form-group">
                                        <label class="width-100 mb-0">
                                            <span class="label-title">Manufacture</span>
                                        </label>
                                        <div class="input-group light-field">
                                            <div class="input-group-prepend"></div>
                                            <input class="form-control" type="text" name="make"
                                                value="<?php echo e($driver->vehicle->make); ?>" />
                                        </div>
                                    </div>
                                    <!--Car Registration Field Start-->
                                    <div class="form-group">
                                        <label class="width-100">
                                            <span class="label-title"> Fuel Type</span>
                                            <input class="form-control text-input font-weight-light" type="text"
                                                autocomplete="off" name="fuel_type"
                                                value="<?php echo e($driver->vehicle->fuel_type); ?>" />
                                        </label>
                                    </div>
                                    <!--Car Registration Field End-->
                                </div>
                                <!--Car Registration Two Fields Container End-->

                                <div class="text-center car-registration-container">
                                    <h4>
                                        Please Upload Car<br />
                                        Registration Log Book.
                                    </h4>
                                </div>

                                <!--Car Registration ID Upload Container Start-->
                                <div class="scan-your-card-prompt">
                                    <div class="upload-picture-buttons-prepend text-center">
                                        <span class="float-left position-relative upload-btn">
                                            <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*" />
                                        </span>
                                        <span>FRONT</span>
                                        <span class="float-right delete-btn">
                                            <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                        </span>
                                        <span class="clearfix"></span>
                                    </div>
                                    <div class="position-relative">
                                        <div class="upload-picture-container mb-0">
                                            <div class="upload-camera-container text-center">
                                                <span class="camera">
                                                    <img src="<?php echo e(asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                        alt="Camera Icon" />
                                                </span>
                                            </div>
                                        </div>
                                        <input class="scan-prompt" type="file" accept="image/*" />
                                    </div>
                                </div>
                                <!--Car Registration ID Upload Container End-->

                                <!--Car Registration ID Upload Container Start-->
                                <div class="scan-your-card-prompt">
                                    <div class="upload-picture-buttons-prepend text-center">
                                        <span class="float-left position-relative upload-btn">
                                            <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*" />
                                        </span>
                                        <span>BACK</span>
                                        <span class="float-right delete-btn">
                                            <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                        </span>
                                        <span class="clearfix"></span>
                                    </div>
                                    <div class="position-relative">
                                        <div class="upload-picture-container mb-0">
                                            <div class="upload-camera-container text-center">
                                                <span class="camera">
                                                    <img src="<?php echo e(asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                        alt="Camera Icon" />
                                                </span>
                                            </div>
                                        </div>
                                        <input class="scan-prompt" type="file" accept="image/*" />
                                    </div>
                                </div>
                                <!--Car Registration ID Upload Container End-->

                                <div class="text-center car-registration-container">
                                    <h4>FRONT</h4>
                                </div>
                                <div class="text-center car-registration-container">
                                    <h4>BACK</h4>
                                </div>
                            </div>
                        </div>
                        <!--Car Registration Info Container End-->
                    <?php else: ?>
                        <div class="text-center">
                            <p>No vehicle information available for this driver.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/vehicle.blade.php ENDPATH**/ ?>