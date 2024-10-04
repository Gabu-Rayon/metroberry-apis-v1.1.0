<?php $__env->startSection('title', 'Permission List'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Permission lists</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div
                                                        class="accordion-header d-flex justify-content-end align-items-center"id="flush-headingOne">
                                                        <?php if(\Auth::user()->can('create permission')): ?>
                                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('permission/create')">
                                                                <i class="fa fa-plus"></i>
                                                                &nbsp;
                                                                Add Permission
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Name">Name</th>
                                                            <th title="Guard">Guard</th>
                                                            <th title="Updated">Updated</th>
                                                            <th title="Actions">Actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($permission->name); ?></td>
                                                                <td><?php echo e($permission->guard_name); ?></td>
                                                                <td><?php echo e($permission->updated_at); ?></td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        <?php if(\Auth::user()->can('edit permission')): ?>
                                                                            <a href="javascript:void(0);"
                                                                                onclick="axiosModal('permission/<?php echo e($permission->id); ?>/edit')"
                                                                                class="btn btn-primary btn-sm">
                                                                                <i class="fa fa-edit fa-sm"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                        <?php if(\Auth::user()->can('delete permission')): ?>
                                                                            <a href="javascript:void(0);"
                                                                                onclick="axiosModal('permission/<?php echo e($permission->id); ?>/delete')"
                                                                                class="btn btn-danger btn-sm">
                                                                                <i class="fa fa-trash fa-sm"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="page-axios-data" data-table-id="#driver-table" data-create="admin/permission"
                                data-edit="admin/permission/edit" data-update="admin/permission"
                                data-only-groups="admin/permission/only-groups">
                            </div>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <!--end  vue page -->
        </div>
        <!-- END layout-wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="create-permission-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void();" class="needs-validation" id="create-permission-form">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="create-permission-group"
                                            class="col-lg-3 col-form-label ps-0 label_permission_group">
                                            Permission group
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 p-0">
                                            <select name="group" id="create-permission-group" class="form-control">
                                            </select>

                                        </div>
                                    </div>

                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="permission_name"
                                            class="col-lg-3 col-form-label ps-0 label_permission_name">
                                            Permission name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 p-0">
                                            <input type="text" class="form-control" name="name" id="permission_name"
                                                placeholder="Permission name " autocomplete required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-success" type="submit" id="create_submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Modal -->
        <div class="modal fade" id="edit-permission-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void();" class="needs-validation" id="update-permission-form">
                            <input type="hidden" name="id" id="update_permission_id">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="edit-permission-group"
                                            class="col-lg-3 col-form-label ps-0 label_permission_group">
                                            Permission group
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 p-0">
                                            <select name="group" id="edit-permission-group"
                                                class="form-control"></select>

                                        </div>
                                    </div>
                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="update_permission_name"
                                            class="col-lg-3 col-form-label ps-0 label_permission_name">
                                            Permission name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9 p-0">
                                            <input type="text" class="form-control" name="name"
                                                id="update_permission_name" placeholder="Permission name " autocomplete
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-success" type="submit" id="create_submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Modal -->
        <div class="modal fade" id="delete-permission-modal" data-bs-keyboard="false" tabindex="-1"
            data-bs-backdrop="true" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void();" class="needs-validation" id="delete-permission-modal-form">
                            <input type="hidden" name="id" id="update_permission_delete_id">
                            <div class="modal-body">
                                <p>You won&#039;t be able to revert this!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-success" type="submit" id="create_submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- Modal -->
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
                                <p>Are you sure you want to delete this item? you won t be able to revert this item back!
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/permission/index.blade.php ENDPATH**/ ?>