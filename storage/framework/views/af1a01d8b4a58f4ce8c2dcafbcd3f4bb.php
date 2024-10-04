<?php $__env->startSection('title', 'Repair Categories'); ?>
<?php $__env->startSection('content'); ?>

    <body class="fixed sidebar-mini">
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
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Repair Categories</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#repairCategoryModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                            Add Repair Category
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Name">Name</th>
                                                        <th title="Email">Description</th>
                                                        <th title="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $repairCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repairCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($repairCategory->name); ?></td>
                                                            <td><?php echo e($repairCategory->description); ?></td>
                                                            <td class="text-center">
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                        onclick="axiosModal('<?php echo e(route('vehicle.maintenance.repairs.categories.edit', $repairCategory->id)); ?>')"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </a>
                                                                    <span class="m-1"></span>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                        onclick="axiosModal('<?php echo e(route('vehicle.maintenance.repairs.categories.delete', $repairCategory->id)); ?>')"
                                                                        class="btn btn-danger btn-sm">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </a>
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
                    </div>
                    <div class="overlay"></div>
                    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="repairCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('vehicle.maintenance.repairs.categories.create')); ?>" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Repair Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="repair_id" class="col-sm-5 col-form-label">
                                        Repair Type
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="repair_id" class="form-control" id="repair_id" required>
                                            <option value="">Select Repair Type</option>
                                            <?php $__currentLoopData = $repairTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repairType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($repairType->id); ?>"
                                                    <?php echo e(old('repair_id') == $repairType->id ? 'selected' : ''); ?>>
                                                    <?php echo e($repairType->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group row my-2">
                                    <label for="description" class="col-sm-5 col-form-label">
                                        Description
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="description" class="form-control" placeholder="Description" id="description" required rows="5"><?php echo e(old('description')); ?></textarea>
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
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="<?php echo e(old('name')); ?>">
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
            </div>
        </div>

    </body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/maintenance/repairs/categories/index.blade.php ENDPATH**/ ?>