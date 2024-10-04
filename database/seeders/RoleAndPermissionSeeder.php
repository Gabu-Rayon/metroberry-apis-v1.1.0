<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsByActions
{
    public const DASHBOARD_MANAGEMENT_PERMISSIONS = [
        'view dashboard',
        'manage users',
    ];

    public const PROFILE_MANAGEMENT_PERMISSIONS = [
        'view profile',
        'edit profile',
        'delete profile',
    ];

    public const EMPLOYEE_MANAGEMENT_PERMISSIONS = [
        'manage customers',
        'view customers',
        'create customer',
        'edit customer',
        'delete customer',
        'activate customer',
        'deactivate customer',
        'update customer',
        'activate customer',
        'deactivate customer',
        'import customers',
        'export customers',
    ];

    public const ORGANISATION_MANAGEMENT_PERMISSIONS = [
        'manage organisations',
        'view organisations',
        'create organisation',
        'edit organisation',
        'delete organisation',
        'update organisation',
        'activate organisation',
        'deactivate organisation',
        'export organisations',
        'import organisations',
        'show organisation',
    ];

    public const DRIVER_MANAGEMENT_PERMISSIONS = [
        'manage drivers',
        'view drivers',
        'show driver',
        'create driver',
        'edit driver',
        'activate driver',
        'deactivate driver',
        'assign vehicle',
        'unassign vehicle',
        'delete driver',
        'export drivers',
        'import drivers',
    ];

    public const DRIVER_LICENSE_MANAGEMENT_PERMISSIONS = [
        'manage driver licenses',
        'view driver licenses',
        'show driver license',
        'create driver license',
        'edit driver license',
        'verify driver license',
        'revoke driver license',
        'delete driver license',
        'export driver licenses',
        'import driver licenses',
    ];

    public const DRIVER_PSVBADGE_MANAGEMENT_PERMISSIONS = [
        'manage driver psvbadges',
        'view driver psvbadges',
        'show driver psvbadge',
        'create driver psvbadge',
        'edit driver psvbadge',
        'verify driver psvbadge',
        'revoke driver psvbadge',
        'delete driver psvbadge',
        'export driver psvbadges',
        'import driver psvbadges',
    ];

    public const DRIVER_PERFORMANCE_MANAGEMENT_PERMISSIONS = [
        'show driver performance',
    ];

    public const VEHICLE_MANAGEMENT_PERMISSIONS = [
        'manage vehicles',
        'view vehicles',
        'show vehicle',
        'create vehicle',
        'edit vehicle',
        'delete vehicle',
        'activate vehicle',
        'deactivate vehicle',
        'assign driver',
        'unassign driver',
        'export vehicles',
        'import vehicles',
    ];

    public const VEHICLE_INSURANCE_MANAGEMENT_PERMISSIONS = [
        'manage vehicle insurances',
        'view vehicle insurances',
        'show vehicle insurance',
        'create vehicle insurance',
        'edit vehicle insurance',
        'delete vehicle insurance',
        'activate vehicle insurance',
        'deactivate vehicle insurance',
        'export vehicle insurances',
        'import vehicle insurances',
    ];

    public const VEHICLE_INSPECTION_CERTIFICATE_MANAGEMENT_PERMISSIONS = [
        'manage vehicle inspection certificates',
        'view vehicle inspection certificates',
        'show vehicle inspection certificate',
        'create vehicle inspection certificate',
        'edit vehicle inspection certificate',
        'delete vehicle inspection certificate',
        'activate vehicle inspection certificate',
        'deactivate vehicle inspection certificate',
        'export vehicle inspection certificates',
        'import vehicle inspection certificates',
    ];

    public const ROUTE_MANAGEMENT_PERMISSIONS = [
        'manage routes',
        'view routes',
        'show route',
        'create route',
        'edit route',
        'delete route',
        'activate route',
        'deactivate route',
        'export routes',
        'import routes',
    ];

    public const ROUTE_LOCATION_MANAGEMENT_PERMISSIONS = [
        'manage route locations',
        'view route locations',
        'show route location',
        'create route location',
        'edit route location',
        'delete route location',
        'activate route location',
        'deactivate route location',
        'export route locations',
        'import route locations',
    ];

    public const TRIP_MANAGEMENT_PERMISSIONS = [
        'manage trips',
        'view trips',
        'schedule trip',
        'assign vehicle to upcoming trips',
        'cancel trip',
        'complete trip',
        'add billing details',
        'bill trip',
        'pay for trip',
        'send trip invoice',
        'view trip invoice',
        'recieve trip payment',
        'export trips',
        'import trips',
    ];

    public const INSURANCE_COMPANY_MANAGEMENT_PERMISSIONS = [
        'manage insurance companies',
        'view insurance companies',
        'show insurance company',
        'create insurance company',
        'edit insurance company',
        'delete insurance company',
        'activate insurance company',
        'deactivate insurance company',
        'export insurance companies',
        'import insurance companies',
    ];

    public const INSURANCE_COMPANY_RECURRING_PERIODS_MANAGEMENT_PERMISSIONS = [
        'manage insurance company recurring periods',
        'view insurance company recurring periods',
        'show insurance company recurring period',
        'create insurance company recurring period',
        'edit insurance company recurring period',
        'delete insurance company recurring period',
        'activate insurance company recurring period',
        'deactivate insurance company recurring period',
        'export insurance company recurring periods',
        'import insurance company recurring periods',
    ];

    public const MAINTENANCE_MANAGEMENT_PERMISSIONS = [
        'manage maintenance',
        'view maintenance',
        'show maintenance',
        'create maintenance',
        'edit maintenance',
        'delete maintenance',
        'activate maintenance',
        'deactivate maintenance',
        'export maintenance',
        'import maintenance',
    ];

    public const FUELLING_MANAGEMENT_PERMISSIONS = [
        'manage fuelling',
        'view fuelling',
        'show fuelling',
        'create fuelling',
        'edit fuelling',
        'delete fuelling',
        'activate fuelling',
        'deactivate fuelling',
        'export fuelling',
        'import fuelling',
    ];

    public const FUELLING_STATIONS_MANAGEMENT_PERMISSIONS = [
        'manage fuelling stations',
        'view fuelling stations',
        'show fuelling station',
        'create fuelling station',
        'edit fuelling station',
        'delete fuelling station',
        'activate fuelling station',
        'deactivate fuelling station',
        'export fuelling stations',
        'import fuelling stations',
    ];

    public const REPORTS_MANAGEMENT_PERMISSIONS = [
        'view reports',
        'export reports',
    ];

    public const ROLE_MANAGEMENT_PERMISSIONS = [
        'manage roles',
        'view roles',
        'show role',
        'create role',
        'edit role',
        'delete role',
        'activate role',
        'deactivate role',
        'export roles',
        'import roles',
    ];

    public const PERMISSION_MANAGEMENT_PERMISSIONS = [
        'manage permissions',
        'view permissions',
        'show permission',
        'create permission',
        'edit permission',
        'delete permission',
        'activate permission',
        'deactivate permission',
        'export permissions',
        'import permissions',
    ];

    public const SETTINGS_MANAGEMENT_PERMISSIONS = [
        'manage settings',
        'view settings',
        'edit settings',
        'update settings',
        'export settings',
        'import settings',
    ];

    public const BANK_ACCOUNT_MANAGEMENT_PERMISSIONS = [
        'manage bank accounts',
        'view bank accounts',
        'show bank account',
        'create bank account',
        'edit bank account',
        'delete bank account',
        'activate bank account',
        'deactivate bank account',
        'export bank accounts',
        'import bank accounts',
    ];

    public const EXPENSE_MANAGEMENT_PERMISSIONS = [
        'manage expenses',
        'view expenses',
        'show expense',
        'create expense',
        'edit expense',
        'delete expense',
        'export expenses',
        'import expenses',
    ];

    public const INCOME_MANAGEMENT_PERMISSIONS = [
        'manage incomes',
        'view incomes',
        'show income',
        'create income',
        'edit income',
        'delete income',
        'export incomes',
        'import incomes',
    ];
}

