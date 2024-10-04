<nav class="sidebar-nav card sub-side-bar p-2 py-3">

    <ul class=" nav">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">
                <i class="typcn typcn-adjust-brightness"></i>
                General Settings
            </a>

            <ul class="dropdown-menu">

                <li class="mm-active">
                    <a href="<?php echo e(route('settings.site')); ?>" class="dropdown-item settings-goroup">Site</a>
                </li>

                <li class="">
                    <a href="admin/setting?g=Vendor" class="dropdown-item settings-goroup">Vendor</a>
                </li>

                <li class="">
                    <a href="admin/setting?g=Fuel" class="dropdown-item settings-goroup">Fuel</a>
                </li>

                <li class="">
                    <a href="admin/setting?g=Maintenance" class="dropdown-item settings-goroup">Maintenance</a>
                </li>

                <li class="">
                    <a href="admin/setting?g=Inventory" class="dropdown-item settings-goroup">Inventory</a>
                </li>

                <li class="">
                    <a href="admin/setting?g=Purchase" class="dropdown-item settings-goroup">Purchase</a>
                </li>

            </ul>
        </li>

        <li class="nav-item  ">
            <a href="admin/setting/mail">
                <i class="typcn typcn-mail"></i>
                Mail setting
            </a>
        </li>

        <li class="nav-item  ">
            <a href="admin/setting/env">
                <i class="typcn typcn-document-text"></i>
                Env setting
            </a>
        </li>

        <li class="nav-item  ">
            <a href="admin/language">
                <i class="typcn typcn-sort-alphabetically"></i>
                Language
            </a>
        </li>

        <li class="nav-item  ">
            <a href="javascript:void(0);" onclick="storageLink('dev/artisan-http/storage-link')">
                <i class="typcn typcn-arrow-loop-outline"></i>
                Fix storage link
            </a>
        </li>

    </ul>
</nav>
<?php /**PATH /home/kknuicdz/metroBerry/resources/views/components/settings-nav.blade.php ENDPATH**/ ?>