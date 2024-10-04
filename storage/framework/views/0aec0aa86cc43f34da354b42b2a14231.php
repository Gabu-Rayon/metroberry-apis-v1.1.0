<?php $__env->startSection('title', 'Vehicle Parts'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Parts</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#vehiclePartModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                            Add Vehicle Part
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
                                                        <th title="Category">Category</th>
                                                        <th title="Brand">Brand</th>
                                                        <th title="Quantity">Quantity</th>
                                                        <th title="Price">Price</th>
                                                        <th title="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($part->name); ?></td>
                                                            <td><?php echo e($part->category->name); ?></td>
                                                            <td><?php echo e($part->brand); ?></td>
                                                            <td><?php echo e($part->quantity); ?></td>
                                                            <td>KES <?php echo e($part->price); ?></td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('vehicle.maintenance.parts.edit', $part->id)); ?>')"
                                                                    class="btn btn-warning btn-sm">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('vehicle.maintenance.parts.delete', $part->id)); ?>')"
                                                                    class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
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

        <div class="modal fade" id="vehiclePartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('vehicle.maintenance.parts.create')); ?>" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Create Vehicle Part</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">

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


                                <div class="form-group row my-2">
                                    <label for="category" class="col-sm-5 col-form-label">
                                        Category
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="category_id" class="form-control" id="category" required>
                                            <option value="">Select Category</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row my-2">
                                    <label for="model_number" class="col-sm-5 col-form-label">
                                        Model No
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="model_number" class="form-control" type="text"
                                            placeholder="model_number" id="Model No" required
                                            value="<?php echo e(old('model_number')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="quantity" class="col-sm-5 col-form-label">
                                        Quantity
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="quantity" class="form-control" type="number" placeholder="Quantity"
                                            id="quantity" required value="<?php echo e(old('quantity')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="compatibility" class="col-sm-5 col-form-label">
                                        Compatibility
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="compatibility" class="form-control" placeholder="Compatibility" id="compatibility" rows="5"><?php echo e(old('compatibility')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="sku" class="col-sm-5 col-form-label">
                                        SKU
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="sku" class="form-control" type="text"
                                            placeholder="SKU"id="sku" required value="<?php echo e(old('sku')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="brand" class="col-sm-5 col-form-label">
                                        Brand
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="brand" class="form-control" type="text" placeholder="Brand"
                                            id="brand" required value="<?php echo e(old('brand')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="price" class="col-sm-5 col-form-label">
                                        Price
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="price" class="form-control" type="number" step="0.01"
                                            placeholder="Price" id="price" required value="<?php echo e(old('price')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="condition" class="col-sm-5 col-form-label">
                                        Condition
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="condition" class="form-control" id="condition" required>
                                            <option value="">Select Condition</option>
                                            <option value="new">New</option>
                                            <option value="refurbished">Refurbished</option>
                                            <option value="used">Used</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row my-2">
                                    <label for="notes" class="col-sm-5 col-form-label">
                                        Notes
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="notes" class="form-control" placeholder="Notes" id="notes" rows="5"><?php echo e(old('notes')); ?></textarea>
                                    </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/maintenance/parts/index.blade.php ENDPATH**/ ?>