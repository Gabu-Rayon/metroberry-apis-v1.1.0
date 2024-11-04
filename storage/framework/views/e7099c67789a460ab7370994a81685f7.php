

<?php $__env->startSection('title', 'Metroberry | Driver'); ?>
<?php $__env->startSection('content'); ?>
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <?php
            $user = Auth::user();
            $driver = $user->driver;
        ?>

        <div class="col-xs-12 col-sm-12 remaining-height">
            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <span class="float-left back-to-map hidden">
                    <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                </span>
                <?php if($driver->status == 'inactive'): ?>
                    <span class="title">Account | Inactive</span>
                <?php else: ?>
                    <span class="title">Account | Active</span>
                <?php endif; ?>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <!--All Notifications & Status Container Start-->
            <div class="change-request-status">
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

                <?php if($driver->status == 'inactive'): ?>
                    <div class="request-notification-container map-notification offline-notification map-notification-warning">
                        Your account is inactive
                        <div class="font-weight-light">Contact your administrator</div>
                    </div>
                <?php endif; ?>

                <!-- Always show document upload forms below -->
                <?php if(!$driver->national_id_front_avatar || !$driver->national_id_behind_avatar): ?>
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your national ID pictures
                        </span>
                        <form action="<?php echo e(route('driver.personal-documents', $driver->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="national_id_front_avatar" class="form-label">National ID Front Picture</label>
                                <input type="file" id="national_id_front_avatar" name="national_id_front_avatar" required>
                            </div>
                            <div class="mb-3">
                                <label for="national_id_back_avatar" class="form-label">National ID Back Picture</label>
                                <input type="file" id="national_id_back_avatar" name="national_id_back_avatar" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">
                        National ID is valid
                    </div>
                <?php endif; ?>

                <?php if($driver->driverLicense): ?>
                    <?php if(!$driver->driverLicense->verified): ?>
                        <div class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your license has not been verified.
                            <div class="font-weight-light">Contact your administrator</div>
                        </div>
                    <?php else: ?>
                        <div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your license has been verified.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your Driver's License
                        </span>
                        <form action="<?php echo e(route('driver.license')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="driving_license_no" class="form-label">License No.</label>
                                <input type="text" id="driving_license_no" name="driving_license_no" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="issue_date" class="form-label">Issue Date</label>
                                <input type="date" id="issue_date" name="issue_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="expiry_date" name="expiry_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="license_front_avatar" class="form-label">License Front Picture</label>
                                <input type="file" id="license_front_avatar" name="license_front_avatar" required>
                            </div>
                            <div class="mb-3">
                                <label for="license_back_avatar" class="form-label">License Back Picture</label>
                                <input type="file" id="license_back_avatar" name="license_back_avatar" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Repeat similar structure for PSV Badge and Assigned Trips -->

            </div>
        </div>

        <!--Main Menu Start-->
        <?php echo $__env->make('components.driver-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--Main Menu End-->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/dashboard.blade.php ENDPATH**/ ?>