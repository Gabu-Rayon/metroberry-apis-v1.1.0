<form action="<?php echo e(route('vehicle.insurance.recurring.period.update', $period->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Insurance Recurring Period</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="period" class="col-sm-5 col-form-label">Period <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="period" class="form-control" type="text" placeholder="Period" id="period"
                            value="<?php echo e(old('period', $period->period)); ?>" required>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">Description</label>
                    <div class="col-sm-7">
                        <textarea name="description" class="form-control" placeholder="Description" id="description" required><?php echo e(old('description', $period->description)); ?></textarea>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="status" class="col-sm-5 col-form-label">Status</label>
                    <div class="col-sm-7">
                        <select name="status" class="form-control" id="status" required>
                            <option value="1" <?php echo e(old('status', $period->status) == '1' ? 'selected' : ''); ?>>Active
                            </option>
                            <option value="0" <?php echo e(old('status', $period->status) == '0' ? 'selected' : ''); ?>>
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
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/insurance/recurring-period/edit.blade.php ENDPATH**/ ?>