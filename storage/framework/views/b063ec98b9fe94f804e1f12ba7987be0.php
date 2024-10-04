<?php $__env->startSection('title', 'Vehicle Repairs'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Repairs</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#maintenanceRepairModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                            Repair Vehicle
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
                                                        <th title="Vehicle">Vehicle</th>
                                                        <th title="Part">Part</th>
                                                        <th title="Type">Type</th>
                                                        <th title="Amount">Amount</th>
                                                        <th title="Cost">Cost</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Actions">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $maintenanceRepairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maintenanceRepair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($maintenanceRepair->vehicle->plate_number); ?></td>
                                                            <td><?php echo e($maintenanceRepair->part->name); ?></td>
                                                            <td><?php echo e($maintenanceRepair->repair_type); ?></td>
                                                            <td><?php echo e($maintenanceRepair->amount); ?></td>
                                                            <td><?php echo e($maintenanceRepair->repair_cost); ?></td>
                                                            <td>
                                                                <?php if($maintenanceRepair->repair_status == 'pending'): ?>
                                                                    <span class="badge bg-secondary">Pending</span>
                                                                <?php elseif($maintenanceRepair->repair_status == 'billed'): ?>
                                                                    <span class="badge bg-success">Billed</span>
                                                                <?php elseif($maintenanceRepair->repair_status == 'approved'): ?>
                                                                    <span class="badge bg-info">Approved</span>
                                                                <?php elseif($maintenanceRepair->repair_status == 'rejected'): ?>
                                                                    <span class="badge bg-danger">Rejected</span>
                                                                <?php elseif($service->repair_status == 'paid'): ?>
                                                                    <span class="badge bg-danger">paid</span>
                                                                <?php elseif($service->repair_status == 'partially paid'): ?>
                                                                    <span class="badge bg-danger">partially paid</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-warning">Invalid Status</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if($maintenanceRepair->repair_status == 'pending' || $maintenanceRepair->repair_status == 'approved'): ?>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('<?php echo e(route('maintenance.repair.edit', $maintenanceRepair->id)); ?>')"
                                                                        class="btn btn-info btn-sm" title="Edit">
                                                                        <i class="fa-solid fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if($maintenanceRepair->repair_status == 'billed' || $maintenanceRepair->repair_status == 'rejected'): ?>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('<?php echo e(route('maintenance.repair.redo-repair', $maintenanceRepair->id)); ?>')"
                                                                        class="btn btn-secondary btn-sm"
                                                                        title="Redo Repair">
                                                                        <i class="fa-solid fa-rotate-right"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if($maintenanceRepair->repair_status == 'pending'): ?>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('<?php echo e(route('maintenance.repair.approve.form', $maintenanceRepair->id)); ?>')"
                                                                        class="btn btn-primary btn-sm" title="Approve">
                                                                        <i class="fa-solid fa-thumbs-up"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('<?php echo e(route('maintenance.repair.reject', $maintenanceRepair->id)); ?>')"
                                                                        class="btn btn-warning btn-sm" title="Reject">
                                                                        <i class="fa-solid fa-ban"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if($maintenanceRepair->repair_status == 'approved'): ?>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('<?php echo e(route('maintenance.repair.bill.form', $maintenanceRepair->id)); ?>')"
                                                                        class="btn btn-primary btn-sm" title="Bill">
                                                                        <i class="fa-solid fa-money-bill"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if($maintenanceRepair->repair_status == 'pending' || $maintenanceRepair->repair_status == 'approved'): ?>
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('<?php echo e(route('maintenance.repair.delete', $maintenanceRepair->id)); ?>')"
                                                                        class="btn btn-danger btn-sm" title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if(in_array($maintenanceRepair->repair_status, ['billed', 'paid', 'partially paid'])): ?>
                                                                    <a href="<?php echo e(route('maintenance.repair.payment.checkout', ['id' => $maintenanceRepair->id])); ?>"
                                                                        class="btn btn-primary btn-sm"
                                                                        title="Checkout to Pay Vehicle maintenance service charges.">
                                                                        <small><i
                                                                                class="fa-solid fa-money-bill"></i></small>
                                                                    </a>
                                                                <?php endif; ?>

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

        <div class="modal fade" id="maintenanceRepairModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('maintenance.repair.create')); ?>" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Repair Vehicle</h4>
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
                                            <option value="">Select Vehicle</option>
                                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vehicle->id); ?>"><?php echo e($vehicle->plate_number); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="part" class="col-sm-5 col-form-label">
                                        Part
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="part" class="form-control" id="part" required>
                                            <option value="">Select Part</option>
                                            <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($part->id); ?>" data-price="<?php echo e($part->price); ?>">
                                                    <?php echo e($part->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="cost" class="col-sm-5 col-form-label">
                                        Cost
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="number" name="cost" class="form-control" id="cost"
                                            step="0.01" min="0" value="<?php echo e(old('cost')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="amount" class="col-sm-5 col-form-label">
                                        Amount (L)
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="number" name="amount" class="form-control" id="amount"
                                            step="0.01" min="0" value="<?php echo e(old('amount')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="repair_date" class="col-sm-5 col-form-label">
                                        Repair Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="date" name="repair_date" class="form-control" id="repair_date"
                                            value="<?php echo e(old('repair_date')); ?>" />
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="creator_id" class="col-sm-5 col-form-label">
                                        Requested By
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="creator_id" class="form-control" id="creator_id" readonly>
                                            <option value="<?php echo e(auth()->user()->id); ?>"><?php echo e(auth()->user()->name); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="repair_type" class="col-sm-5 col-form-label">
                                        Repair Type
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="repair_type" class="form-control" id="repair_type">
                                            <option value="repair">Repair</option>
                                            <option value="replacement">Replacement</option>
                                            <option value="refill">Refill</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="description" class="col-sm-5 col-form-label">
                                        Description
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="description" class="form-control" id="description" rows="4"><?php echo e(old('description')); ?></textarea>
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

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var repairTypeSelect = $('#repair_type');
                        var partSelect = $('#part');
                        var costInput = $('#cost');
                        var amountInput = $('#amount');

                        function calculateRefillCost() {
                            if (repairTypeSelect.val() === 'refill') {
                                var selectedPart = partSelect.find(':selected');
                                var partPrice = parseFloat(selectedPart.data('price'));
                                var amount = parseFloat(amountInput.val());
                                var calculatedCost = partPrice * amount;
                                costInput.val(calculatedCost.toFixed(2)); // Set calculated cost with 2 decimal places
                                costInput.prop('readonly', true); // Make cost input read-only
                            }
                        }

                        function toggleCostInput() {
                            var selectedPart = partSelect.find(':selected');
                            var partPrice = parseFloat(selectedPart.data('price'));

                            if (repairTypeSelect.val() === 'replacement') {
                                costInput.val(partPrice ? partPrice.toFixed(2) : '').prop('readonly', true);
                                amountInput.val(1).prop('readonly', true); // Set amount to 1 and make it read-only
                            } else if (repairTypeSelect.val() === 'repair') {
                                costInput.val('').prop('readonly', false);
                                amountInput.val(1).prop('readonly', true); // Set amount to 1 and make it read-only
                            } else if (repairTypeSelect.val() === 'refill') {
                                costInput.val('').prop('readonly', false);
                                amountInput.val('').prop('readonly', false); // Make amount editable for refill
                                calculateRefillCost(); // Calculate cost for refill
                            } else {
                                costInput.val('').prop('readonly', false);
                                amountInput.val('').prop('readonly', false); // Reset amount for other types
                            }
                        }

                        repairTypeSelect.change(toggleCostInput);
                        partSelect.change(toggleCostInput);
                        amountInput.change(calculateRefillCost); // Listen for changes in Amount field

                        toggleCostInput(); // Initial call to set the state correctly on page load
                    });
                </script>

            </div>
        </div>

    </body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/vehicle/maintenance-repairs/index.blade.php ENDPATH**/ ?>