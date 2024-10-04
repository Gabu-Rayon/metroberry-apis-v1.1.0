<?php $__env->startSection('title', 'Create Role'); ?>
<?php $__env->startSection('content'); ?>

    <body class="fixed sidebar-mini">
        <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- react page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- start header -->
                <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- end header -->
                <div class="content-wrapper">
                    <div class="main-content">
                        <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Create new role</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <a href="<?php echo e(route('permission.role')); ?>" class="btn btn-success btn-sm">
                                                        <i class="fa fa-list"></i>
                                                        &nbsp;Role list
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <form enctype="multipart/form-data"
                                            action="<?php echo e(route('permission.role.store')); ?>" method="POST"
                                            class="needs-validation" enctype="multipart/form-data">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                            <div class=" row">
                                                <div class="col-md-12">
                                                    <div class="form-group pt-1 pb-1">
                                                        <label for="name" class="font-black">Role name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" placeholder="Enter role name" value=""
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 pt-1 pb-1">
                                                    <div>
                                                        <h5
                                                            class="border-bottom py-1 mx-1 mb-0 font-medium-2 font-black mt-5">
                                                            <i class="feather icon-lock mr-50 "></i>
                                                            Permission
                                                        </h5>
                                                        <div class="row mt-1">
                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Settings Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $settingPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Dashboard Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $dashboardPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Employee Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $employeePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Organisation Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $organisationPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Drivers Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $driversPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Driver's License Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $licensePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Driver's PSV Badge
                                                                        Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $psv_badgePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Driver Performance
                                                                        Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $driver_performancePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Vehicle Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $vehiclePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Vehicle Insurance
                                                                        Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $vehicle_insurancePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Route Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $routePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Route Location Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $route_locationPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Trip Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $tripPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Insurance Company
                                                                        Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $insurance_companyPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <fieldset>
                                                                    <legend>
                                                                        Vehicle Maintenance
                                                                        Permissions
                                                                    </legend>
                                                                    <div class="row py-3">

                                                                        <?php $__currentLoopData = $vehicle_maintenancePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <div class="col-md-4 form-group">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" role="switch"
                                                                                        id="<?php echo e($permission->permission_name); ?>"
                                                                                        name="<?php echo e($permission->permission_name); ?>"
                                                                                        value="<?php echo e($permission->id); ?>">
                                                                                    <label class="form-check-label"
                                                                                        for="<?php echo e($permission->permission_name); ?>">
                                                                                        <?php echo e($permission->permission_name); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </div>
                                                                </fieldset>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 ">
                                                    <div class="form-group pt-1 pb-1 text-center">
                                                        <button type="submit"
                                                            class="btn btn-success btn-round">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overlay"></div>
                        <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <!--end  vue page -->
            </div>
            <!--end  vue page -->
        </div>
        <!-- END layout-wrapper -->
    <?php $__env->stopSection(); ?>
    <!-- Modal -->
    <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form">
                        <div class="modal-body">
                            <p>Are you sure you want to delete this item? you won t be able to revert this item
                                back!
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-danger" type="submit" id="delete_submit">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- start scripts -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/role/create.blade.php ENDPATH**/ ?>