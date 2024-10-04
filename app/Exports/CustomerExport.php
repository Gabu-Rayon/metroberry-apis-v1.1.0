<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */

    protected $role;
    protected $organisation;

    public function __construct($role, $organisation)
    {
        $this->role = $role;
        $this->organisation = $organisation;
    }

    public function query()
    {
        $query = Customer::query()
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->select(
                'users.name as Name',
                'users.email as Email',
                'users.phone as Phone',
                'users.address as Address',
                'customers.customer_organisation_code as Organisation',
                'customers.national_id_no as ID Number'
            );

        if ($this->role !== 'admin') {
            // Ensure that $this->organisation is not null
            if ($this->organisation) {
                $query->where('customers.customer_organisation_code', $this->organisation->organisation_code);
            } else {
                // Optionally handle cases where $this->organisation is null
                $query->whereRaw('1 = 0'); // This will effectively return no results
            }
        }

        return $query;
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
