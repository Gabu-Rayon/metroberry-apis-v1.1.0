<form action="/vehicle/insurance/company/<?php echo e($company->id); ?>/activateStore" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Activate <?php echo e($company->name); ?></h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to Activate <?php echo e($company->name); ?>?
            </p>

            <p class="text-center">
                Make sure you have verified all of the details and documents
            </p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Activate</button>
    </div>
</form>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/insurance/company/activate.blade.php ENDPATH**/ ?>