<?php $__env->startSection('title', 'Vehicles Report'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicles Report</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Vehicle">Vehicle</th>
                                                            <th title="Driver">Driver</th>
                                                            <th title="Total Trips">Total Trips</th>
                                                            <th title="Total Repairs">Total Repairs</th>
                                                            <th title="Total Services">Total Services</th>
                                                            <th title="Total Refuellings">Total Refuellings</th>
                                                            <th title="Total Income">Total Income</th>
                                                            <th title="Total Expenses">Total Expenses</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($vehicle->plate_number); ?></td>
                                                                <td class="<?php echo e($vehicle->driver ? '' : 'text-center'); ?>">
                                                                    <?php echo e($vehicle->driver ? $vehicle->driver->user->name : '-'); ?>

                                                                </td>
                                                                <td class="text-center"><?php echo e($vehicle->trips->count()); ?></td>
                                                                <td class="text-center"><?php echo e($vehicle->repairs->count()); ?>

                                                                </td>
                                                                <td class="text-center"><?php echo e($vehicle->services->count()); ?>

                                                                </td>
                                                                <td class="text-center"><?php echo e($vehicle->refuellings->count()); ?>

                                                                </td>
                                                                <td class="text-center">
                                                                    <?php echo e($vehicle->trips->where('status', 'billed')->sum('total_price')); ?>

                                                                </td>
                                                                <td class="text-center">
                                                                    <?php echo e($vehicle->refuellings->where('status', 'billed')->sum('refuelling_cost') + $vehicle->repairs->where('status', 'billed')->sum('repair_cost') + $vehicle->services->where('status', 'billed')->sum('service_cost')); ?>

                                                                </td>
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
        <!-- start scripts -->
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/report/vehicle.blade.php ENDPATH**/ ?>