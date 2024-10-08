<form action="<?php echo e(url('trip/' . $trip->id . '/cancel')); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Confirm trip cancellation</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">Are you sure you want to cancel this trip?</p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="danger">Cancel</button>
    </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/trips/cancel.blade.php ENDPATH**/ ?>