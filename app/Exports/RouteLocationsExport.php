<?php

namespace App\Exports;

use App\Models\RouteLocations;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RouteLocationsExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return RouteLocations::query()
            ->join('routes', 'route_locations.route_id', '=', 'routes.id')
            ->select(
                'route_locations.name as Location',
                'routes.name as Route'
            );
    }

    public function headings(): array
    {
        return [
            'Location',
            'Route'
        ];
    }
}
