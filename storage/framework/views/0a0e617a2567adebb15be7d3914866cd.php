<form action="<?php echo e(route('route.location.store')); ?>" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Route location</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="route" class="col-sm-5 col-form-label">
                        Route
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="route" id="route" class="form-control" required>
                            <option value="">Select Route</option>
                            <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($route->id); ?>"><?php echo e($route->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="type" class="col-sm-5 col-form-label">
                        Type
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="start-location"
                                value="start_location" required>
                            <label class="form-check-label" for="start-location">
                                Start Location
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="end-location"
                                value="end_location" required>
                            <label class="form-check-label" for="end-location">
                                End Location
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="waypoint"
                                value="waypoint" required>
                            <label class="form-check-label" for="waypoint">
                                Waypoint
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">
                        Name
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="name" class="form-control" type="text" placeholder="Name" id="name"
                            required />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="point_order" class="col-sm-5 col-form-label">
                        Point Order
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="point_order" class="form-control" type="number" placeholder="Point Order"
                            id="point_order" disabled />
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Save</button>
        </div>
</form>

<script>
    const pointOrder = document.getElementById('point_order');
    const routeLocationType = document.querySelectorAll('input[name="type"]');

    routeLocationType.forEach((type) => {
        type.addEventListener('change', (e) => {
            if (e.target.value === 'waypoint') {
                pointOrder.removeAttribute('disabled');
            } else {
                pointOrder.setAttribute('disabled', 'disabled');
            }
        });
    });
</script>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/route/locations/create.blade.php ENDPATH**/ ?>