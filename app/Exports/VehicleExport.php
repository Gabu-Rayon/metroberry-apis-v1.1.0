<?php

namespace App\Exports;

use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB; // For using DB::raw()

class VehicleExport implements FromQuery, WithHeadings
{
    protected $role;
    protected $organisation;

    public function __construct($role, $organisation)
    {
        $this->role = $role;
        $this->organisation = $organisation;
    }

    public function query()
    {
        $query = Vehicle::query()
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                DB::raw("CONCAT(vehicles.make, ' ', vehicles.model) as Vehicle"), // Combine make and model
                'users.name as Driver',
                'vehicles.plate_number as Plate Number',
                'vehicles.class as Class',
                'vehicles.status as Status'
            );

        if ($this->role !== 'admin') {
            if ($this->organisation) {
                $query->where('organisations.organisation_code', $this->organisation->organisation_code);
            } else {
                $query->whereRaw('1 = 0'); // Ensure no results if no organisation
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Vehicle', // Combined make and model
            'Driver',
            'Plate Number',
            'Class',
            'Status',
        ];
    }
}