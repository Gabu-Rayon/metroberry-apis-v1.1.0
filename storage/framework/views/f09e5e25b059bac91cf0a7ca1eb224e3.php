<?php $__env->startSection('title', 'Employees Report'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Employee report</h6>
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
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Name">Employee</th>
                                                            <th title="Organisation">Organisation</th>
                                                            <th title="Total Trips">Total Trips</th>
                                                            <th title="Cancelled Trips">Cancelled Trips</th>
                                                            <th title="Billed Trips">Billed Trips</th>
                                                            <th title="Total Income Generated">Total Income Generated</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($employee->user->name); ?></td>
                                                                <td><?php echo e($employee->customer_organisation_code); ?></td>
                                                                <td><?php echo e($employee->trips->count()); ?></td>
                                                                <td><?php echo e($employee->trips->where('status', 'cancelled')->count()); ?>

                                                                </td>
                                                                <td><?php echo e($employee->trips->where('status', 'billed')->count()); ?>

                                                                </td>
                                                                <td><?php echo e($employee->trips->where('status', 'billed')->sum('total_price')); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/report/employee.blade.php ENDPATH**/ ?>