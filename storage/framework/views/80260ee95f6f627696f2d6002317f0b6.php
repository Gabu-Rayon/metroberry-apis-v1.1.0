

<?php $__env->startSection('title', 'Speed Governor | Driver'); ?>
<?php $__env->startSection('content'); ?>
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    <?php
        $driver = Auth::user()->driver;
    ?>

    <div class="row h-100">
        <?php
            $user = Auth::user();
            $driver = $user->driver;
            $isUpdate = isset($driver->vehicle->speedGovernorCertificate);
            $route = $isUpdate
                ? route('driver.registration.speed.governor.update', $driver->vehicle->speedGovernorCertificate->id)
                : route('driver.registration.speed.governor.store');
            $method = $isUpdate ? 'PUT' : 'POST';
        ?>
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="text-center header-icons-container">
                <a href="<?php echo e(route('driver.vehicle.docs.registration')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <?php if($driver->status == 'inactive'): ?>
                    <span>Account Deactivated</span>
                <?php else: ?>
                    <span>Speed Governor</span>
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
                        <span>Speed Governors</span>

                        <?php if($driver->vehicle->speedGovernorCertificate): ?>
                            <?php if($driver->vehicle->speedGovernorCertificate->status == 'active'): ?>
                                <span class="badge badge-pill fs-6 badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-pill fs-6 badge-danger">Inactive</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge badge-pill fs-6 badge-danger">Inactive</span>
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

                <div class="all-container all-container-with-classes">
                    <form class="width-100"
                        action="<?php echo e($driver->vehicle->speedGovernorCertificate ? route('driver.registration.speed.governor.update', $driver->vehicle->speedGovernorCertificate->id) : route('driver.registration.speed.governor.store')); ?>"
                        method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if($driver->vehicle->speedGovernorCertificate): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php else: ?>
                            <?php echo method_field('POST'); ?>
                        <?php endif; ?>


                        <input class="form-control form-control-with-padding" type="hidden" name="driver_speed_governor_vehicle_id"
                            autocomplete="off" placeholder="Vehicle ID"
                            value="<?php echo e(old('driver_speed_governor_vehicle_id', $driver->vehicle->id)); ?>" readonly />

                        <div class="form-group form-control-margin">
                            

                            <label class="label-title">Vehicle</label>

                            <div class="#">
                                <?php echo e($driver->vehicle->plate_number ?? 'N/A'); ?>:
                                <?php echo e(optional($driver->vehicle->manufacturer)->name ?? ''); ?>

                                <?php echo e($driver->vehicle->model ?? ''); ?>

                                
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->
                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Certificate No</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driver_speed_governor_certificate_no" autocomplete="on" placeholder="Driver Certificate No"
                                    value="<?php echo e(old('driver_speed_governor_certificate_no', $driver->vehicle->speedGovernorCertificate->certificate_no ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!-- Upload Certificate Copy -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="driver_speed_governor_certificate_copy" id="certificate-copy-input" />
                                    </span>
                                    <span class="text-uppercase">Certificate Copy</span>
                                    <span class="delete-btn" id="certificate-copy-delete">
                                        <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img id="certificate-copy-preview"
                                                        src="<?php echo e($driver->vehicle->speedGovernorCertificate->certificate_copy ?? asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                        alt="Speed Governor Certificate Copy" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                         <!--Input Field Container End-->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Class A*(4 seater) </span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_speed_governor_class_no">
                                        <option value="A"
                                            <?php echo e(old('driver_speed_governor_class_no', $driver->vehicle->speedGovernorCertificate->class_no ?? '') == 'A' ? 'selected' : ''); ?>>
                                            A</option>
                                        <option value="B"
                                            <?php echo e(old('driver_speed_governor_class_no', $driver->vehicle->speedGovernorCertificate->class_no ?? '') == 'B' ? 'selected' : ''); ?>>
                                            B</option>
                                    </select>
                                </span>
                            </label>
                        </div>

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Chasis No</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text" name="driver_vehicle_chasis_no"
                                    autocomplete="on" placeholder="Driver Class No"
                                    value="<?php echo e(old('driver_vehicle_chasis_no', $driver->vehicle->speedGovernorCertificate->chasis_no ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Date of Installation</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_speed_governor_date_of_installation" autocomplete="on"
                                    placeholder="Date of Installation"
                                    value="<?php echo e(old('driver_speed_governor_date_of_installation', $vehicle->speedGovernorCertificate->date_of_installation ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Expiry Date</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_speed_governor_expiry_date" autocomplete="on" placeholder="Expiry Date"
                                    value="<?php echo e(old('driver_speed_governor_expiry_date', $vehicle->speedGovernorCertificate->expiry_date ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Type Of Speed Governor</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driver_speed_governor_type" autocomplete="on"
                                    placeholder="Type Of Speed Governor"
                                    value="<?php echo e(old('driver_speed_governor_type', $driver->vehicle->speedGovernorCertificate->type_of_governor ?? '')); ?>" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <div class="form-submit-button text-center">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                <?php echo e($isUpdate ? 'Update' : 'Register'); ?>

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
                <span class="light-gray font-weight-light"></span>
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

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
            };
            reader.readAsDataURL(file);
        }

        document.getElementById('certificate-copy-input').addEventListener('change', function(event) {
            previewImage(event, 'certificate-copy-preview');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/speed-governor-registration.blade.php ENDPATH**/ ?>