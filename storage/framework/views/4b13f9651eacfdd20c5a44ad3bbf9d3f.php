<form action="<?php echo e(route('refueling.station.edit', $station->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Fuelling Station</h4>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">
                        Name
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="name" class="form-control" type="text" placeholder="Name" id="name"
                            required value="<?php echo e($station->user->name); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="station_code" class="col-sm-5 col-form-label">
                        Station Code
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="station_code" class="form-control" type="text" placeholder="Station Code"
                            id="station_code" required value="<?php echo e($station->station_code); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="phone" class="col-sm-5 col-form-label">
                        Phone
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="phone" class="form-control" type="text" placeholder="Phone" id="phone"
                            required value="<?php echo e($station->user->phone); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="avatar" class="col-sm-5 col-form-label">
                        Logo
                    </label>
                    <div class="col-sm-7">
                        <input name="avatar" class="form-control" type="file" placeholder="Logo" id="avatar"
                            value="" />
                        <img src="<?php echo e(url('storage/' . $station->user->avatar)); ?>" alt="Logo" class="form-control" />
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="email" class="col-sm-5 col-form-label">
                        Email
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="email" class="form-control" type="email" placeholder="Email" id="email"
                            required value="<?php echo e($station->user->email); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="address" class="col-sm-5 col-form-label">
                        Address
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="address" class="form-control" type="text" placeholder="Address" id="address"
                            required value="<?php echo e($station->user->address); ?>" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="certificate_of_operations" class="col-sm-5 col-form-label">
                        Certificate of Operations
                    </label>
                    <div class="col-sm-7">
                        <input name="certificate_of_operations" class="form-control" type="file"
                            placeholder="Certificate of Operations" id="certificate_of_operations" value="" />
                        <?php if($station->certificate_of_operations): ?>
                            <div class="mt-2">
                                <a href="<?php echo e(url('storage/' . $station->certificate_of_operations)); ?>" download>Download
                                    Certificate of Operations</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="payment_period" class="col-sm-5 col-form-label">
                        Payment Period
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="payment_period" class="form-control" id="payment_period" required>
                            <option value="">Select Payment Period</option>
                            <option value="daily" <?php if($station->payment_period == 'daily'): ?> selected <?php endif; ?>>Daily</option>
                            <option value="weekly" <?php if($station->payment_period == 'weekly'): ?> selected <?php endif; ?>>Weekly</option>
                            <option value="monthly" <?php if($station->payment_period == 'monthly'): ?> selected <?php endif; ?>>Monthly</option>
                            <option value="quarterly" <?php if($station->payment_period == 'quarterly'): ?> selected <?php endif; ?>>Quarterly
                            </option>
                            <option value="biannually" <?php if($station->payment_period == 'biannually'): ?> selected <?php endif; ?>>Bi-Annually
                            </option>
                            <option value="annually" <?php if($station->payment_period == 'annually'): ?> selected <?php endif; ?>>Annually
                            </option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Save</button>
        </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/refueling/station/edit.blade.php ENDPATH**/ ?>