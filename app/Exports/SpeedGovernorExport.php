<?php

namespace App\Exports;

use App\Models\VehicleSpeedGovernorCertificate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SpeedGovernorExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return VehicleSpeedGovernorCertificate::query()
            ->join('vehicles', 'vehicle_speed_governor_certificates.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                'vehicles.plate_number as Vehicle',
                'users.name as Driver',
                'vehicle_speed_governor_certificates.certificate_no as Certificate No',
                'vehicle_speed_governor_certificates.date_of_installation as Date of Issue',
                'vehicle_speed_governor_certificates.expiry_date as Date of Expiry',
                DB::raw("CASE WHEN vehicle_speed_governor_certificates.status = 'active' THEN 'Active' ELSE 'Inactive' END as Status")
            );
    }

    public function headings(): array
    {
        return [
            'Vehicle',
            'Driver',
            'Certificate No',
            'Date of Issue',
            'Date of Expiry',
            'Status',
        ];
    }
}
