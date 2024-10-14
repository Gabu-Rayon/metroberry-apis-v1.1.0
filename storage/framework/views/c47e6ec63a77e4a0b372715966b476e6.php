<form action="<?php echo e(route('vehicle.insurance.update', $vehicleInsurance->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Vehicle Insurance Details</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="company_id" class="col-sm-5 col-form-label">Company Name <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single" name="insurance_company_id" id="insurance_company_id"
                            tabindex="-1" aria-hidden="true" required>
                            <option value="">Select Company</option>
                            <?php $__currentLoopData = $insuranceCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($company->id); ?>"
                                    <?php echo e($company->id == $vehicleInsurance->insurance_company_id ? 'selected' : ''); ?>>
                                    <?php echo e($company->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="policy_number" class="col-sm-5 col-form-label">Policy Number <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="insurance_policy_no" class="form-control" type="text"
                            placeholder="Policy number" id="policy_number"
                            value="<?php echo e($vehicleInsurance->insurance_policy_no); ?>" required>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="start_date" class="col-sm-5 col-form-label">Start Date</label>
                    <div class="col-sm-7">
                        <input name="insurance_date_of_issue" class="form-control" type="date"
                            placeholder="Start date" id="start_date"
                            value="<?php echo e($vehicleInsurance->insurance_date_of_issue); ?>">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="recurring_period_id" class="col-sm-5 col-form-label">Recurring Period <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single" name="recurring_period_id" id="recurring_period_id"
                            tabindex="-1" aria-hidden="true" required>
                            <option value="">Select Recurring Period</option>
                            <?php $__currentLoopData = $recurringPeriods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($period->id); ?>"
                                    <?php echo e($period->id == $vehicleInsurance->recurring_period_id ? 'selected' : ''); ?>>
                                    <?php echo e($period->period); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="add_reminder" class="col-sm-5 col-form-label">Add Reminder</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="reminder" id="reminder">
                            <option value="1" <?php echo e($vehicleInsurance->reminder == 1 ? 'selected' : ''); ?>>Yes</option>
                            <option value="0" <?php echo e($vehicleInsurance->reminder == 0 ? 'selected' : ''); ?>>No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="status" class="col-sm-5 col-form-label">Status</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="status" id="status">
                            <option value="1" <?php echo e($vehicleInsurance->status == 1 ? 'selected' : ''); ?>>Active
                            </option>
                            <option value="0" <?php echo e($vehicleInsurance->status == 0 ? 'selected' : ''); ?>>Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="remarks" class="col-sm-5 col-form-label">Remarks</label>
                    <div class="col-sm-7">
                        <textarea class="form-control" name="remark" id="remarks" cols="30" rows="3"><?php echo e($vehicleInsurance->remark); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="form-group row mb-1">
                    <label for="vehicle_id" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single" name="vehicle_id" id="vehicle_id" tabindex="-1"
                            aria-hidden="true" required>
                            <option value="">Select Vehicle</option>
                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($vehicle->id); ?>"
                                    <?php echo e($vehicle->id == $vehicleInsurance->vehicle_id ? 'selected' : ''); ?>>
                                    <?php echo e($vehicle->model); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="charge_payable" class="col-sm-5 col-form-label">Charge Payable <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="charges_payable" class="form-control"
                            value="<?php echo e($vehicleInsurance->charges_payable); ?>" required>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="end_date" class="col-sm-5 col-form-label">End Date</label>
                    <div class="col-sm-7">
                        <input name="insurance_date_of_expiry" class="form-control" type="date"
                            placeholder="insurance date of expiry" id="end_date"
                            value="<?php echo e($vehicleInsurance->insurance_date_of_expiry); ?>">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="recurring_date" class="col-sm-5 col-form-label">Recurring Date</label>
                    <div class="col-sm-7">
                        <input name="recurring_date" class="form-control" type="date"
                            placeholder="Recurring date" id="recurring_date"
                            value="<?php echo e($vehicleInsurance->recurring_date); ?>">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="deductible" class="col-sm-5 col-form-label">Deductible <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="deductible" class="form-control" type="number" step="any"
                            placeholder="Deductible" id="deductible" value="<?php echo e($vehicleInsurance->deductible); ?>"
                            required>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="policy_document" class="col-sm-5 col-form-label">Policy Document <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-7">
                        <input type="file" name="policy_document" id="policy_document"
                            onchange="get_img_url(this, '#document_image');">
                        <?php if($vehicleInsurance->policy_document): ?>
                            <a href="<?php echo e(asset('images/' . $vehicleInsurance->policy_document)); ?>"
                                target="_blank">View Current Document</a>
                        <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle/insurance/edit.blade.php ENDPATH**/ ?>