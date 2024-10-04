<?php

namespace App\Exports;

use App\Models\DriversLicenses;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriversLicensesExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return DriversLicenses::query()
            ->join('drivers', 'drivers_licenses.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                'users.name as driver_name',
                'drivers_licenses.driving_license_no',
                'drivers_licenses.driving_license_date_of_issue',
                'drivers_licenses.driving_license_date_of_expiry',
                DB::raw("CASE WHEN drivers_licenses.verified = 1 THEN 'Yes' ELSE 'No' END as verified")
            );
    }

    public function headings(): array
    {
        return [
            'Driver',
            'Driving License No',
            'Date of Issue',
            'Date of Expiry',
            'Verified',
        ];
    }
}
