<?php $__env->startSection('title', 'PSV Badges'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">PSV Badges</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <?php if(Auth::user()->can('export driver psvbadges')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('driver.psvbadge.export')); ?> title="Export">
                                                                <i class="fa-solid fa-file-export"></i>
                                                                &nbsp;
                                                                Export
                                                            </a>
                                                        <?php endif; ?>
                                                        <span class="m-1"></span>
                                                        <!-- <?php if(Auth::user()->can('import driver psvbadges')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('driver.psvbadge.import')); ?> title="Import">
                                                                <i class="fa-solid fa-file-import"></i>
                                                                &nbsp;
                                                                Import
                                                            </a>
                                                        <?php endif; ?> -->
                                                        <span class="m-1"></span>
                                                        <?php if(Auth::user()->can('create driver psvbadge')): ?>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#driverPSVBadgeModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp; Add Driver's PSV
                                                                Badge
                                                            </button>
                                                        <?php endif; ?>
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
                                                        <th title="Badge No">Badge No</th>
                                                        <th title="Driver">Driver</th>
                                                        <th title="Issue Date">Issue Date</th>
                                                        <th title="Expiry Date">Expiry Date</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $psvbadges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $psvbadge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($psvbadge->psv_badge_no); ?></td>
                                                            <td><?php echo e($psvbadge->driver->user->name); ?></td>
                                                            <td><?php echo e($psvbadge->psv_badge_date_of_issue); ?></td>
                                                            <td><?php echo e($psvbadge->psv_badge_date_of_expiry); ?></td>
                                                            <td>
                                                                <?php
                                                                    $avatar = $psvbadge->psv_badge_avatar;

                                                                    if (!$avatar) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Missing Documents';
                                                                    } else {
                                                                        $expiryDate = \Carbon\Carbon::parse(
                                                                            $psvbadge->psv_badge_date_of_expiry,
                                                                        );
                                                                        $today = \Carbon\Carbon::today();
                                                                        $daysUntilExpiry = $today->diffInDays(
                                                                            $expiryDate,
                                                                            false,
                                                                        );
                                                                        $isExpired = $daysUntilExpiry < 0;

                                                                        Log::info(
                                                                            'Days until expiry: ' . $daysUntilExpiry,
                                                                        );

                                                                        if ($isExpired) {
                                                                            $badgeClass = 'badge bg-danger';
                                                                            $badgeText = 'Expired';
                                                                        } elseif (
                                                                            $daysUntilExpiry > 0 &&
                                                                            $daysUntilExpiry <= 30
                                                                        ) {
                                                                            if (!$psvbadge->verified) {
                                                                                $badgeClass =
                                                                                    'badge bg-warning text-dark';
                                                                                $badgeText = 'Pending Verification';
                                                                            } else {
                                                                                $badgeClass =
                                                                                    'badge bg-warning text-dark';
                                                                                $badgeText = 'Expires Soon';
                                                                            }
                                                                        } elseif (!$psvbadge->verified) {
                                                                            $badgeClass = 'badge bg-warning text-dark';
                                                                            $badgeText = 'Pending Verification';
                                                                        } else {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Valid';
                                                                        }
                                                                    }
                                                                ?>
                                                                <span class="<?php echo e($badgeClass); ?>"><?php echo e($badgeText); ?></span>
                                                            </td>
                                                            <td class="d-flex">
                                                                <?php if(Auth::user()->can('edit driver psvbadge')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('psvbadge/<?php echo e($psvbadge->id); ?>/edit')"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(!$psvbadge->verified): ?>
                                                                    <?php if(Auth::user()->can('verify driver psvbadge')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('psvbadge/<?php echo e($psvbadge->id); ?>/verify')"
                                                                            title="Verify">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if(Auth::user()->can('revoke driver psvbadge')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('psvbadge/<?php echo e($psvbadge->id); ?>/revoke')"
                                                                            title="Suspend">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(Auth::user()->can('delete driver psvbadge')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('psvbadge/<?php echo e($psvbadge->id); ?>/delete')"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash"></i>
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

        
        <div class="modal fade" id="driverPSVBadgeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="psvbadge" method="POST" class="needs-validation modal-content" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add PSV Badge</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="driver" class="col-sm-5 col-form-label">Driver <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select name="driver" id="driver" class="form-control" required>
                                            <option value="">Select Driver</option>
                                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($driver->id); ?>"><?php echo e($driver->user->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="issue_date" class="col-sm-5 col-form-label">Issue Date <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="issue_date" class="form-control" type="date"
                                            placeholder="Issue Date" id="issue_date" required
                                            value="<?php echo e(old('issue_date')); ?>" />
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="psv_badge_avatar" class="col-sm-5 col-form-label">PSV Badge Copy</label>
                                    <div class="col-sm-7">
                                        <input name="psv_badge_avatar" class="form-control" type="file"
                                            placeholder="Badge Picture" id="psv_badge_avatar"
                                            value="<?php echo e(old('psv_badge_avatar')); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="psvbadge_no" class="col-sm-5 col-form-label">Badge No <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="psvbadge_no" class="form-control" type="text"
                                            placeholder="Badge No" id="psvbadge_no" required
                                            value="<?php echo e(old('psvbadge_no')); ?>" />
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="expiry_date" class="col-sm-5 col-form-label">Expiry Date <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="expiry_date" class="form-control" type="date"
                                            placeholder="Expiry Date" id="expiry_date" required
                                            value="<?php echo e(old('expiry_date')); ?>" />
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
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kknuicdz/metroBerry/resources/views/driver/psvbadge/index.blade.php ENDPATH**/ ?>