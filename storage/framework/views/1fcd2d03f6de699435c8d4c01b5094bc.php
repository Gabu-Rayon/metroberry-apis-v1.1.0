<?php $__env->startSection('title', 'Licenses'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Licenses</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <?php if(Auth::user()->can('export driver licenses')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('driver.license.export')); ?> title="Export">
                                                                <i class="fa-solid fa-file-export"></i>
                                                                &nbsp;
                                                                Export
                                                            </a>
                                                        <?php endif; ?>
                                                        <span class="m-1"></span>
                                                        <!-- <a class="btn btn-success btn-sm"
                                                            href=<?php echo e(route('driver.license.import')); ?> title="Import">
                                                            <i class="fa-solid fa-file-import"></i>
                                                            &nbsp;
                                                            Import
                                                        </a> -->
                                                        <!-- <?php if(Auth::user()->can('import driver licenses')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('driver.license.import')); ?> title="Import">
                                                                <i class="fa-solid fa-file-import"></i>
                                                                &nbsp;
                                                                Import
                                                            </a>
                                                        <?php endif; ?> -->
                                                        <span class="m-1"></span>
                                                        <?php if(Auth::user()->can('create driver license')): ?>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#driverLicenseModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                                Add Driver's License
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
                                                        <th title="Name">License No</th>
                                                        <th title="Address">Driver</th>
                                                        <th title="Email">Issue Date</th>
                                                        <th title="Phone">Expiry Date</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $licenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($license->driving_license_no); ?></td>
                                                            <td><?php echo e($license->driver->user->name); ?></td>
                                                            <td><?php echo e($license->driving_license_date_of_issue); ?></td>
                                                            <td><?php echo e($license->driving_license_date_of_expiry); ?></td>
                                                            <td>
                                                                <?php
                                                                    $frontPage = $license->driving_license_avatar_front;
                                                                    $backPage = $license->driving_license_avatar_back;

                                                                    // First, check for missing documents.
                                                                    if (!$frontPage || !$backPage) {
                                                                        $badgeClass = 'badge bg-danger'; // Red badge indicates missing documents.
                                                                        $badgeText = 'Missing Documents';
                                                                    } else {
                                                                        // Proceed only if both front and back pages are available.
                                                                        $expiryDate = \Carbon\Carbon::parse(
                                                                            $license->driving_license_date_of_expiry,
                                                                        );
                                                                        $today = \Carbon\Carbon::today();
                                                                        $isExpired = $today->lt($expiryDate);

                                                                        $daysUntilExpiry = $isExpired
                                                                            ? 0
                                                                            : $today->diffInDays($expiryDate, false);

                                                                        // Determine badge color and text based on days until expiry and verification status.
                                                                        if ($daysUntilExpiry < 0) {
                                                                            $badgeClass = 'badge bg-danger';
                                                                            $badgeText = 'Expired';
                                                                        } elseif (
                                                                            $daysUntilExpiry <= 30 &&
                                                                            !$license->verified
                                                                        ) {
                                                                            $badgeClass = 'badge bg-warning text-dark'; // Yellow badge for pending verification.
                                                                            $badgeText = 'Pending Verification';
                                                                        } elseif (
                                                                            $daysUntilExpiry > 30 &&
                                                                            !$license->verified
                                                                        ) {
                                                                            $badgeClass = 'badge bg-warning text-dark'; // Yellow badge for pending verification.
                                                                            $badgeText = 'Pending Verification';
                                                                        } else {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Active';
                                                                        }
                                                                    }
                                                                ?>
                                                                <span class="<?php echo e($badgeClass); ?>"><?php echo e($badgeText); ?></span>
                                                            </td>
                                                            <td class="d-flex">
                                                                <?php if(Auth::user()->can('edit driver license')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('license/<?php echo e($license->id); ?>/edit')"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(!$license->verified): ?>
                                                                    <?php if(Auth::user()->can('verify driver license')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('<?php echo e(route('driver.license.verify', $license->id)); ?>')"
                                                                            title="Verify">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if(Auth::user()->can('revoke driver license')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('license/<?php echo e($license->id); ?>/revoke')"
                                                                            title="Suspend">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(Auth::user()->can('delete driver license')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('license/<?php echo e($license->id); ?>/delete')"
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

        

        <div class="modal fade" id="driverLicenseModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('driver.license.create')); ?>" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add License</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="driver" class="col-sm-5 col-form-label">
                                        Driver
                                        <i class="text-danger">*</i>
                                    </label>
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
                                    <label for="issue_date" class="col-sm-5 col-form-label">
                                        Issue Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="issue_date" class="form-control" type="date"
                                            placeholder="Issue Date" id="issue_date" required
                                            value="<?php echo e(old('issue_date')); ?>" />
                                    </div>
                                </div>


                                <div class="form-group row my-2">
                                    <label for="front_page_id" class="col-sm-5 col-form-label">
                                        Front Page License Picture
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="front_page_id" class="form-control" type="file"
                                            placeholder="Front Page License Picture" id="front_page_id" required
                                            value="<?php echo e(old('front_page_id')); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="license_no" class="col-sm-5 col-form-label">
                                        License No
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="license_no" class="form-control" type="text"
                                            placeholder="License No" id="license_no" required
                                            value="<?php echo e(old('license_no')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="expiry_date" class="col-sm-5 col-form-label">
                                        Expiry Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="expiry_date" class="form-control" type="date"
                                            placeholder="Expiry Date" id="expiry_date" required
                                            value="<?php echo e(old('expiry_date')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="back_page_id" class="col-sm-5 col-form-label">
                                        Back Page License Picture
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="back_page_id" class="form-control" type="file"
                                            placeholder="Back Page License Picture" id="back_page_id" required
                                            value="<?php echo e(old('back_page_id')); ?>" />
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/driver/license/index.blade.php ENDPATH**/ ?>