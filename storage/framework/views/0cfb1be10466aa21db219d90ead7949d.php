

<?php $__env->startSection('title', 'Homepage | Customer'); ?>
<?php $__env->startSection('content'); ?>
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12 remaining-height">

            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <span class="title">Homepage : Booked Trips</span>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon">
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="all-history-items remaining-height">
                    <!-- Check if there are trips booked -->
                    <?php if($trips->isEmpty()): ?>
                        <div class="text-center">
                            <p>No booked trips found.</p>
                            <a href="<?php echo e(route('customer.book.trip.page')); ?>" class="btn btn-primary text-uppercase">Book A
                                Trip</a>
                        </div>
                    <?php else: ?>
                        <!-- Loop through booked trips -->

                        <div class="history-items-container history-items-padding">
                            <!--Support Button Start-->
                            <div class="p-1">
                                <a href="<?php echo e(route('customer.book.trip.page')); ?>" class="btn btn-primary text-uppercase">Book
                                    A Trip</a>
                            </div>
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
                        <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!--Support Button End-->
                            <div class="history-items-container history-items-padding">
                                <div class="history-item">
                                    <!--Date and Price Container Start-->
                                    <div class="border-bottom-primary thin">
                                        <div class="status-container">
                                            <div class="date float-left">
                                                Date : <?php echo e(\Carbon\Carbon::parse($trip->trip_date)->format('d M Y')); ?>,
                                                <?php if($customer->time_format === '12-hour'): ?>
                                                    Time : <?php echo e(\Carbon\Carbon::parse($trip->pick_up_time)->format('h:i A')); ?>

                                                    <!-- 12-hour format -->
                                                <?php else: ?>
                                                    Time : <?php echo e(\Carbon\Carbon::parse($trip->pick_up_time)->format('H:i')); ?>

                                                    <!-- 24-hour format -->
                                                <?php endif; ?>
                                            </div>
                                            <div class="status-none float-right text-uppercase">
                                                Charges : Kes <?php echo e(number_format($trip->total_price, 2)); ?>

                                                <!-- Format charges -->
                                            </div>
                                            <div class="status-none float-right text-uppercase">
                                                <?php
                                                    $statusColors = [
                                                        'scheduled' => 'text-success',
                                                        'completed' => 'text-primary',
                                                        'billed' => 'text-warning',
                                                        'paid' => 'text-info',
                                                        'partially paid' => 'text-muted',
                                                        'assigned' => 'text-secondary',
                                                        'cancelled' => 'text-danger',
                                                    ];
                                                    $statusClass = $statusColors[$trip->status] ?? 'text-dark';
                                                ?>
                                                Status : <span class="<?php echo e($statusClass); ?>"><?php echo e($trip->status); ?></span>
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
                                                    <input class="controls flex-1 font-weight-light" type="text"
                                                        placeholder="Enter an origin location"
                                                        value="<?php echo e($trip->route->start_location->name ?? 'N/A'); ?>" disabled>


                                                </div>
                                            </div>
                                            <a href="#" class="href-decoration-none">
                                                <div class="w-100 map-input-container map-input-container-bottom">
                                                    <span class="map-input-icon"><img
                                                            src="<?php echo e(asset('mobile-app-assets/icons/circle.svg')); ?>"
                                                            alt="Current Location Icon"></span>
                                                    <div class="map-input display-flex controls flex-1 align-items-center">

                                                        <?php echo e($trip->route->end_location->name ?? 'N/A'); ?>

                                                    </div>
                                                    <span class="dotted-line"></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!--Trip Details Address Container End-->

                                    <!--trip History Button Start-->
                                    
                                    <!--trip History Button End-->
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/customer-app/index.blade.php ENDPATH**/ ?>