

<?php $__env->startSection('title', 'Vehicle Services'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- React page -->
    <div id="app">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- Start header -->
            <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- End header -->

            <div class="content-wrapper">
                <div class="main-content">
                    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="body-content">
                        <div class="tile">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Services</h6>
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#maintenanceServiceModal">
                                                <i class="fa-solid fa-user-plus"></i>&nbsp; Add Service
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
                                                    <th title="Category">Category</th>
                                                    <th title="Date">Date</th>
                                                    <th title="Cost">Cost</th>
                                                    <th title="Status">Status</th>
                                                    <th title="Action">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $maintenanceServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($service->vehicle->plate_number ?? null); ?></td>
                                                        <td><?php echo e($service->serviceCategory->name); ?></td>
                                                        <td><?php echo e($service->service_date); ?></td>
                                                        <td>KES <?php echo e($service->service_cost); ?></td>
                                                        <td>
                                                            <?php switch($service->service_status):
                                                                case ('pending'): ?>
                                                                    <span class="badge bg-secondary">Pending</span>
                                                                <?php break; ?>

                                                                <?php case ('billed'): ?>
                                                                    <span class="badge bg-success">Billed</span>
                                                                <?php break; ?>

                                                                <?php case ('approved'): ?>
                                                                    <span class="badge bg-info">Approved</span>
                                                                <?php break; ?>

                                                                <?php case ('rejected'): ?>
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                <?php break; ?>

                                                                <?php case ('paid'): ?>
                                                                    <span class="badge bg-danger">Paid</span>
                                                                <?php break; ?>

                                                                <?php case ('partially paid'): ?>
                                                                    <span class="badge bg-warning">Partially Paid</span>
                                                                <?php break; ?>

                                                                <?php default: ?>
                                                                    <span class="badge bg-warning">Invalid Status</span>
                                                            <?php endswitch; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if($service->service_status == 'pending'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('maintenance.service.approve', $service->id)); ?>')"
                                                                    class="btn btn-primary btn-sm" title="Approve">
                                                                    <i class="fa-solid fa-thumbs-up"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('maintenance.service.reject', $service->id)); ?>')"
                                                                    class="btn btn-danger btn-sm" title="Reject">
                                                                    <i class="fa-solid fa-ban"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if($service->service_status == 'approved'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('<?php echo e(route('maintenance.service.bill', $service->id)); ?>')"
                                                                    class="btn btn-primary btn-sm" title="Bill">
                                                                    <i class="fa-solid fa-money-bill"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <?php if(in_array($service->service_status, ['billed', 'paid', 'partially paid'])): ?>
                                                                <a href="<?php echo e(route('maintenance.service.payment.checkout', ['id' => $service->id])); ?>"
                                                                    class="btn btn-primary btn-sm"
                                                                    title="Checkout to Pay Vehicle maintenance service charges.">
                                                                    <small><i class="fa-solid fa-money-bill"></i></small>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
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
        <!-- End Vue page -->
    </div>

    <!-- Modal for adding vehicle service -->
    <div class="modal fade" id="maintenanceServiceModal" tabindex="-1" aria-labelledby="maintenanceServiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="<?php echo e(route('maintenance.service.create')); ?>" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Add Vehicle Service</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group row my-2">
                                <label for="vehicle" class="col-sm-5 col-form-label">
                                    Vehicle <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="vehicle" class="form-control" id="vehicle" required>
                                        <option value="">Select Vehicle</option>
                                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->plate_number); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="service_type_id" class="col-sm-5 col-form-label">
                                    Service Type <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="service_type_id" class="form-control" id="service_type_id" required>
                                        <option value="">Select Service Type</option>
                                        <?php $__currentLoopData = $serviceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($serviceType->id); ?>"
                                                <?php echo e(old('service_type_id') == $serviceType->id ? 'selected' : ''); ?>>
                                                <?php echo e($serviceType->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="service_date" class="col-sm-5 col-form-label">
                                    Service Date <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input type="date" name="service_date" class="form-control" id="service_date"required
                                        value="<?php echo e(old('service_date')); ?>">
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="service_description" class="col-sm-5 col-form-label">
                                    Service Description <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <textarea name="service_description" class="form-control" id="service_description" rows="4" required><?php echo e(old('service_description')); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="form-group row my-2">
                                <label for="creator_id" class="col-sm-5 col-form-label">
                                    Requested By <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="creator_id" class="form-control" id="creator_id" readonly disabled>
                                        <option value="<?php echo e(auth()->user()->id); ?>"><?php echo e(auth()->user()->name); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="service_category_id" class="col-sm-5 col-form-label">
                                    Service Category <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="service_category_id" class="form-control" id="service_category_id"
                                        required>
                                        <option value="">Select Service Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="service_cost" class="col-sm-5 col-form-label">
                                    Service Cost <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input type="number" name="service_cost" class="form-control" id="service_cost"
                                        placeholder="0.00" step="0.01" min="0" required
                                        value="<?php echo e(old('service_cost')); ?>">
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="receipt_image" class="col-sm-5 col-form-label">
                                    Upload Receipt <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input type="file" name="receipt_image" class="form-control" id="receipt_image"
                                        accept="image/*" required value="<?php echo e(old('receipt_image')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add Service</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function populateServiceCategories(serviceTypeId) {
            if (serviceTypeId) {
                fetch(`/service-categories/${serviceTypeId}`)
                    .then(response => response.json())
                    .then(data => {
                        var serviceCategorySelect = document.getElementById('service_category_id');
                        serviceCategorySelect.innerHTML = '<option value="">Select Service Category</option>';
                        data.forEach(category => {
                            var option = document.createElement('option');
                            option.value = category.id;
                            option.text = category.name;
                            serviceCategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching service categories:', error));
            } else {
                document.getElementById('service_category_id').innerHTML =
                    '<option value="">Select Service Category</option>';
            }
        }

        document.getElementById('service_type_id').addEventListener('change', function() {
            populateServiceCategories(this.value);
        });

        // Populate service categories on page load if a service type is selected
        document.addEventListener('DOMContentLoaded', function() {
            var selectedServiceTypeId = document.getElementById('service_type_id').value;
            populateServiceCategories(selectedServiceTypeId);
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/vehicle/maintenance-services/index.blade.php ENDPATH**/ ?>