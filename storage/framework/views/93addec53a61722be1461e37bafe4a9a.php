<form action="/vehicle/<?php echo e($vehicle->id); ?>/delete" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete <?php echo e($vehicle->model); ?></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to delete <?php echo e($vehicle->model); ?>?
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
        <button class="btn btn-success" type="submit">Delete</button>
    </div>
</form>

<script>
    const form = document.querySelector('#activate');
    console.log(form);
</script>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/delete.blade.php ENDPATH**/ ?>