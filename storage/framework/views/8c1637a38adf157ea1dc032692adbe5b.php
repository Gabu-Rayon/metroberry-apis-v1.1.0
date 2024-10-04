<?php $__env->startSection('title', 'Expenses'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- React page -->
    <div id="app">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- Start sidebar -->
            <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- End sidebar -->

            <div class="content-wrapper">
                <div class="main-content">
                    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="body-content">
                        <div class="tile">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fs-17 fw-semi-bold mb-0">Expenses</h6>
                                        <div class="actions">
                                            <div class="accordion-header d-flex justify-content-end align-items-center" id="flush-headingOne">
                                                <?php if(\Auth::user()->can('export expenses')): ?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo e(route('expenses.export')); ?>" title="Export to xlsx excel file">
                                                        <i class="fa-solid fa-file-export"></i> Export
                                                    </a>
                                                <?php endif; ?>
                                                <span class="m-1"></span>
                                                <?php if(\Auth::user()->can('import expenses')): ?>
                                                    <a class="btn btn-success btn-sm" href="<?php echo e(route('expenses.import')); ?>" title="Import from xlsx excel file">
                                                        <i class="fa-solid fa-file-import"></i> Import
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Category</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($expense->name); ?></td>
                                                    <td><?php echo e($expense->amount); ?></td>
                                                    <td><?php echo e($expense->category); ?></td>
                                                    <td><?php echo e($expense->entry_date); ?></td>
                                                    <td><?php echo e($expense->description); ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <?php if(\Auth::user()->can('edit expense')): ?>
                                                                <a href="<?php echo e(route('expenses.edit', $expense->id)); ?>" class="btn btn-primary btn-sm mr-1" title="Add Remark">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td class="text-right font-weight-bold"><strong>Total Amount:</strong></td>
                                                <td class="font-weight-bold"><strong>KES <?php echo e($totalAmount); ?></strong></td>
                                                <td colspan="4"></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                   </div>
                                    <div id="page-axios-data" data-table-id="#driver-table"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
                <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <!-- end vue page -->
    </div>
    <!-- END layout-wrapper -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/expenses/index.blade.php ENDPATH**/ ?>