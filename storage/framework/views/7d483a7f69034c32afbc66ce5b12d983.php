<form action="<?php echo e(route('vehicle.inspection.certificate.verify', $certificate->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Verify <?php echo e($certificate->vehicle->plate_number); ?>'s Inspection Certificate</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to verify <?php echo e($certificate->vehicle->make); ?> <?php echo e($certificate->vehicle->model); ?>,
                <?php echo e($certificate->vehicle->plate_number); ?>'s Inspection Certificate?
            </p>
            <p class="text-center">
                Make sure you have verified all of the details and documents
            </p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Verify</button>
    </div>
</form>
<?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/vehicle/inspection-certificates/verify.blade.php ENDPATH**/ ?>