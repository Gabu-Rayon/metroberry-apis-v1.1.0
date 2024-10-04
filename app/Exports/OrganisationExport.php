<?php 


namespace App\Exports;

use App\Models\Organisation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrganisationExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        // Constructor can be used if needed
    }

    public function collection()
    {
        // Process the data
        $organisations = Organisation::with('user')->get();
        $formattedOrganisations = $organisations->map(function ($organisation) {
            return [
                'name' => $organisation->user->name,
                'email' => $organisation->user->email,
                'phone' => $organisation->user->phone,
                'address' => $organisation->user->address,
                'organisation_code' => $organisation->organisation_code ?? null,
            ];
        });
        return $formattedOrganisations;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Address',
            'Organisation Code',
        ];
    }
}