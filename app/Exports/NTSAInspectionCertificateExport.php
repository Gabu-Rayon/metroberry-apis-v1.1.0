<?php

namespace App\Exports;

use App\Models\NTSAInspectionCertificate;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NTSAInspectionCertificateExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return NTSAInspectionCertificate::query()
            ->join('vehicles', 'ntsa_inspection_certificates.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                'vehicles.plate_number as Vehicle',
                'users.name as Driver',
                'ntsa_inspection_certificates.ntsa_inspection_certificate_no as Certificate No',
                'ntsa_inspection_certificates.ntsa_inspection_certificate_date_of_issue as Date of Issue',
                'ntsa_inspection_certificates.ntsa_inspection_certificate_date_of_expiry as Date of Expiry',
                DB::raw("CASE WHEN ntsa_inspection_certificates.verified = 1 THEN 'Verified' ELSE 'Not Verified' END as Status")
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
