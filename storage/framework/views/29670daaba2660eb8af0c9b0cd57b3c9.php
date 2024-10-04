<form action="<?php echo e(url('route/' . $route->id . '/delete')); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete <?php echo e($route->name); ?> ?</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">Are you sure you want to delete this route?</p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Delete</button>
    </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/route/delete.blade.php ENDPATH**/ ?>