

<?php $__env->startSection('title', 'Vehicles'); ?>
<?php $__env->startSection('content'); ?>

    <!-- No need for the body tag here; it's handled by the layout -->
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
                                        <h6 class="fs-17 fw-semi-bold mb-0">Vehicles</h6>
                                        <div class="text-end">
                                            <?php if(Auth::user()->can('export vehicles')): ?>
                                                <a class="btn btn-success btn-sm" href="<?php echo e(route('vehicle.export')); ?>"
                                                    title="Export">
                                                    <i class="fa-solid fa-file-export"></i>
                                                    &nbsp;
                                                    Export
                                                </a>
                                            <?php endif; ?>
                                            <span class='m-1'></span>
                                            <?php if(Auth::user()->can('import vehicles')): ?>
                                                <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('<?php echo e(route('vehicle.import')); ?>')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                            <?php endif; ?>
                                            <span class='m-1'></span>
                                            <?php if(Auth::user()->can('create vehicle')): ?>
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#vehicleModal">
                                                    <i class="fa-solid fa-user-plus"></i>&nbsp; Add Vehicle
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
                                                    <th>Driver</th>
                                                    <th>Make</th>
                                                    <th>Model</th>
                                                    <th>Plate Number</th>
                                                    <th>Seats</th>
                                                    <th>Fuel Type</th>
                                                    <th>Engine Size (CC)</th>
                                                    <th>Status</th>
                                                    <?php if(Auth::user()->role == 'admin'): ?>
                                                        <th>Action</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?php if($vehicle->driver && $vehicle->driver->user): ?>
                                                                <?php echo e($vehicle->driver->user->name); ?>

                                                            <?php else: ?>
                                                                <?php if(\Auth::user()->can('assign vehicle')): ?>
                                                                    <?php if($vehicle->status == 'active'): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-primary"
                                                                            onclick="axiosModal('/vehicle/<?php echo e($vehicle->id); ?>/assign/driver')">
                                                                            Assign Driver
                                                                        </a>
                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e($vehicle->make); ?></td>
                                                        <td><?php echo e($vehicle->model); ?></td>
                                                        <td><?php echo e($vehicle->plate_number); ?></td>
                                                        <td><?php echo e($vehicle->seats); ?></td>
                                                        <td><?php echo e($vehicle->fuel_type); ?></td>
                                                        <td><?php echo e($vehicle->engine_size); ?><i>CC</i></td>
                                                        <td>
                                                            <?php if($vehicle->status == 'active'): ?>
                                                                <span class="badge bg-success">Active</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">Inactive</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <?php if(Auth::user()->role == 'admin'): ?>
                                                            <td class="text-center">
                                                                <?php if(\Auth::user()->can('edit vehicle')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('/vehicle/<?php echo e($vehicle->id); ?>/edit')"
                                                                        title="Edit Vehicle">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if($vehicle->status == 'active'): ?>
                                                                    <?php if(\Auth::user()->can('deactivate vehicle')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('/vehicle/<?php echo e($vehicle->id); ?>/deactivate')"
                                                                            title="Deactivate Vehicle">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if(\Auth::user()->can('activate vehicle')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('/vehicle/<?php echo e($vehicle->id); ?>/activate')"
                                                                            title="Activate Vehicle">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(\Auth::user()->can('delete vehicle')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('/vehicle/<?php echo e($vehicle->id); ?>/delete')"
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

    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="/vehicle/store" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Add New Vehicle</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="model" class="col-sm-5 col-form-label">Vehicle Model <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="model" class="form-control" type="text" placeholder="Vehicle Model"
                                        id="model" value="<?php echo e(old('model')); ?>" required>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="make" class="col-sm-5 col-form-label">Vehicle Make <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="make" autocomplete="off" required class="form-control" type="text"
                                        placeholder="Vehicle Make" id="make" value="<?php echo e(old('make')); ?>">
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="year" class="col-sm-5 col-form-label">Vehicle Year of Manufacturer <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="year" class="form-control" type="date"
                                        placeholder="Year of Manufacturer" id="year" value="<?php echo e(old('year')); ?>">
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="vehicle_class" class="col-sm-5 col-form-label">Select Vehicle Class</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="vehicle_class"
                                        id="vehicle_class" tabindex="-1" aria-hidden="true">
                                        <option value="">Please Select Vehicle Class</option>
                                        <?php $__currentLoopData = $vehicleClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($class->name); ?>">Class <?php echo e($class->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="plate_number" class="col-sm-5 col-form-label">Vehicle Number Plate <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="plate_number" class="form-control" type="text"
                                        placeholder="Enter Number Plate" id="plate_number"
                                        value="<?php echo e(old('plate_number')); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="vehicle_avatar" class="col-sm-5 col-form-label">Vehicle Avatar <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="vehicle_avatar" class="form-control" type="file" id="vehicle_avatar"
                                        value="<?php echo e(old('vehicle_avatar')); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="fuel_type" class="form-control" type="text"
                                        placeholder="Enter Vehicle Fuel Type" id="fuel_type"
                                        value="<?php echo e(old('fuel_type')); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="engine_size" class="col-sm-5 col-form-label">Engine Size <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="engine_size" class="form-control" type="number"
                                        placeholder="Enter Engine Size" id="engine_size"
                                        value="<?php echo e(old('engine_size')); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="color" class="col-sm-5 col-form-label">Vehicle Color <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="color" class="form-control" type="text"
                                        placeholder="Enter Vehicle Color" id="color" value="<?php echo e(old('color')); ?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="seats" class="col-sm-5 col-form-label">No of Seats <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="seats" class="form-control" type="number" placeholder="No of Seats"
                                        id="seats" value="<?php echo e(old('seats')); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="organisation_id" class="col-sm-5 col-form-label">Select Vehicle Org</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="organisation_id"
                                        id="organisation_id" tabindex="-1" aria-hidden="true">
                                        <option value="">Please Select Vehicle Organisation</option>
                                        <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($organisation->id); ?>">
                                                <?php echo e($organisation->user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle/index.blade.php ENDPATH**/ ?>