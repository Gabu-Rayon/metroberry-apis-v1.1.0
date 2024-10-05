

<?php $__env->startSection('title', 'Dashboard'); ?>
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
                            <?php echo $__env->make('components.dashboard.card-stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <div class="row mb-4">
                                <div class="col-xl-8 mb-4 mb-xl-0">
                                    <div class="card rounded-0">
                                        <div class="card-header card_header px-3">
                                            <div class="d-lg-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Maintenance Cost Report</h6>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="card-body px-2">
                                            <?php echo $maintenanceCostReport->container(); ?>

                                            <?php echo $maintenanceCostReport->script(); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card rounded-0">
                                        <div class="card-header card_header px-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Expense Report</h6>
                                            </div>
                                        </div>
                                        <div class="card-body p-0 px-2">
                                            <?php echo $expensePieChart->container(); ?>

                                            <?php echo $expensePieChart->script(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 2nd  -->
                            <div class="row mb-4">
                                <div class="col-xl-4 mb-4 mb-xl-0">
                                    <div class="card rounded-0 w-100">
                                        <div class="card-header card_header px-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Trips Report
                                                </h6>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="card-body w-100 p-0 px-2">
                                            <?php echo $venDiagram->container(); ?>

                                            <?php echo $venDiagram->script(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- new chart.js End -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fs-17 font-weight-600 mb-0">Reminder</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-borderless table-hover rounded-3 table-light">
                                            <thead>
                                                <tr>
                                                    <th class="py-3">Document Name</th>
                                                    <th class="py-3">Document Holder</th>
                                                    <th class="py-3">Current Status</th>
                                                    <th class="py-3">Issue Date</th>
                                                    <th class="py-3">Expiry Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $expiredInsurances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insurance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>Vehicle Insurance</td>
                                                        <td><?php echo e($insurance->vehicle->plate_number); ?></td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td><?php echo e($insurance->insurance_date_of_issue); ?></td>
                                                        <td><?php echo e($insurance->insurance_date_of_expiry); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $expiredInspectionCertificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>NTSA Inspection Certificate</td>
                                                        <td><?php echo e($certificate->vehicle->plate_number); ?></td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td><?php echo e($certificate->ntsa_inspection_certificate_date_of_issue); ?>

                                                        </td>
                                                        <td><?php echo e($certificate->ntsa_inspection_certificate_date_of_expiry); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $expiredLicenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>Driver's License</td>
                                                        <td><?php echo e($license->driver->user->name); ?></td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td><?php echo e($license->driving_license_date_of_issue); ?></td>
                                                        <td><?php echo e($license->driving_license_date_of_expiry); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $expiredPSVBadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>Driver's PSV Badges</td>
                                                        <td><?php echo e($badge->driver->user->name); ?></td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td><?php echo e($badge->psv_badge_date_of_issue); ?></td>
                                                        <td><?php echo e($badge->psv_badge_date_of_expiry); ?></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/dashboard.blade.php ENDPATH**/ ?>