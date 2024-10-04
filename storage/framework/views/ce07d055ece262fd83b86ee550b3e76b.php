<?php $__env->startSection('title', 'Completed Trips List'); ?>
<?php $__env->startSection('content'); ?>

    <body class="fixed sidebar-mini">

        <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div id="app">
            <div class="wrapper">
                <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="content-wrapper">
                    <div class="main-content">
                        <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Completed Trips List</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            </div>
                                        </div>

                                        <div>
                                            <div class="table-responsive">
                                                <?php if($groupByOrganisation): ?>
                                                    <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisationName => $tripsGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <h5><?php echo e($organisationName); ?></h5>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Customer</th>
                                                                    <th>Driver</th>
                                                                    <th>Vehicle</th>
                                                                    <th>Route</th>
                                                                    <th>Pick Up Time</th>
                                                                    <th>Date</th>
                                                                    <th>Pick Up Location</th>
                                                                    <th>Drop Off Location</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__empty_1 = true; $__currentLoopData = $tripsGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <?php echo e($trip->customer->user->name ?? 'N/A'); ?></td>
                                                                        <td class="text-center">
                                                                            <?php if($trip->vehicle && $trip->vehicle->driver): ?>
                                                                                <?php echo e($trip->vehicle->driver->user->name ?? 'Unassigned'); ?>

                                                                            <?php else: ?>
                                                                                <span
                                                                                    class="btn btn-danger btn-sm">Unassigned</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php if($trip->vehicle): ?>
                                                                                <span
                                                                                    class="btn btn-success btn-sm"><?php echo e($trip->vehicle->plate_number); ?></span>
                                                                            <?php else: ?>
                                                                                <span
                                                                                    class="btn btn-danger btn-sm">Unassigned</span>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php echo e($trip->route->name ?? 'N/A'); ?></td>
                                                                        <td class="text-center"><?php echo e($trip->pick_up_time); ?>

                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php echo e(\Carbon\Carbon::parse($trip->trip_date)->format('F j, Y')); ?>

                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                                $location = match (
                                                                                    $trip->pick_up_location
                                                                                ) {
                                                                                    'Home' => $trip->customer->user
                                                                                        ->address ?? 'N/A',
                                                                                    'Office' => $trip->customer
                                                                                        ->organisation->user->address ??
                                                                                        'N/A',
                                                                                    default
                                                                                        => $trip->route->route_locations
                                                                                        ->where(
                                                                                            'id',
                                                                                            $trip->pick_up_location,
                                                                                        )
                                                                                        ->first()->name ?? 'N/A',
                                                                                };
                                                                            ?>
                                                                            <?php echo e($location); ?>

                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php
                                                                                $location = match (
                                                                                    $trip->drop_off_location
                                                                                ) {
                                                                                    'Home' => $trip->customer->user
                                                                                        ->address ?? 'N/A',
                                                                                    'Office' => $trip->customer
                                                                                        ->organisation->user->address ??
                                                                                        'N/A',
                                                                                    default
                                                                                        => $trip->route->route_locations
                                                                                        ->where(
                                                                                            'id',
                                                                                            $trip->drop_off_location,
                                                                                        )
                                                                                        ->first()->name ?? 'N/A',
                                                                                };
                                                                            ?>
                                                                            <?php echo e($location); ?>

                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    <tr>
                                                                        <td colspan="8" class="text-center">No completed
                                                                            trips available.</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <th>Driver</th>
                                                                <th>Vehicle</th>
                                                                <th>Route</th>
                                                                <th>Pick Up Time</th>
                                                                <th>Date</th>
                                                                <th>Pick Up Location</th>
                                                                <th>Drop Off Location</th>
                                                                <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'organisation'): ?>
                                                                    <th title="Action" width="150">Action</th>
                                                                <?php endif; ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__empty_1 = true; $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php echo e($trip->customer->user->name ?? 'N/A'); ?></td>
                                                                    <td class="text-center">
                                                                        <?php if($trip->vehicle && $trip->vehicle->driver): ?>
                                                                            <?php echo e($trip->vehicle->driver->user->name ?? 'Unassigned'); ?>

                                                                        <?php else: ?>
                                                                            <span
                                                                                class="btn btn-danger btn-sm">Unassigned</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if($trip->vehicle): ?>
                                                                            <span
                                                                                class="btn btn-success btn-sm"><?php echo e($trip->vehicle->plate_number); ?></span>
                                                                        <?php else: ?>
                                                                            <span
                                                                                class="btn btn-danger btn-sm">Unassigned</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php echo e($trip->route->name ?? 'N/A'); ?></td>
                                                                    <td class="text-center"><?php echo e($trip->pick_up_time); ?></td>
                                                                    <td class="text-center">
                                                                        <?php echo e(\Carbon\Carbon::parse($trip->trip_date)->format('F j, Y')); ?>

                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                            $location = match (
                                                                                $trip->pick_up_location
                                                                            ) {
                                                                                'Home' => $trip->customer->user
                                                                                    ->address ?? 'N/A',
                                                                                'Office' => $trip->customer
                                                                                    ->organisation->user->address ??
                                                                                    'N/A',
                                                                                default => $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->pick_up_location,
                                                                                    )
                                                                                    ->first()->name ?? 'N/A',
                                                                            };
                                                                        ?>
                                                                        <?php echo e($location); ?>

                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                            $location = match (
                                                                                $trip->drop_off_location
                                                                            ) {
                                                                                'Home' => $trip->customer->user
                                                                                    ->address ?? 'N/A',
                                                                                'Office' => $trip->customer
                                                                                    ->organisation->user->address ??
                                                                                    'N/A',
                                                                                default => $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->drop_off_location,
                                                                                    )
                                                                                    ->first()->name ?? 'N/A',
                                                                            };
                                                                        ?>
                                                                        <?php echo e($location); ?>

                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if(auth()->user()->can('add billing details')): ?>
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm btn-primary"
                                                                                onclick="axiosModal('<?php echo e($trip->id); ?>/details')"
                                                                                title="Details">
                                                                                <i class="fa-solid fa-circle-info"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                        <span class='m-1'></span>
                                                                        <?php if($trip->is_billable()): ?>
                                                                            <?php if(auth()->user()->can('bill trip')): ?>
                                                                                <a href="javascript:void(0);"
                                                                                    onclick="axiosModal('/trip/<?php echo e($trip->id); ?>/bill')"
                                                                                    class="btn btn-warning btn-sm"
                                                                                    title="Bill">
                                                                                    <i class="fa fa-file text-white"></i>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No completed
                                                                        trips available.</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                <?php endif; ?>
                                            </div>

                                            <div id="page-axios-data" data-table-id="#driver-table"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="delete-form" method="POST" action="">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <div class="mb-3">
                                <p>Are you sure you want to delete this item?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/trips/completed.blade.php ENDPATH**/ ?>