<?php $__env->startSection('title', 'Dashboard'); ?>
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
                            <?php echo $__env->make('components.dashboard.organisations-card-stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <div class="row mb-4">
                                <div class="col-xl-12 mb-4 mb-xl-0">
                                    <div class="card rounded-0">
                                        <div class="card-header card_header px-3">
                                            <div class="d-lg-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Trips Report</h6>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="card-body px-2">
                                            <?php echo $venDiagram->container(); ?>

                                            <?php echo $venDiagram->script(); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 2nd  -->
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
        </div>
    </body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/organisation/dashboard.blade.php ENDPATH**/ ?>