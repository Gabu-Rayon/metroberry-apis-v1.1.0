<div class="sidebar-body">
    <?php echo $__env->make('components.sidebar.sidebar-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="mt-auto p-3 sidebar-logout">
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" id="logout-btn">
                <span class="btn btn-dark w-100">
                    <img class="me-2" src="<?php echo e(asset('admin-assets/img/logout.png?v=1')); ?>">
                    <span>Logout</span>
                </span>
            </button>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/components/sidebar/sidebar-body.blade.php ENDPATH**/ ?>