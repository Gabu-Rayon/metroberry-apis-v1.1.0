<form action="<?php echo e(route('refueling.station.activate', $station->id)); ?>" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Activate <?php echo e($station->user->name); ?></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to activate <?php echo e($station->user->name); ?> Station?
            </p>

            <p class="text-center">
                Make sure you have verified all of their details and documents
            </p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit">Activate</button>
    </div>
</form>

<script>
    const form = document.querySelector('#activate');
    console.log(form);
</script>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/refueling/station/activate.blade.php ENDPATH**/ ?>