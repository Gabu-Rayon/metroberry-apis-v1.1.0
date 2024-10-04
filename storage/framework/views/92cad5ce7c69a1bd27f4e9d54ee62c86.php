<?php $__env->startSection('title', 'Trips Report'); ?>


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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Trips report</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Customer">Customer</th>
                                                            <th title="Driver">Driver</th>
                                                            <th title="Vehicle">Vehicle</th>
                                                            <th title="Status">Status</th>
                                                            <th title="Income">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($trip->customer->user->name); ?></td>
                                                                <td class="<?php echo e($trip->vehicle ? '' : 'text-center'); ?>">
                                                                    <?php echo e($trip->vehicle ? $trip->vehicle->driver->user->name : '-'); ?>

                                                                </td>
                                                                <td class="<?php echo e($trip->vehicle ? '' : 'text-center'); ?>">
                                                                    <?php echo e($trip->vehicle ? $trip->vehicle->plate_number : '-'); ?>

                                                                </td>
                                                                <td>
                                                                    <?php if($trip->status == 'scheduled'): ?>
                                                                        <span class="badge bg-secondary">Scheduled</span>
                                                                    <?php elseif($trip->status == 'billed'): ?>
                                                                        <span class="badge bg-success">Billed</span>
                                                                    <?php elseif($trip->status == 'completed'): ?>
                                                                        <span class="badge bg-info">Completed</span>
                                                                    <?php elseif($trip->status == 'cancelled'): ?>
                                                                        <span class="badge bg-danger">Cancelled</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning">Invalid Status</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="<?php echo e($trip->total_price ? '' : 'text-center'); ?>">
                                                                    <?php echo e($trip->total_price ?? '-'); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center font-bold"><strong>Total
                                                                    Income</strong></td>
                                                            <?php
                                                                $totalIncome = 0;
                                                                foreach ($trips as $trip) {
                                                                    $totalIncome += $trip->total_price;
                                                                }
                                                            ?>
                                                            <td class="text-center font-bold">
                                                                <strong><?php echo e($totalIncome); ?></strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/report/trip.blade.php ENDPATH**/ ?>