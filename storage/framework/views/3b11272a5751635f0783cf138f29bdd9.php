<li>
    <a class="has-arrow material-ripple" href="javascript:void(0);">
        <div>
            <?php echo $icon; ?>

            <?php echo e($title); ?>

        </div>
    </a>
    <ul class="nav-second-level">
        <?php $__currentLoopData = $subitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a class="text-capitalize" href="<?php echo e($subitem['route']); ?>" target="_self">
                <?php echo e($subitem['label']); ?>

            </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</li>
<?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/components/sidebar/sidebar-dropdown.blade.php ENDPATH**/ ?>