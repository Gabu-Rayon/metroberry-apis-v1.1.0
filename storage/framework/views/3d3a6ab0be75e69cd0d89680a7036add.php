<?php $__env->startSection('title', 'Fuelling Report'); ?>

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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Fuelling report</h6>
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
                                                            <th title="Requested By">Requested By</th>
                                                            <th title="Station">Station</th>
                                                            <th title="Status">Status</th>
                                                            <th title="Income">Expense</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $fuels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fuel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($fuel->vehicle->plate_number); ?></td>
                                                                <td><?php echo e($fuel->creator->name); ?></td>
                                                                <td><?php echo e($fuel->refuellingStation->name); ?></td>
                                                                <td>
                                                                    <?php if($fuel->status == 'pending'): ?>
                                                                        <span class="badge bg-secondary">Pending</span>
                                                                    <?php elseif($fuel->status == 'billed'): ?>
                                                                        <span class="badge bg-success">Billed</span>
                                                                    <?php elseif($fuel->status == 'approved'): ?>
                                                                        <span class="badge bg-info">Approved</span>
                                                                    <?php elseif($fuel->status == 'rejected'): ?>
                                                                        <span class="badge bg-danger">Rejected</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning">Invalid Status</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td
                                                                    class="<?php echo e($fuel->refuelling_cost ? '' : 'text-center'); ?>">
                                                                    <?php echo e($fuel->refuelling_cost ?? '-'); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center font-bold"><strong>Total
                                                                    Expenses</strong></td>
                                                            <?php
                                                                $totalExpense = 0;
                                                                foreach ($fuels as $fuel) {
                                                                    if ($fuel->status == 'billed') {
                                                                        $totalExpense += $fuel->refuelling_cost;
                                                                    }
                                                                }
                                                            ?>
                                                            <td class="text-center font-bold">
                                                                <strong><?php echo e($totalExpense); ?></strong>
                                                            </td>
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
        </div>
        </div>
        </div>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/report/fuel.blade.php ENDPATH**/ ?>