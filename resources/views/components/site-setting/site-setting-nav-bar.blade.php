<nav class="sidebar-nav card py-2 sub-side-bar p-2 py-3">
    <ul class=" nav">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                aria-expanded="false">
                <i class="typcn typcn-adjust-brightness"></i>
                General settings
            </a>
            <ul class="dropdown-menu">
                <li class="">
                    <a href="{{ route('settings.site') }}" class="dropdown-item settings-goroup">Site</a>
                </li>
                <li class="">
                    <a href="{{ route('settings.fueling') }}" class="dropdown-item settings-goroup">Fuel</a>
                </li>
                <li class="">
                    <a href="{{ route('settings.maintenance') }}" class="dropdown-item settings-goroup">Maintenance</a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('settings.mail') }}">
                <i class="typcn typcn-mail"></i>
                Mail setting
            </a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('settings.env') }}">
                <i class="typcn typcn-document-text"></i>
                Env setting
            </a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('settings.language') }}">
                <i class="typcn typcn-sort-alphabetically"></i>
                Language
            </a>
        </li>
    </ul>
</nav>
