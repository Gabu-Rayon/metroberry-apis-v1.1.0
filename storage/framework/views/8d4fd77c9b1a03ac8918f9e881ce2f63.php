<form action="<?php echo e(route('employee.destroy', $customer->id)); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete <?php echo e($customer->user->name); ?> Customer </h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">Are you sure you want to delete <?php echo e($customer->user->name); ?>'s Customer Details ?
            </p>
            <br>
            <p class="text-center text-danger">
                This action can not be undone. Do you want to continue !

            </p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Delete</button>
    </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/employee/delete.blade.php ENDPATH**/ ?>