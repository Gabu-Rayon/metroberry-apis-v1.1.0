<form action="<?php echo e(route('refueling.approve', $refueling->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Approve Repair</h4>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Vehicle
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->vehicle->plate_number); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Date
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->refuelling_date); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Volume
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->refuelling_volume); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Attendant Name
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->attendant_name); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Creator
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->creator->name); ?></div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Station
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->refuellingStation->user->name); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Time
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->refuelling_time); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Cost
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->refuelling_cost); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Attendant Phone
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($refueling->attendant_phone); ?></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Approve</button>
        </div>
</form>
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/refueling/approve.blade.php ENDPATH**/ ?>