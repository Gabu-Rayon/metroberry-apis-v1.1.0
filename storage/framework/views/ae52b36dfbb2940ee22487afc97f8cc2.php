<form action="<?php echo e(route('organisation.destroy', $organisation->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete <?php echo e($organisation->user->name); ?></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to delete <?php echo e($organisation->user->name); ?>?
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
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/organisation/delete.blade.php ENDPATH**/ ?>