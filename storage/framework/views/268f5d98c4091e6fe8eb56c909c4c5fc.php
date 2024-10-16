<form action="<?php echo e(route('billed.trip.recieve.payment.store', $trip->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Payment</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="payment_date" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="payment_date" class="form-control" type="date" placeholder="Payment Date"
                            id="payment_date" required value=" <?php echo e(old('payment_date')); ?>">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="amount" class="col-sm-5 col-form-label">Amount <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="amount" autocomplete="off" required class="form-control" type="number"
                            placeholder="Amount" id="amount" value="<?php echo e($remainingAmount); ?>">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="account_name" class="col-sm-5 col-form-label">Account</label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single select2" name="account_id" id="account_id"
                            tabindex="-1" aria-hidden="true">
                            <option value="">Please Select Account</option>
                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($account->id); ?>"><?php echo e($account->holder_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">Description <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <textarea name="remark" class="form-control" placeholder="Enter Description" id="description" required><?php echo e(old('remark')); ?></textarea>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="reference" class="col-sm-5 col-form-label">Reference <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="reference" class="form-control" type="text" placeholder="Reference"
                            id="reference" required value="<?php echo e(old('reference')); ?>">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="payment_receipt" class="col-sm-5 col-form-label">Payment Receipt <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="payment_receipt" class="form-control" type="file"
                            placeholder="Upload Payment Receipt" id="payment_receipt" required
                            value="<?php echo e(old('payment_receipt')); ?>">
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
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/trips/billed-receive-payment.blade.php ENDPATH**/ ?>