<nav class="sidebar sidebar-bunker sidebar-sticky overflow-hidden">
    <?php echo $__env->make('components.sidebar.sidebar-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('components.sidebar.sidebar-user-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('components.sidebar.sidebar-body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</nav>
<?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/components/sidebar/sidebar.blade.php ENDPATH**/ ?>