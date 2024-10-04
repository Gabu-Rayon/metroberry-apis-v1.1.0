<?php $__env->startSection('title', 'Vehicles Insurances'); ?>
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
                                            <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Insurances</h6>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <?php if(Auth::user()->can('export vehicle insurances')): ?>
                                                        <a class="btn btn-success btn-sm"
                                                            href="<?php echo e(route('vehicle.insurance.export')); ?>" title="Export">
                                                            <i class="fa-solid fa-file-export"></i>
                                                            &nbsp;Export
                                                        </a>
                                                    <?php endif; ?>
                                                    <span class="m-1"></span>
                                                    <?php if(Auth::user()->can('import vehicle insurances')): ?>
                                                        <a class="btn btn-success btn-sm"
                                                            href="<?php echo e(route('vehicle.insurance.import')); ?>" title="Import">
                                                            <i class="fa-solid fa-file-import"></i>
                                                            &nbsp;Import
                                                        </a>
                                                    <?php endif; ?>
                                                    <span class="m-1"></span>
                                                    <?php if(Auth::user()->can('create vehicle insurance')): ?>
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#vehicleInsuranceModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp; Add Vehicle
                                                            Insurance
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $__env->make('components.vehicles.insurances.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

        <div class="modal fade" id="vehicleInsuranceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('vehicle.insurance.store')); ?>" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Vehicle Insurance Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="insurance_company_id" class="col-sm-5 col-form-label">Company <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="insurance_company_id"
                                            id="insurance_company_id" required>
                                            <option value="">Select Company</option>
                                            <?php $__currentLoopData = $insuranceCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="insurance_policy_no" class="col-sm-5 col-form-label">Policy Number <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="insurance_policy_no" class="form-control" type="text"
                                            placeholder="Policy number" id="insurance_policy_no"
                                            value="<?php echo e(old('insurance_policy_no')); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="insurance_date_of_issue" class="col-sm-5 col-form-label">Start Date</label>
                                    <div class="col-sm-7">
                                        <input name="insurance_date_of_issue" class="form-control" type="date"
                                            id="insurance_date_of_issue" value="<?php echo e(old('insurance_date_of_issue')); ?>">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="recurring_period_id" class="col-sm-5 col-form-label">Recurring Period <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="recurring_period_id"
                                            id="recurring_period_id" required>
                                            <option value="">Select Recurring Period</option>
                                            <?php $__currentLoopData = $recurringPeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($period->id); ?>"><?php echo e($period->period); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="reminder" class="col-sm-5 col-form-label">Add Reminder</label>
                                    <div class="col-sm-7">
                                        <select name="reminder" id="reminder" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="status" class="col-sm-5 col-form-label">Status</label>
                                    <div class="col-sm-7">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="remarks" class="col-sm-5 col-form-label">Remarks</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="remark" id="remarks" cols="30" rows="3"><?php echo e(old('remark')); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row mb-1">
                                    <label for="vehicle_id" class="col-sm-5 col-form-label">Vehicle <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="vehicle_id" id="vehicle_id"
                                            required>
                                            <option value="">Select Vehicle</option>
                                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->model); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="charges_payable" class="col-sm-5 col-form-label">Charge Payable <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="charges_payable" class="form-control" type="number" step="any"
                                            placeholder="Charge payable" id="charges_payable"
                                            value="<?php echo e(old('charges_payable')); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="insurance_date_of_expiry" class="col-sm-5 col-form-label">End Date</label>
                                    <div class="col-sm-7">
                                        <input name="insurance_date_of_expiry" class="form-control" type="date"
                                            id="insurance_date_of_expiry" value="<?php echo e(old('insurance_date_of_expiry')); ?>">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="recurring_date" class="col-sm-5 col-form-label">Recurring Date</label>
                                    <div class="col-sm-7">
                                        <input name="recurring_date" class="form-control" type="date"
                                            id="recurring_date" value="<?php echo e(old('recurring_date')); ?>">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="deductible" class="col-sm-5 col-form-label">Deductible <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="deductible" class="form-control" type="number" step="any"
                                            placeholder="Deductible" id="deductible" value="<?php echo e(old('deductible')); ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="policy_document" class="col-sm-5 col-form-label">Policy Document <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input type="file" name="policy_document" id="policy_document" required
                                            onchange="get_img_url(this, '#document_image');">
                                        <img id="document_image" src="" width="120px" class="mt-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/insurance/index.blade.php ENDPATH**/ ?>