

<?php $__env->startSection('title', 'Speed Governor Certificates'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div id="app">
        <div class="wrapper">
            <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="content-wrapper">
                <div class="main-content">
                    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="body-content">
                        <div class="tile">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fs-17 fw-semi-bold mb-0">Speed Governor Certificates</h6>
                                        <div class="text-end">
                                            <?php if(Auth::user()->can('export vehicle speed governors')): ?>
                                                <a class="btn btn-success btn-sm" href="<?php echo e(route('vehicle.speed.governor.export')); ?>"
                                                    title="Export">
                                                    <i class="fa-solid fa-file-export"></i>
                                                    &nbsp;
                                                    Export
                                                </a>
                                            <?php endif; ?>
                                            <span class='m-1'></span>
                                            <?php if(Auth::user()->can('import vehicles')): ?>
                                                <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('<?php echo e(route('vehicle.speed.governor.import')); ?>')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                            <?php endif; ?>
                                            <span class='m-1'></span>
                                            <?php if(Auth::user()->can('create vehicle')): ?>
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#certificateModal">
                                                    <i class="fa-solid fa-user-plus"></i>&nbsp; Add Speed Governor Certificate
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="driver-table">
                                            <thead>
                                                <tr>
                                                    <th>Vehicle</th>
                                                    <th>Certificate No</th>
                                                    <th>Type</th>
                                                    <th>Installation Date</th>
                                                    <th>Expiry Date</th>
                                                    <?php if(Auth::user()->role == 'admin'): ?>
                                                        <th>Action</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $speed_governors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speed_governor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo e($speed_governor->vehicle->model); ?> <?php echo e($speed_governor->vehicle->make); ?>, <?php echo e($speed_governor->vehicle->plate_number); ?></td>
                                                        <td><?php echo e($speed_governor->certificate_no); ?></td>
                                                        <td><?php echo e($speed_governor->type_of_governor); ?></td>
                                                        <td><?php echo e($speed_governor->date_of_installation); ?></td>
                                                        <td><?php echo e($speed_governor->expiry_date); ?></td>
                                                        <?php if(Auth::user()->role == 'admin'): ?>
                                                            <td class="text-center">
                                                                <?php if(\Auth::user()->can('edit vehicle speed governor')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('speed-governor/<?php echo e($speed_governor->id); ?>/edit')"
                                                                        title="Edit Certificate">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if($speed_governor->status == 'active'): ?>
                                                                    <?php if(\Auth::user()->can('deactivate vehicle speed governor')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('speed-governor/<?php echo e($speed_governor->id); ?>/deactivate')"
                                                                            title="Deactivate Certificate">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if(\Auth::user()->can('activate vehicle speed governor')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('speed-governor/<?php echo e($speed_governor->id); ?>/activate')"
                                                                            title="Activate Certificate">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(\Auth::user()->can('delete vehicle speed governor')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('speed-governor/<?php echo e($speed_governor->id); ?>/delete')"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
                <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <!-- end vue page -->
    </div>
    <!-- END layout-wrapper -->

    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="<?php echo e(route('vehicle.speed.governor.create')); ?>" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Add New Certificate</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="vehicle_id" class="col-sm-5 col-form-label">Select Vehicle</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="vehicle_id"
                                        id="vehicle_id" tabindex="-1" aria-hidden="true">
                                        <option value="">Please Select Vehicle</option>
                                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vehicle->id); ?>" <?php echo e(old('vehicle_id') == $vehicle->id ? 'selected' : ''); ?>>
                                                <?php echo e($vehicle->make); ?>, <?php echo e($vehicle->model); ?>, <?php echo e($vehicle->plate_number); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="class_no" class="col-sm-5 col-form-label">Class</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="class_no"
                                        id="class_no" tabindex="-1" aria-hidden="true">
                                        <option value="">Select Class</option>
                                        <option value="A" <?php echo e(old('class_no') == 'A' ? 'selected' : ''); ?>>A</option>
                                        <option value="B" <?php echo e(old('class_no') == 'B' ? 'selected' : ''); ?>>B</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row my-2">
                                <label for="installation_date" class="col-sm-5 col-form-label">
                                    Installation Date
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="installation_date" class="form-control" type="date"
                                        placeholder="Installation Date" id="installation_date" value="<?php echo e(old('installation_date')); ?>">
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="copy" class="col-sm-5 col-form-label">
                                    Copy
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="copy" class="form-control" type="file" id="copy" value="<?php echo e(old('copy')); ?>" required>
                                </div>
                            </div>                            
                        </div>

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="certificate_no" class="col-sm-5 col-form-label">
                                    Certificate No
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="certificate_no" class="form-control" type="text" placeholder="Enter Certificate No" id="certificate_no" value="<?php echo e(old('certificate_no')); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="type" class="col-sm-5 col-form-label">
                                    Type
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="type" class="form-control" type="text" placeholder="Enter Type" id="type" value="<?php echo e(old('type')); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="expiry_date" class="col-sm-5 col-form-label">
                                    Expiry Date
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="expiry_date" class="form-control" type="date"
                                        placeholder="Expiry Date" id="expiry_date" value="<?php echo e(old('expiry_date')); ?>">
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="chasis_no" class="col-sm-5 col-form-label">
                                    Chasis No
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="chasis_no" class="form-control" type="text" placeholder="Enter Chasis No" id="chasis_no" value="<?php echo e(old('chasis_no')); ?>" required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle-speed-governor-certificates/index.blade.php ENDPATH**/ ?>