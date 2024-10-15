

<?php $__env->startSection('title', 'Trips Booked | Customer'); ?>

<?php $__env->startSection('content'); ?>
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">

        <?php
            $user = Auth::user();
            $customer = $user->customer;
        ?>
        <?php
            $user = Auth::user();
            $customer = $user->customer;
        ?>
        <div class="col-xs-12 col-sm-12 remaining-height">

            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="<?php echo e(route('customer.index.page')); ?>">
                    <span class="float-left">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon" />
                    </span>
                </a>
                <span class="title"> Trips | Booked</span>

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
                        <?php if($customer->status == 'inactive'): ?>
                            <div
                                class="request-notification-container map-notification offline-notification map-notification-warning">
                                Your account is inactive
                                <div class="font-weight-light">Contact your administrator</div>
                            </div>
                        <?php else: ?>
                            <!-- Trips Booked -->
                            <div
                                class="request-notification-container map-notification meters-left-450 map-notification-warning">
                                <h3>Booked Trips</h3>
                                <div class="all-history-items remaining-height">
                                    <!-- Check if there are trips booked -->
                                    <?php if($trips->isEmpty()): ?>
                                        <div class="text-center">
                                            <p>No booked trips found.</p>
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
                                                                <?php if($customer->time_format === '12-hour'): ?>
                                                                    Time :
                                                                    <?php echo e(\Carbon\Carbon::parse($trip->pick_up_time)->format('h:i A')); ?>

                                                                    <!-- 12-hour format -->
                                                                <?php else: ?>
                                                                    Time :
                                                                    <?php echo e(\Carbon\Carbon::parse($trip->pick_up_time)->format('H:i')); ?>

                                                                    <!-- 24-hour format -->
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="status-none float-right text-uppercase">
                                                                Charges Kes <?php echo e(number_format($trip->total_price, 2)); ?>

                                                                <!-- Format charges -->
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                    <!--Date and Price Container End-->

                                                    <!--Trips Details Address Container Start-->
                                                    <div class="addresses-container position-relative">
                                                        <div class="height-auto">
                                                            <div class="w-100 map-input-container map-input-container-top">
                                                                <span
                                                                    class="fas fa-location-arrow location-icon-rotate map-input-icon"></span>
                                                                <div class="map-input display-flex">
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
                                                                    <input class="controls flex-1 font-weight-light"
                                                                        type="text"
                                                                        placeholder="Enter an origin location"
                                                                        value="<?php echo e($location ?? 'N/A'); ?>" disabled>
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
                                                                                $trip->drop_off_location === 'Home'
                                                                                    ? $trip->customer->user->address
                                                                                    : ($trip->drop_off_location ===
                                                                                    'Office'
                                                                                        ? $trip->customer->organisation
                                                                                            ->user->address
                                                                                        : $trip->route->route_locations
                                                                                            ->where(
                                                                                                'id',
                                                                                                $trip->drop_off_location,
                                                                                            )
                                                                                            ->first()->name);
                                                                        ?>
                                                                        <?php echo e($location ?? 'N/A'); ?>

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
                            <!-- End of Trips Booked -->
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!--Main Menu Start-->
            <?php echo $__env->make('components.customer-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--Main Menu End-->

        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/customer-app/trips-booked.blade.php ENDPATH**/ ?>