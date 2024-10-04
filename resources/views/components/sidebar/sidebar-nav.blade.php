<nav class="sidebar-nav">
    <ul class="metismenu text-capitalize">

        @if (\Auth::user()->can('view dashboard'))
            @include('components.sidebar.sidebar-item', [
                'isActive' => request()->routeIs('dashboard'),
                'route' => route('dashboard'),
                'icon' => '<i class="fa-solid fa-chart-column"></i>',
                'label' => 'Dashboard',
            ])
        @endif

        @if (\Auth::user()->can('manage users'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Users',
                'icon' => '<i class="fa-solid fa-users"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('manage customers')
                        ? ['label' => 'Employees', 'route' => route('employee')]
                        : null,
                    \Auth::user()->can('manage organisations')
                        ? ['label' => 'Organisations', 'route' => route('organisation')]
                        : null,
                    \Auth::user()->can('manage drivers')
                        ? ['label' => 'Drivers', 'route' => route('driver')]
                        : null,
                    \Auth::user()->can('manage driver licenses')
                        ? ['label' => 'Licenses', 'route' => route('driver.license')]
                        : null,
                    \Auth::user()->can('manage driver psvbadges')
                        ? ['label' => 'PSV Badges', 'route' => route('driver.psvbadge.index')]
                        : null,
                    \Auth::user()->can('show driver performance')
                        ? ['label' => 'Driver Performance', 'route' => route('driver.performance.index')]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage vehicles'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Vehicles',
                'icon' => '<i class="fa-solid fa-car"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('view vehicles')
                        ? ['label' => 'Vehicles', 'route' => route('vehicle')]
                        : null,
                    \Auth::user()->can('manage vehicle insurances')
                        ? ['label' => 'Vehicle Insurances', 'route' => route('vehicle.insurance.index')]
                        : null,
                    \Auth::user()->can('manage vehicle inspection certificates')
                        ? [
                            'label' => 'NTSA Inspection Certificates',
                            'route' => route('vehicle.inspection.certificate'),
                        ]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage routes'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Routes',
                'icon' => '<i class="fa-solid fa-route"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('manage routes')
                        ? ['label' => 'Routes', 'route' => route('route.index')]
                        : null,
                    \Auth::user()->can('manage route locations')
                        ? ['label' => 'Route Locations', 'route' => route('route.location.index')]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage trips'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Trips',
                'icon' => '<i class="fa-solid fa-suitcase-rolling"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('view trips')
                        ? ['label' => 'Scheduled Trips', 'route' => route('trip.scheduled')]
                        : null,
                    \Auth::user()->can('view trips')
                        ? ['label' => 'Assigned Trips', 'route' => route('trip.assigned')]
                        : null,
                    \Auth::user()->can('view trips')
                        ? ['label' => 'Completed Trips', 'route' => route('trip.completed')]
                        : null,
                    \Auth::user()->can('view trips')
                        ? ['label' => 'Cancelled Trips', 'route' => route('trip.cancelled')]
                        : null,
                    \Auth::user()->can('view trips')
                        ? ['label' => 'Billed Trips', 'route' => route('trip.billed')]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage insurance companies'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Insurance',
                'icon' => '<i class="fa-solid fa-car-burst"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('manage insurance companies')
                        ? ['label' => 'Manage Insurance Company', 'route' => route('vehicle.insurance.company')]
                        : null,
                    \Auth::user()->can('manage insurance company recurring periods')
                        ? [
                            'label' => 'Insurance Recurring Period',
                            'route' => route('vehicle.insurance.recurring.period'),
                        ]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage maintenance'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Maintenance',
                'icon' => '<i class="fa-solid fa-screwdriver-wrench"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('view maintenance')
                        ? ['label' => 'Maintenance Service', 'route' => route('maintenance.service')]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? ['label' => 'Maintenance Repair', 'route' => route('maintenance.repair')]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? ['label' => 'Service Types', 'route' => route('vehicle.maintenance.service')]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? [
                            'label' => 'Service Categories',
                            'route' => route('vehicle.maintenance.service.categories'),
                        ]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? ['label' => 'Vehicle Parts', 'route' => route('vehicle.maintenance.parts')]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? [
                            'label' => 'Vehicle Part Categories',
                            'route' => route('vehicle.maintenance.parts.category'),
                        ]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? ['label' => 'Repair Types', 'route' => route('vehicle.maintenance.repairs')]
                        : null,
                    \Auth::user()->can('view maintenance')
                        ? [
                            'label' => 'Repair Categories',
                            'route' => route('vehicle.maintenance.repairs.categories'),
                        ]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage fuelling'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Refueling',
                'icon' => '<i class="fa-solid fa-gas-pump"></i>',
                'subitems' => array_filter([
                    ['label' => 'Fuel Requisition', 'route' => route('refueling.index')],
                    \Auth::user()->can('view fuelling stations')
                        ? ['label' => 'Fuel Stations', 'route' => route('refueling.station')]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('view reports'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Reports',
                'icon' => '<i class="fa-solid fa-file-lines"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Employee Report', 'route' => route('report.employee')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Driver Report', 'route' => route('report.driver')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Vehicle Report', 'route' => route('report.vehicle')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Trips Report', 'route' => route('report.trips')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Service Report', 'route' => route('report.service')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Repairs Report', 'route' => route('report.repairs')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Fueling Report', 'route' => route('report.refueling')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Expenses', 'route' => route('expenses.index')]
                        : null,
                    \Auth::user()->can('view reports')
                        ? ['label' => 'Incomes', 'route' => route('incomes.index')]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('manage permissions'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Access Management',
                'icon' => '<i class="fa-solid fa-wand-sparkles"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('view permissions')
                        ? ['label' => 'Permission', 'route' => route('permission.index')]
                        : null,
                    \Auth::user()->can('create role')
                        ? ['label' => 'Role', 'route' => route('permission.role')]
                        : null,
                ]),
            ])
        @endif
        @if (\Auth::user()->can('view bank accounts'))
            @include('components.sidebar.sidebar-dropdown', [
                'title' => 'Accounting Setting',
                'icon' => '<i class="fas fa-university"></i>',
                'subitems' => array_filter([
                    \Auth::user()->can('view bank accounts')
                        ? ['label' => 'Bank Accounts', 'route' => route('metro.berry.account.setting')]
                        : null,
                ]),
            ])
        @endif

        @if (\Auth::user()->can('view bank accounts'))
            @include('components.sidebar.sidebar-item', [
                'isActive' => request()->routeIs('settings.*'),
                'route' => route('settings.site'),
                'icon' => '<i class="fa-solid fa-gear"></i>',
                'label' => 'Settings',
            ])
        @endif




    </ul>
</nav>
