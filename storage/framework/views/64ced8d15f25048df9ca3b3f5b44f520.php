<div class="table-responsive">
    <table class="table" id="driver-table">
        <thead>
            <tr>
                <th title="Name">Vehicle</th>
                <th title="Type">Insurance Company</th>
                <th title="Type">Policy Number</th>
                <th title="Type">Charges</th>
                <th title="Type">Status</th>
                <th title="Nid">Issue Date</th>
                <th title="Nid">Expiry Date</th>
                <th title="Action" width="80">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $vehicleInsurances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insurance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($insurance->vehicle->model); ?><br>(<?php echo e($insurance->vehicle->plate_number); ?>)
                    </td>
                    <td><?php echo e($insurance->insuranceCompany->name); ?></td>
                    <td><?php echo e($insurance->insurance_policy_no); ?></td>
                    <td>kes.<?php echo e($insurance->charges_payable); ?></td>
                    <td>
                        <?php if($insurance->status == 1): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($insurance->insurance_date_of_issue); ?></td>
                    <td><?php echo e($insurance->insurance_date_of_expiry); ?></td>
                    <td class="d-flex">
                        <?php if(Auth::user()->can('edit vehicle insurance')): ?>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                onclick="axiosModal('/vehicle/insurance/<?php echo e($insurance->id); ?>/edit')">
                                <i class="fas fa-edit"></i>
                            </a>
                        <?php endif; ?>
                        <span class="m-1"></span>
                        <?php if(Auth::user()->can('delete vehicle insurance')): ?>
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                onclick="axiosModal('/vehicle/insurance/<?php echo e($insurance->id); ?>/')">
                                <i class="fas fa-trash"></i>
                            </a>
                        <?php endif; ?>
                        <?php ($expired = \Carbon\Carbon::parse($insurance->insurance_date_of_expiry)->isPast()); ?>
                        <?php if($expired): ?>
                            <span class="m-1"></span>
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                                onclick="axiosModal('/vehicle/insurance/<?php echo e($insurance->id); ?>/renew')">
                                <i class="fas fa-sync"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/components/vehicles/insurances/table.blade.php ENDPATH**/ ?>