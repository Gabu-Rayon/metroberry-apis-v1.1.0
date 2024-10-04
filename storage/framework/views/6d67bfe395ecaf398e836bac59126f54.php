<?php $__env->startSection('title', 'Assigned Trips'); ?>
<?php $__env->startSection('content'); ?>

    <body class="fixed sidebar-mini">

        <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- react page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- start header -->
                <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- end header -->
                <div class="content-wrapper">
                    <div class="main-content">
                        <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Assigned Trips</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Name">Customer</th>
                                                            <th title="Location">Driver</th>
                                                            <th title="NoOfEmployee">Vehicle</th>
                                                            <th title="Registration date">Route</th>
                                                    
                                                            <th title="Email">Pick Up</th>
                                                            <th title="Email">Drop Off</th>
                                                             <th title="Email">Actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        
                                                            <?php $__currentLoopData = $assignedTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php echo e($trip->customer->user->name); ?></td>
                                                                    <td class="text-center">
                                                                        <?php if($trip->vehicle): ?>
                                                                            <?php echo e($trip->vehicle->driver->user->name); ?>

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
                                                                    <td class="text-center"><?php echo e($trip->route->name); ?></td>
                                                                   
                                                                    <td class="text-center">
                                                                        <?php
                                                                            $location = null;
                                                                            if ($trip->pick_up_location == 'Home') {
                                                                                $location =
                                                                                    $trip->customer->user->address;
                                                                            } elseif (
                                                                                $trip->pick_up_location == 'Office'
                                                                            ) {
                                                                                $location =
                                                                                    $trip->customer->organisation->user
                                                                                        ->address;
                                                                            } else {
                                                                                $location = $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->pick_up_location,
                                                                                    )
                                                                                    ->first()->name;
                                                                            }
                                                                        ?>
                                                                        <?php echo e($location); ?>

                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                            $location = null;
                                                                            if ($trip->drop_off_location == 'Home') {
                                                                                $location =
                                                                                    $trip->customer->user->address;
                                                                            } elseif (
                                                                                $trip->drop_off_location == 'Office'
                                                                            ) {
                                                                                $location =
                                                                                    $trip->customer->organisation->user
                                                                                        ->address;
                                                                            } else {
                                                                                $location = $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->drop_off_location,
                                                                                    )
                                                                                    ->first()->name;
                                                                            }
                                                                        ?>
                                                                        <?php echo e($location); ?>

                                                                    </td>
                                                                      <?php if(auth()->user()->role == 'admin'): ?>
                                                                            <td class="text-center">
                                                                                <a href="javascript:void(0);"
                                                                                    onclick="axiosModal('/trip/<?php echo e($trip->id); ?>/cancel')"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    title="Cancel">
                                                                                    <i class="fa fa-times"></i>
                                                                                </a>
                                                                                <span class='m-1'></span>
                                                                                <a href="javascript:void(0);"
                                                                                    onclick="axiosModal('/trip/<?php echo e($trip->id); ?>/complete')"
                                                                                    class="btn btn-primary btn-sm"
                                                                                    title="Complete">
                                                                                    <i class="fa fa-check"></i>
                                                                                </a>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                    </tbody>
                                                </table>
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
            <!--end  vue page -->
        </div>
        <!-- END layout-wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form">
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item? you won t be able to revert this item back!
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-danger" type="submit" id="delete_submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/trips/assigned.blade.php ENDPATH**/ ?>