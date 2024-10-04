<?php $__env->startSection('title', 'Insurances Recurring Periods'); ?>

<?php $__env->startSection('content'); ?>
    <div class="fixed sidebar-mini">
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
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Insurance Recurring Period Lists
                                                </h6>
                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#recurringPeriodModal">
                                                    <i class="fa-solid fa-user-plus"></i>&nbsp; Add Recurring Period
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Period">Period</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Description">Description</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $recurringPeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($period->period); ?></td>
                                                            <td>
                                                                <?php if($period->status): ?>
                                                                    <i class="fas fa-check-circle text-success"
                                                                        title="Active"></i>
                                                                <?php else: ?>
                                                                    <i class="fas fa-times-circle text-danger"
                                                                        title="Inactive"></i>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo e($period->description); ?></td>
                                                            <td class="d-flex">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                                                    onclick="axiosModal('/vehicle/insurance/recurring-period/<?php echo e($period->id); ?>/edit')">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <span class='m-1'></span>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete insurance company')): ?>
                                                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                                        onclick="deleteVehicle(<?php echo e($period->id); ?>)">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="recurringPeriodModal" tabindex="-1"
                        aria-labelledby="recurringPeriodModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="<?php echo e(route('vehicle.insurance.recurring.period.create.store')); ?>" method="POST"
                                class="needs-validation modal-content" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="card-header my-3 p-2 border-bottom">
                                    <h4>Add Recurring Period</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">
                                            <div class="form-group row my-2">
                                                <label for="period" class="col-sm-5 col-form-label">Period <i
                                                        class="text-danger">*</i></label>
                                                <div class="col-sm-7">
                                                    <input name="period" class="form-control" type="text"
                                                        placeholder="Period" id="period" value="<?php echo e(old('period')); ?>"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="form-group row my-2">
                                                <label for="description" class="col-sm-5 col-form-label">Description</label>
                                                <div class="col-sm-7">
                                                    <textarea name="description" class="form-control" placeholder="Description" id="description"><?php echo e(old('description')); ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-lg-6">
                                            <div class="form-group row my-2">
                                                <label for="status" class="col-sm-5 col-form-label">Status</label>
                                                <div class="col-sm-7">
                                                    <select name="status" class="form-control" id="status" required>
                                                        <option value="1" <?php echo e(old('status') == '1' ? 'selected' : ''); ?>>
                                                            Active</option>
                                                        <option value="0" <?php echo e(old('status') == '0' ? 'selected' : ''); ?>>
                                                            Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-success" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/insurance/recurring-period/index.blade.php ENDPATH**/ ?>