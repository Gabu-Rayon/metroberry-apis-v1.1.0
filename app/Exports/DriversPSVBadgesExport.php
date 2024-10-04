<?php

namespace App\Exports;

use App\Models\PSVBadge;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriversPSVBadgesExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return PSVBadge::query()
            ->join('drivers', 'psv_badges.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                'users.name as driver_name',
                'psv_badges.psv_badge_no',
                'psv_badges.psv_badge_date_of_issue',
                'psv_badges.psv_badge_date_of_expiry',
                DB::raw("CASE WHEN psv_badges.verified = 1 THEN 'Yes' ELSE 'No' END as verified")
            );
    }

    public function headings(): array
    {
        return [
            'Driver',
            'PSV Badge No',
            'Date of Issue',
            'Date of Expiry',
            'Verified',
        ];
    }
}