class Permissions
{
    static array $admin_permissions;
    static array $organisation_permissions;
    static array $customer_permissions;
    static array $driver_permissions;
    static array $refueling_station_permissions;
}

Permissions::$admin_permissions = array_merge(
    PermissionsByActions::DASHBOARD_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::PROFILE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::EMPLOYEE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::ORGANISATION_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::DRIVER_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::DRIVER_LICENSE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::DRIVER_PSVBADGE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::DRIVER_PERFORMANCE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::VEHICLE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::VEHICLE_INSURANCE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::VEHICLE_INSPECTION_CERTIFICATE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::ROUTE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::ROUTE_LOCATION_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::TRIP_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::INSURANCE_COMPANY_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::INSURANCE_COMPANY_RECURRING_PERIODS_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::MAINTENANCE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::FUELLING_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::FUELLING_STATIONS_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::REPORTS_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::ROLE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::PERMISSION_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::SETTINGS_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::BANK_ACCOUNT_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::EXPENSE_MANAGEMENT_PERMISSIONS,
    PermissionsByActions::INCOME_MANAGEMENT_PERMISSIONS,
);

Permissions::$organisation_permissions = [
    'view dashboard',
    'manage users',
    'view profile',
    'edit profile',
    'delete profile',
    'manage customers',
    'view customers',
    'create customer',
    'edit customer',
    'delete customer',
    'activate customer',
    'deactivate customer',
    'update customer',
    'activate customer',
    'deactivate customer',
    'import customers',
    'export customers',
    'manage drivers',
    'view drivers',
    'show driver',
    'manage vehicles',
    'view vehicles',
    'show vehicle',
    'manage routes',
    'view routes',
    'show route',
    'manage route locations',
    'view route locations',
    'show route location',
    'manage trips',
    'view trips',
    'schedule trip',
    'pay for trip',
    'manage settings',
    'view settings',
    'edit settings',
    'update settings',
    'export settings',
    'import settings',
];

