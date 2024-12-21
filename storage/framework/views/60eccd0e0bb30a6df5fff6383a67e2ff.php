

<?php $__env->startSection('title', 'Trips Assigned | Driver'); ?>

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
        <?php
            $user = Auth::user();
            $driver = $user->driver;
        ?>
        <div class="col-xs-12 col-sm-12 remaining-height">

            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="<?php echo e(route('trips.history.page')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <span class="title"> Trips | Assigned</span>

                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="all-history-items remaining-height">
                    <div class="change-request-status">



                        <!-- Trips Assigned -->
                        <div
                            class="request-notification-container map-notification meters-left-450 map-notification-warning">
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
                                                                <?php
                                                                    $location =
                                                                        $trip->drop_off_location === 'Home'
                                                                            ? $trip->customer->user->address
                                                                            : ($trip->drop_off_location === 'Office'
                                                                                ? $trip->customer->organisation->user
                                                                                    ->address
                                                                                : $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->drop_off_location,
                                                                                    )
                                                                                    ->first()->name);
                                                                ?>
                                                                <input class="controls flex-1 font-weight-light"
                                                                    type="text" placeholder="Enter an origin location"
                                                                    value="<?php echo e($location); ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="href-decoration-none">
                                                            <div
                                                                class="w-100 map-input-container map-input-container-bottom">
                                                                <span class="map-input-icon"><img
                                                                        src="<?php echo e(asset('mobile-app-assets/icons/circle.svg')); ?>"
                                                                        alt="Current Location Icon"></span>
                                                                <div
                                                                    class="map-input display-flex controls flex-1 align-items-center">
                                                                    <?php
                                                                        $location =
                                                                            $trip->pick_up_location === 'Home'
                                                                                ? $trip->customer->user->address
                                                                                : ($trip->pick_up_location === 'Office'
                                                                                    ? $trip->customer->organisation
                                                                                        ->user->address
                                                                                    : $trip->route->route_locations
                                                                                        ->where(
                                                                                            'id',
                                                                                            $trip->pick_up_location,
                                                                                        )
                                                                                        ->first()->name);
                                                                    ?>
                                                                    <?php echo e($location); ?>

                                                                </div>
                                                                <span class="dotted-line"></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!--Trip Details Address Container End-->

                                                <!--Trip Complete / Cancel Buttons Container-->

                                                <div class="trip-buttons-container">
                                                    <a href="<?php echo e(route('trip.complete', $trip->id)); ?>"
                                                        class="btn btn-success m-2 float-end text-uppercase">Complete</a>
                                                    <a href="<?php echo e(route('trip.cancel', $trip->id)); ?>"
                                                        class="btn btn-danger m-2 float-end text-uppercase">Cancel</a>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- End of Assgined Completed -->
                    </div>
                </div>
            </div>      

            <!--Main Menu Start-->
            <?php echo $__env->make('components.driver-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--Main Menu End-->

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
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/driver-app/trips-assigned.blade.php ENDPATH**/ ?>