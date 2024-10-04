<?php

namespace App\Exports;

use App\Models\VehicleInsurance;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleInsuranceExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return VehicleInsurance::query()
            ->join('vehicles', 'vehicle_insurances.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                'users.name as Driver',
                'vehicles.plate_number as Vehicle',
                'vehicle_insurances.insurance_policy_no',
                'vehicle_insurances.insurance_date_of_issue',
                'vehicle_insurances.insurance_date_of_expiry',
                DB::raw("CASE WHEN vehicle_insurances.status = 1 THEN 'Active' ELSE 'Inactive' END as status")
            );
    }

    public function headings(): array
    {
        return [
            'Driver',
            'Vehicle',
            'Insurance Policy No',
            'Date of Issue',
            'Date of Expiry',
            'Status',
        ];
    }
}
