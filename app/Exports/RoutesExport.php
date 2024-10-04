<?php

namespace App\Exports;

use App\Models\Routes;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RoutesExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Routes::query()->with(['start_location', 'waypoints', 'end_location']);
    }

    public function map($route): array
    {
        $start_location = $route->start_location ? $route->start_location->name : 'N/A';
        $end_location = $route->end_location ? $route->end_location->name : 'N/A';

        $waypoints = $route->waypoints->pluck('name')->join('-');

        return [
            $route->name,
            $route->county,
            $start_location,
            $waypoints,
            $end_location,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'County',
            'Start Location',
            'Waypoints',
            'End Location',
        ];
    }
}
