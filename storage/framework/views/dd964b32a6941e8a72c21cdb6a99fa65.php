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
                    <img src=" <?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                </span>
                <?php if($driver->status == 'inactive'): ?>
                    <span class="title">Account | Inactive</span>
                <?php else: ?>
                    <span class="title">Account | Active</span>
                <?php endif; ?>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src=" <?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <!--All Notifications & Status Container Start-->
            <div class="change-request-status">
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
                        <form action="<?php echo e(route('driver.personal-documents')); ?>" method="POST" enctype="multipart/form-data">
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
                    <div class="request-notification-container map-notification offline-notification map-notification-warning">
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
                        <div class="request-notification-container map-notification offline-notification map-notification-warning">
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

                <?php if($driver->psvBadge): ?>
                    <?php if(!$driver->psvBadge->verified): ?>
                        <div class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your PSV Badge has not been verified.
                            <div class="font-weight-light">Contact your administrator</div>
                        </div>
                    <?php else: ?>
                        <div class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your PSV Badge has been verified.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your PSV Badge
                        </span>
                        <form action="<?php echo e(route('driver.psvbadge',$driver->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="psv_badge_no" class="form-label">Badge No.</label>
                                <input type="text" id="psv_badge_no" name="psv_badge_no" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="psv_issue_date" class="form-label">Issue Date</label>
                                <input type="date" id="psv_issue_date" name="psv_issue_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="psv_expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="psv_expiry_date" name="psv_expiry_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="badge_copy" class="form-label">Copy</label>
                                <input type="file" id="badge_copy" name="badge_copy" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if(!$driver->vehicle): ?>
                    <div class="request-notification-container map-notification offline-notification map-notification-warning">
                        You have not been assigned a vehicle
                        <div class="font-weight-light">Contact your administrator</div>
                    </div>
                <?php endif; ?>


                <!-- Trips Assigned -->
                <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                    <h3>Assigned Trips</h3>
                    <div class="all-history-items remaining-height">
                        <!-- Check if there are trips booked -->
                        <?php if($trips->isEmpty()): ?>
                            <div class="text-center">
                                <p>No Assigned trips found.</p>
                            </div>
                        <?php else: ?>
                            <!-- Loop through booked trips -->
                            <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="history-items-container history-items-padding">
                                    <div class="history-item">
                                        <!--Date and Price Container Start-->
                                        <div class="border-bottom-primary thin">
                                            <div class="status-container">
                                                <div class="date float-left">
                                                    Date :
                                                    <?php echo e(\Carbon\Carbon::parse($trip->trip_date)->format('d M Y')); ?>,
                                                    <?php if($driver->time_format === '12-hour'): ?>
                                                        Time :
                                                        <?php echo e(\Carbon\Carbon::parse($trip->pick_up_time)->format('h:i A')); ?>

                                                        <!-- 12-hour format -->
                                                    <?php else: ?>
                                                        Time :
                                                        <?php echo e(\Carbon\Carbon::parse($trip->pick_up_time)->format('H:i')); ?>

                                                        <!-- 24-hour format -->
                                                    <?php endif; ?>
                                                </div>
                                                <br>
                                                <div class="status-none float-right text-uppercase">
                                                    Charges Kes <?php echo e(number_format($trip->total_price, 2)); ?>

                                                    <!-- Format charges -->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="addresses-container position-relative">
                                            Customer : <?php echo e($trip->customer->user->name); ?>

                                            <br>
                                            Route : <?php echo e($trip->route->name); ?>

                                        </div>
                                        <!--Trips Details Address Container Start-->
                                        <div class="addresses-container position-relative">
                                            <div class="height-auto">
                                                <div class="w-100 map-input-container map-input-container-top">
                                                    <span
                                                        class="fas fa-location-arrow location-icon-rotate map-input-icon"></span>
                                                    <div class="map-input display-flex">
                                                        <input class="controls flex-1 font-weight-light" type="text"
                                                            placeholder="Enter an origin location"
                                                            value="<?php echo e($trip->drop_off_location); ?>" disabled>
                                                    </div>
                                                </div>
                                                <a href="#" class="href-decoration-none">
                                                    <div class="w-100 map-input-container map-input-container-bottom">
                                                        <span class="map-input-icon"><img
                                                                src="<?php echo e(asset('mobile-app-assets/icons/circle.svg')); ?>"
                                                                alt="Current Location Icon"></span>
                                                        <div
                                                            class="map-input display-flex controls flex-1 align-items-center">
                                                            <?php echo e($trip->pick_up_location); ?>

                                                        </div>
                                                        <span class="dotted-line"></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!--Trip Details Address Container End-->
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- End of Assgined Completed -->
            </div>
        </div>

        <!--Main Menu Start-->
        <?php echo $__env->make('components.driver-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!--Main Menu End-->
    </div>
    <!--Terms And Conditions Agreement Container End-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/driver-app/dashboard.blade.php ENDPATH**/ ?>