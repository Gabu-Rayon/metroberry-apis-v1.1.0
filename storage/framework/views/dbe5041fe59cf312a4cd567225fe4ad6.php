<?php $__env->startSection('title', 'Refueling List'); ?>
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
                                        <h6 class="fs-17 fw-semi-bold mb-0">Refueling List</h6>
                                        <div class="text-end">

                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#refuellingModal">
                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                Refuel Vehicle
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table" id="driver-table">
                                            <thead>
                                                <tr>
                                                    <th title="Vehicle">Vehicle</th>
                                                    <th title="Station">Station</th>
                                                    <th title="Volume">Volume</th>
                                                    <th title="Cost">Cost</th>
                                                    <th title="Status">Status</th>
                                                    <th title="Action" width="80">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $__currentLoopData = $refuelings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refueling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($refueling->vehicle->plate_number); ?></td>
                                                        <td><?php echo e($refueling->refuellingStation->user->name); ?></td>
                                                        <td><?php echo e($refueling->refuelling_volume); ?></td>
                                                        <td><?php echo e($refueling->refuelling_cost); ?></td>
                                                        <td class="text-center">
                                                            <?php if($refueling->status == 'pending'): ?>
                                                                <span class="badge bg-secondary">Pending</span>
                                                            <?php elseif($refueling->status == 'billed'): ?>
                                                                <span class="badge bg-success">Billed</span>
                                                            <?php elseif($refueling->status == 'approved'): ?>
                                                                <span class="badge bg-info">Approved</span>
                                                            <?php elseif($refueling->status == 'rejected'): ?>
                                                                <span class="badge bg-danger">Rejected</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-warning">Invalid
                                                                    Status</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if($refueling->status == 'pending' || $refueling->status == 'approved'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('refueling.edit', $refueling->id)); ?>')"
                                                                    class="btn btn-info btn-sm" title="Edit">
                                                                    <i class="fa-solid fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if($refueling->status == 'billed' || $refueling->status == 'rejected'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('refueling.redo-refuel', $refueling->id)); ?>')"
                                                                    class="btn btn-secondary btn-sm" title="Redo Refuel">
                                                                    <i class="fa-solid fa-rotate-right"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if($refueling->status == 'pending'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('refueling.approve', $refueling->id)); ?>')"
                                                                    class="btn btn-primary btn-sm" title="Approve">
                                                                    <i class="fa-solid fa-thumbs-up"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('refueling.reject', $refueling->id)); ?>')"
                                                                    class="btn btn-warning btn-sm" title="Reject">
                                                                    <i class="fa-solid fa-ban"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if($refueling->status == 'approved'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('refueling.bill', $refueling->id)); ?>')"
                                                                    class="btn btn-primary btn-sm" title="Bill">
                                                                    <i class="fa-solid fa-money-bill"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if($refueling->status == 'pending' || $refueling->status == 'approved'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('refueling.delete', $refueling->id)); ?>')"
                                                                    class="btn btn-danger btn-sm" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div id="page-axios-data" data-table-id="#driver-table"></div>
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

    <div class="modal fade" id="refuellingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <form action="<?php echo e(route('refueling.create')); ?>" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Refueling List</h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="vehicle" class="col-sm-5 col-form-label">
                                    Vehicle
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="vehicle" class="form-control" id="vehicle" required>
                                        <option value="" disabled selected>Select a vehicle</option>
                                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->plate_number); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="date" class="col-sm-5 col-form-label">
                                    Date
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="date" class="form-control" type="date" id="date" required
                                        value=" <?php echo e(old('date')); ?>" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="volume" class="col-sm-5 col-form-label">
                                    Volume (L)
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="volume" class="form-control" type="number" id="volume" required
                                        value=" <?php echo e(old('volume')); ?>" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="attendant_name" class="col-sm-5 col-form-label">
                                    Attendant Name
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="attendant_name" class="form-control" type="text" id="attendant_name"
                                        required value=" <?php echo e(old('attendant_name')); ?>" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="creator_id" class="col-sm-5 col-form-label">
                                    Requested By
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="creator_id" class="form-control" id="creator_id" readonly>
                                        <option value="<?php echo e(auth()->user()->name); ?>" selected>
                                            <?php echo e(auth()->user()->name); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="station" class="col-sm-5 col-form-label">
                                    Station
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="station" class="form-control" id="station" required>
                                        <option value="" disabled selected>Select a Fuel Station</option>
                                        <?php $__currentLoopData = $stations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $station): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($station->id); ?>"><?php echo e($station->user->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="time" class="col-sm-5 col-form-label">
                                    Time
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="time" class="form-control" type="time" id="time" required
                                        value=" <?php echo e(old('time')); ?>" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="cost" class="col-sm-5 col-form-label">
                                    Cost
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="cost" class="form-control" type="number" id="cost" required
                                        value=" <?php echo e(old('cost')); ?>" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="attendant_phone" class="col-sm-5 col-form-label">
                                    Attendant Phone
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="attendant_phone" class="form-control" type="text"
                                        id="attendant_phone" required value=" <?php echo e(old('attendant_phone')); ?>" />
                                </div>
                            </div>

                        </div>
                        <div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button class="btn btn-success" type="submit">Save</button>
                        </div>
            </form>



        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/refueling/index.blade.php ENDPATH**/ ?>