<form action="<?php echo e(route('refueling.redo-refuel', $refueling->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Redo Repair</h4>
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
                    <label for="refuelling_date" class="col-sm-5 col-form-label">
                        Date
                    </label>
                    <div class="col-sm-7">
                        <input type="date" class="form-control" id="refuelling_date" name="refuelling_date"
                            value="<?php echo e($refueling->refuelling_date); ?>">
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
                    <label for="attendant_name" class="col-sm-5 col-form-label">
                        Attendant Name
                    </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="attendant_name" name="attendant_name"
                            value="<?php echo e($refueling->attendant_name); ?>">
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
                    <label for="refuelling_time" class="col-sm-5 col-form-label">
                        Time
                    </label>
                    <div class="col-sm-7">
                        <input type="time" class="form-control" id="refuelling_time" name="refuelling_time"
                            value="<?php echo e($refueling->refuelling_time); ?>">
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
                    <label for="attendant_phone" class="col-sm-5 col-form-label">
                        Attendant Phone
                    </label>
                    <div class="col-sm-7">
                        <input type="tel" class="form-control" id="attendant_phone" name="attendant_phone"
                            value="<?php echo e($refueling->attendant_phone); ?>">
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Redo</button>
        </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/refueling/redo.blade.php ENDPATH**/ ?>