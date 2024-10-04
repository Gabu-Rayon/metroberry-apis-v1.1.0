<?php
namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DriverExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        // Constructor is empty since no parameters are needed
    }

    public function collection()
    {
        $drivers = Driver::with(['user', 'organization.user'])->get();

        $formattedDrivers = $drivers->map(function ($driver) {
            return [
                'name' => $driver->user->name ?? 'N/A',
                'email' => $driver->user->email ?? 'N/A',
                'phone' => $driver->user->phone ?? 'N/A',
                'address' => $driver->user->address ?? 'N/A',
                'organisation' => optional($driver->organization)->user->name ?? 'N/A',
                'nation_id_no' => $driver->national_id_no ?? 'N/A',
            ];
        });

        return $formattedDrivers;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Address',
            'Organisation',
            'ID Number'
        ];
    }
}