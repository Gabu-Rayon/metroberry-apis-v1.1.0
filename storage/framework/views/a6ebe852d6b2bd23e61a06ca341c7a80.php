<?php $__env->startSection('title', 'Employees'); ?>
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Employees</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <?php if(Auth::user()->can('export customers')): ?>
                                                            <a class="btn btn-success btn-sm"
                                                                href=<?php echo e(route('employee.export')); ?> title="Export">
                                                                <i class="fa-solid fa-file-export"></i>&nbsp; Export
                                                            </a>
                                                        <?php endif; ?>
                                                        <span class='m-1'></span>
                                                        <?php if(Auth::user()->can('import customers')): ?>
                                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('employee/import')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                                        <?php endif; ?>
                                                        <span class='m-1'></span>
                                                        <?php if(\Auth::user()->can('create customer')): ?>
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#employeeModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                                Add Employee
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
                                                        <th title="Organisation">Organisation</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e(\Log::info($customer)); ?>

                                                        <tr>
                                                            <td><?php echo e($customer->user->name); ?></td>
                                                            <td><?php echo e($customer->user->email); ?></td>
                                                            <td><?php echo e($customer->user->phone); ?></td>
                                                            <td><?php echo e($customer->user->address); ?></td>
                                                            <td><?php echo e($customer->organisation->user->name); ?></td>
                                                            <td>
                                                                <?php if($customer->status == 'active'): ?>
                                                                    <span class="badge bg-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if(\Auth::user()->can('edit customer')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('employee/<?php echo e($customer->id); ?>/edit')">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if($customer->status == 'active'): ?>
                                                                    <?php if(\Auth::user()->can('deactivate customer')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('employee/<?php echo e($customer->id); ?>/deactivate')"
                                                                            title="Dectivate Employee">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if(\Auth::user()->can('activate customer')): ?>
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('employee/<?php echo e($customer->id); ?>/activate')"
                                                                            title="Activate Employee">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <span class='m-1'></span>
                                                                <?php if(\Auth::user()->can('delete customer')): ?>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('employee/<?php echo e($customer->id); ?>/delete')"
                                                                        title="Delete Customer">
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

        

        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="<?php echo e(route('employee.create')); ?>" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Employee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group row my-3">
                                    <label for="name" class="col-sm-4 col-form-label">
                                        Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="<?php echo e(old('name')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="phone" class="col-sm-4 col-form-label">
                                        Phone
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="phone" class="form-control" type="text" placeholder="Phone"
                                            id="phone" required value="<?php echo e(old('phone')); ?>" />
                                    </div>
                                </div>

                                <?php if(\Auth::user()->role == 'admin'): ?>
                                    <div class="form-group row my-3">
                                        <label for="organisation" class="col-sm-4 col-form-label">
                                            Organisation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-8">
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
                                    <div class="form-group row my-3">
                                        <label for="organisation" class="col-sm-4 col-form-label">
                                            Organisation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="organisation" id="organisation" class="form-control" required
                                                readonly>
                                                <?php
                                                    $organisation = $organisations
                                                        ->where('user_id', Auth::user()->id)
                                                        ->first();
                                                ?>
                                                <option selected readonly value="<?php echo e($organisation->organisation_code); ?>">
                                                    <?php echo e($organisation->user->name); ?>

                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group row my-3">
                                    <label for="front_page_id" class="col-sm-4 col-form-label">
                                        Front Page ID Picture
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="front_page_id" class="form-control" type="file"
                                            placeholder="Front Page ID Picture" id="front_page_id"
                                            value="<?php echo e(old('front_page_id')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="avatar" class="col-sm-4 col-form-label">
                                        Avatar
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="avatar" class="form-control" type="file" placeholder="Avatar"
                                            id="avatar" value="<?php echo e(old('avatar')); ?>" />
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group row my-3">
                                    <label for="email" class="col-sm-4 col-form-label">
                                        Email
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="email" class="form-control" type="email" placeholder="Email"
                                            id="email" required value="<?php echo e(old('email')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="address" class="col-sm-4 col-form-label">
                                        Address
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            id="address" required value="<?php echo e(old('address')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="national_id" class="col-sm-4 col-form-label">
                                        ID number
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="national_id" class="form-control" type="text"
                                            placeholder="National ID number" id="national_id" required
                                            value="<?php echo e(old('national_id')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="back_page_id" class="col-sm-4 col-form-label">
                                        Back Page ID Picture
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="back_page_id" class="form-control" type="file"
                                            placeholder="Back Page ID Picture" id="back_page_id"
                                            value="<?php echo e(old('back_page_id')); ?>" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="password" class="col-sm-4 col-form-label">
                                        Password
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 position-relative">
                                        <input name="password" class="form-control" type="password"
                                            placeholder="Password" id="password" readonly required />
                                        <div class="generate-btn-container" onclick="generatePassword()">
                                            <span class="input-group-text generate-btn"
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


        <!-- Delete Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form"
                            method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this employee? This action cannot be undone.</p>
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

        <!-- JavaScript -->
        <script>
            function deleteCustomer(customerId) {
                // Set the delete form action dynamically
                var form = document.getElementById('delete-modal-form');
                form.action = '/employee/' + customerId + '/delete';

                // Open the delete modal
                var modal = new bootstrap.Modal(document.getElementById('delete-modal'));
                modal.show();
            }

            function confirmDelete() {
                // Submit the delete form
                var form = document.getElementById('delete-modal-form');
                form.submit();
            }

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/app/resources/views/employee/index.blade.php ENDPATH**/ ?>