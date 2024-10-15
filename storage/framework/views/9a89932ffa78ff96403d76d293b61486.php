<nav class="navbar-custom-menu navbar navbar-expand-lg m-0 border-bottom shadow-none">
    <div class="sidebar-toggle-icon" id="sidebarCollapse">Sidebar Toggle<span></span>
    </div>

    <div class="navbar-icon d-flex">
        <ul class="navbar-nav flex-row align-items-center">
            <li class="nav-item dropdown language-menu notification me-3">
                <a class="language-menu_item border rounded-circle d-flex justify-content-center align-items-center overflow-hidden"
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="" alt="Language Icon">
                </a>
                <div class="dropdown-menu language_dropdown">

                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('change.language', $code)); ?>"
                        class="dropdown-item <?php echo e($lang == $code ? 'text-primary' : ''); ?>">
                        <span><?php echo e(ucFirst($language)); ?></span>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </li>

            <li class="nav-item dropdown user_profile me-2">
                <a class="dropdown-toggle user_profile_item border rounded-circle d-flex justify-content-center align-items-center overflow-hidden"
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-fluid" src="<?php echo e(asset('storage/' . \Auth::user()->avatar)); ?>"
                        alt="User Avatar">
                </a>
                <div class="dropdown-menu w-75">
                    <div class="d-flex align-items-center gap-3 border-bottom pb-3">
                        <div class="user_img">
                            <img src="<?php echo e(url('storage/' . \Auth::user()->avatar)); ?>" alt="User Avatar">
                        </div>
                        <div>
                            <p class="mb-0 fw-bold fs-16">
                                <?php echo e(Auth::user()->name); ?>

                                <span class="badge bg-primary"><?php echo e(\Auth::user()->role); ?></span>
                            </p>
                        </div>
                    </div>

                    <ul class="list-unstyled mt-3 dropdown_menu_inner">
                        <li class="w-100">
                            <a class="d-block w-100" href="<?php echo e(route('profile.show')); ?>">My Profile</a>
                        </li>
                        <li class="w-100">
                            <a class="d-block w-100" href="<?php echo e(route('profile.edit')); ?>">Edit Profile</a>
                        </li>
                        <li class="w-100">
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" id="logout-btn" class="btn_sign_out text-black w-100 btn">
                                    Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
<link href="<?php echo e(asset('admin-assets/css/logout.css?v=1')); ?>" rel="stylesheet">
<?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/components/navbar.blade.php ENDPATH**/ ?>