Permissions::$customer_permissions = [
    'view profile',
    'edit profile',
    'delete profile',
    'manage trips',
    'view trips',
    'schedule trip',
];

Permissions::$driver_permissions = [
    'view profile',
    'edit profile',
    'delete profile',
    'cancel trip',
    'complete trip',
    'manage maintenance',
    'view maintenance',
    'show maintenance',
    'create maintenance',
    'edit maintenance',
    'manage fuelling',
    'view fuelling',
    'show fuelling',
    'create fuelling',
    'edit fuelling',
];

Permissions::$refueling_station_permissions = [
    'view dashboard',
    'view profile',
    'edit profile',
    'delete profile',
    'manage fuelling',
    'view fuelling',
    'show fuelling',
    'create fuelling',
    'edit fuelling',
    'delete fuelling',
    'activate fuelling',
    'deactivate fuelling',
    'export fuelling',
    'import fuelling',
];


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'admin',
            'organisation',
            'customer',
            'driver',
            'refueling_station',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $permissions = array_merge(
            PermissionsByActions::DASHBOARD_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::PROFILE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::EMPLOYEE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::ORGANISATION_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::DRIVER_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::DRIVER_LICENSE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::DRIVER_PSVBADGE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::DRIVER_PERFORMANCE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::VEHICLE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::VEHICLE_INSURANCE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::VEHICLE_INSPECTION_CERTIFICATE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::ROUTE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::ROUTE_LOCATION_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::TRIP_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::INSURANCE_COMPANY_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::INSURANCE_COMPANY_RECURRING_PERIODS_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::MAINTENANCE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::FUELLING_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::FUELLING_STATIONS_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::REPORTS_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::ROLE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::PERMISSION_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::SETTINGS_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::BANK_ACCOUNT_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::EXPENSE_MANAGEMENT_PERMISSIONS,
            PermissionsByActions::INCOME_MANAGEMENT_PERMISSIONS,
        );

        /**
         * Create all permissions
         */
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::where('name', 'admin')->first();
        $organisation = Role::where('name', 'organisation')->first();
        $customer = Role::where('name', 'customer')->first();
        $driver = Role::where('name', 'driver')->first();
        $refuellingStation = Role::where('name', 'refueling_station')->first();

        $admin->syncPermissions(Permissions::$admin_permissions);
        $organisation->syncPermissions(Permissions::$organisation_permissions);
        $customer->syncPermissions(Permissions::$customer_permissions);
        $driver->syncPermissions(Permissions::$driver_permissions);
        $refuellingStation->syncPermissions(Permissions::$refueling_station_permissions);
    }
}
