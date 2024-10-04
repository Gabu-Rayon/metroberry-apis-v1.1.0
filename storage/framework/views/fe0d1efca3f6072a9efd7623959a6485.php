<form action="<?php echo e(route('maintenance.service.approve', $service->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Approve Service</h4>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Vehicle
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->vehicle->plate_number); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Type
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->serviceType->name); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Date
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->service_date); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Description
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->service_description); ?></div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Vehicle
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->vehicle->plate_number); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Service Category
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->serviceCategory->name); ?></div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Cost
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control"><?php echo e($service->service_cost); ?></div>
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
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/maintenance-services/approve.blade.php ENDPATH**/ ?>