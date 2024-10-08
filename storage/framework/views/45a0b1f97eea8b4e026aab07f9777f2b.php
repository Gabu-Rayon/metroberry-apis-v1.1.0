<?php $__env->startSection('title', 'Drivers'); ?>
<?php $__env->startSection('content'); ?>

    <head>
        <style>
            .generate-btn-container {
                position: absolute;
                top: 0;
                right: 0;
                transform: translateY(-50%);
                cursor: pointer;
            }

            .generate-btn {
                padding: 5px 10px;
                font-size: 0.8em;
            }
        </style>
    </head>

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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Drivers</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <?php if(\Auth::user()->can('create driver')): ?>
                                                        <a class="btn btn-success btn-sm" href="<?php echo e(route('driver.export')); ?>"
                                                            title="Export to xlsx excel file">
                                                            <i class="fa-solid fa-file-export"></i>&nbsp; Export
                                                        </a>
                                                        <?php endif; ?>
                                                        <span class='m-1'></span>
                                                        <?php if(\Auth::user()->can('create driver')): ?>
                                                        <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                            onclick="axiosModal('driver/import')"
                                                            title="Import From csv excel file">
                                                            <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                        </a>
                                                        <?php endif; ?>
                                                        <span class='m-1'></span>
                                                        <?php if(\Auth::user()->can('create driver')): ?>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#driverModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                                Add Driver
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
                                                        <th title="Name">Name</th>
                                                        <th title="Email">Email</th>
                                                        <th title="Phone">Phone</th>
                                                        <th title="Address">Address</th>
                                                        <th title="Vehicle">Vehicle</th>
                                                        <th title="Status">Status</th>
                                                        <?php if(\Auth::user()->role == 'admin'): ?>
                                                            <th title="Action" width="80">Action</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($driver->user->name); ?></td>
                                                            <td><?php echo e($driver->user->email); ?></td>
                                                            <td><?php echo e($driver->user->phone); ?></td>
                                                            <td><?php echo e($driver->user->address); ?></td>
                                                            <td class="text-center">
                                                                <?php echo e($driver->vehicle ? $driver->vehicle->plate_number : '-'); ?>

                                                            </td>
                                                            <td>
                                                                <?php
                                                                    $license = $driver->driverLicense;
                                                                    $psvBadge = $driver->psvBadge;

                                                                    if (!$license) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Missing License';
                                                                    } elseif ($license && !$license->verified) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Unverified License';
                                                                    } elseif ($psvBadge && !$psvBadge->verified) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Unverified PSV Badge';
                                                                    } elseif (!$psvBadge) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Missing PSV Badge';
                                                                    } else {
                                                                        if ($driver->status == 'inactive') {
                                                                            $badgeClass = 'badge bg-warning text-dark';
                                                                            $badgeText = 'Pending Verification';
                                                                        } else {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Active';
                                                                        }
                                                                    }
                                                                ?>
                                                                <span class="<?php echo e($badgeClass); ?>"><?php echo e($badgeText); ?></span>
                                                            </td>
                                                            <?php if(\Auth::user()->role == 'admin'): ?>
                                                                <td class="text-center">
                                                                    <?php if(\Auth::user()->can('edit driver')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-primary"
                                                                            onclick="axiosModal('driver/<?php echo e($driver->id); ?>/edit')"
                                                                            title="Edit Driver">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <span class='m-1'></span>
                                                                    <?php if($driver->status == 'active'): ?>
                                                                        <?php if(\Auth::user()->can('deactivate driver')): ?>
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm btn-success"
                                                                                onclick="axiosModal('driver/<?php echo e($driver->id); ?>/deactivate')"
                                                                                title="Dectivate Driver">
                                                                                <i class="fas fa-toggle-on"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <?php if(\Auth::user()->can('activate driver')): ?>
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm btn-secondary"
                                                                                onclick="axiosModal('driver/<?php echo e($driver->id); ?>/activate')"
                                                                                title="Activate Driver">
                                                                                <i class="fas fa-toggle-off"></i>
                                                                            </a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php if(\Auth::user()->can('delete driver')): ?>
                                                                        <span class='m-1'></span>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-danger"
                                                                            onclick="deleteDriver(<?php echo e($driver->id); ?>)"
                                                                            title="Delete Driver">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <span class='m-1'></span>
                                                                    <?php if(!$driver->vehicle && $driver->status == 'active'): ?>
                                                                        <?php if(\Auth::user()->can('assign vehicle')): ?>
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm btn-info"
                                                                                onclick="axiosModal('<?php echo e(route('driver.vehicle.assign', $driver->id)); ?>')"
                                                                                title="Assign Vehicle">
                                                                                <i class="fa-solid fa-key"></i>
                                                                            </a>
                                                                        <?php endif; ?>
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
        </div>

        
        <div class="modal fade" id="driverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('driver.store')); ?>" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Driver</h4>
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
                                            id="name" required value="<?php echo e(old('name')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="phone" class="col-sm-5 col-form-label">
                                        Phone
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="phone" class="form-control" type="text" placeholder="Phone"
                                            id="phone" required value="<?php echo e(old('phone')); ?>" />
                                    </div>
                                </div>

                                <?php if(Auth::user()->role == 'admin'): ?>

                                    <div class="form-group row my-2">
                                        <label for="organisation" class="col-sm-5 col-form-label">
                                            Organisation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-7">
                                            <select name="organisation" id="organisation" class="form-control" required>
                                                <option value="">Select Organisation</option>
                                                <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($organisation->organisation_code); ?>">
                                                        <?php echo e($organisation->user->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group row my-2">
                                        <label for="organisation" class="col-sm-5 col-form-label">
                                            Organisation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-7">
                                            <select name="organisation" id="organisation" class="form-control" required
                                                readonly>
                                                <?php
                                                    $organisation = $organisations
                                                        ->where('user_id', Auth::user()->id)
                                                        ->first();
                                                    Log::info('ORGANISATION');
                                                    Log::info($organisation);
                                                ?>
                                                <option value="<?php echo e($organisation->organisation_code); ?>">
                                                    <?php echo e($organisation->user->name); ?>

                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                <?php endif; ?>


                                <div class="form-group row my-2">
                                    <label for="front_page_id" class="col-sm-5 col-form-label">
                                        Front Page ID Picture
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="front_page_id" class="form-control" type="file"
                                            placeholder="Front Page ID Picture" id="front_page_id"
                                            value="<?php echo e(old('front_page_id')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="avatar" class="col-sm-5 col-form-label">
                                        Avatar
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="avatar" class="form-control" type="file" placeholder="Avatar"
                                            id="avatar" value="<?php echo e(old('avatar')); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="email" class="col-sm-5 col-form-label">
                                        Email
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="email" class="form-control" type="email" placeholder="Email"
                                            id="email" value="<?php echo e(old('email')); ?>" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="address" class="col-sm-5 col-form-label">
                                        Address
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            id="address" value="<?php echo e(old('address')); ?>" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="national_id" class="col-sm-5 col-form-label">
                                        ID number
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="national_id" class="form-control" type="text"
                                            placeholder="National ID number" id="national_id"
                                            value="<?php echo e(old('national_id')); ?>" </div>
                                    </div>

                                    <div class="form-group row my-2">
                                        <label for="back_page_id" class="col-sm-5 col-form-label">
                                            Back Page ID Picture
                                        </label>
                                        <div class="col-sm-7">
                                            <input name="back_page_id" class="form-control" type="file"
                                                placeholder="Back Page ID Picture" id="back_page_id"
                                                value="<?php echo e(old('back_page_id')); ?>" </div>
                                        </div>

                                        <div class="form-group row my-2">
                                            <label for="password" class="col-sm-5 col-form-label">
                                                Password
                                                <i class="text-danger">*</i>
                                            </label>
                                            <div class="col-sm-7 position-relative">
                                                <input name="password" class="form-control" type="password"
                                                    placeholder="Password" id="password" readonly required />
                                                <div class="generate-btn-container">
                                                    <span class="input-group-text generate-btn"
                                                        onclick="generatePassword()"
                                                        style="font-size: smaller;">Generate</span>
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

        
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Driver</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this driver? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function generatePassword() {
                var length = 12,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=",
                    password = "";
                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }
                document.getElementById("password").value = password;
            }
        </script>
    </body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/driver/index.blade.php ENDPATH**/ ?>