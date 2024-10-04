<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionGroup;

class PermissionsGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'settings' => [
                'view settings',
                'create settings',
                'edit settings',
                'delete settings',
                'update settings',
                'manage settings',
            ],
            'dashboard' => [
                'view dashboard',
                'edit profile',
                'update profile',
                'delete profile',
            ],
            'employee' => [
                'manage customers',
                'view customers',
                'create customer',
                'edit customer',
                'delete customer',
                'update customer',
                'activate customer',
                'deactivate customer',
                'import customer',
                'export customer',
            ],
            'organisation' => [
                'manage organisations',
                'view organisations',
                'create organisation',
                'edit organisation',
                'delete organisation',
                'update organisation',
                'import organisation',
                'export organisation',
            ],
            'drivers' => [
                'manage drivers',
                'view drivers',
                'create driver',
                'edit driver',
                'delete driver',
                'update driver',
                'activate driver',
                'deactivate driver',
                'assign driver',
                'unassign driver',
                'import driver',
                'export driver',
            ],
            'license' => [
                'manage driver licenses',
                'view driver licenses',
                'create driver license',
                'edit driver license',
                'verify driver license',
                'revoke driver license',
                'delete driver license',
                'update driver license',

                'manage driver license details',
                'view driver license details',
                'create driver license details',
                'edit driver license details',
                'delete driver license details'
            ],
            'psv_badge' => [
                'manage psv badges',
                'view psv badges',
                'create psv badge',
                'edit psv badge',
                'delete psv badge',
                'update psv badge',

                'manage psv badge details',
                'view psv badge details',
                'create psv badge details',
                'edit psv badge details',
                'delete psv badge details',
                'update psv badge details',

            ],
            'driver_performance' => [
                'manage drivers performances',
                'view driver performance',
                'create driver performance',
                'edit driver performance',
                'delete driver performance',
                'update driver performance',
                'view driver performance details',
                'create driver performance details',
            ],
            'vehicle' => [
                'view vehicle',
                'create vehicle',
                'edit vehicle',
                'update vehicle',
                'delete vehicle',
                'manage vehicles',
                'assign vehicle',
            ],
            'vehicle_insurance' => [
                'view vehicle insurance',
                'create vehicle insurance',
                'edit vehicle insurance',
                'delete vehicle insurance',
                'update vehicle insurance',
                'manage vehicle insurance',
            ],
            'route' => [
                'manage routes',
                'view route',
                'create route',
                'edit route',
                'delete route',
                'update route',
                'view route details',
                'create route details',
                'edit route details',
                'delete route details',
                'update route details',
                'manage route details',
            ],
            'route_location' => [
                'manage route locations',
                'view route location',
                'create route location',
                'edit route location',
                'delete route location',
                'update route location',
            ],
            'trip' => [
                'view trip',
                'create trip',
                'edit trip',
                'start trip',
                'end trip',
                'cancel trip',
                'delete trip',
                'update trip',
                'manage trips',
                'complete trip',
                'cancel trip',
                'pay trip',
                'download trip invoice',
                'resend trip invoice',
                'send trip invoice',
            ],
            'insurance_company' => [
                'view vehicle insurance company',
                'create vehicle insurance company',
                'edit vehicle insurance company',
                'delete vehicle insurance company',
                'activate vehicle insurance company',
                'deactivate vehicle insurance company',
                'update vehicle insurance company',
                'manage vehicle insurance company',
            ],
            'vehicle_maintenance' => [
                'view vehicle maintenance',
                'create vehicle maintenance',
                'edit vehicle maintenance',
                'delete vehicle maintenance',
                'update vehicle maintenance',
                'manage vehicle maintenance',
                'bill vehicle maintenance',
                'pay vehicle maintenance',
                'download vehicle maintenance',
                'resend vehicle maintenance',
                'send vehicle maintenance'
            ],
            'account_setting' => [
                'view accounting setting',
                'create accounting setting',
                'edit accounting setting',
                'delete accounting setting',
                'update accounting setting',
                'manage accounting setting',
            ],
        ];

        foreach ($permissions as $groupName => $groupPermissions) {
            foreach ($groupPermissions as $permission) {
                PermissionGroup::firstOrCreate([
                    'permission_name' => $permission,
                    'group_name' => $groupName,
                ]);
            }
        }
    }
}