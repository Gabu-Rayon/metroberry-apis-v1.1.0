@extends('layouts.app')

@section('title', 'Completed Trips List')
@section('content')

    <body class="fixed sidebar-mini">

        @include('components.preloader')
        <div id="app">
            <div class="wrapper">
                @include('components.sidebar.sidebar')
                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Completed Trips List</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                            </div>
                                        </div>

                                        <div>
                                            <div class="table-responsive">
                                                @if ($groupByOrganisation)
                                                    @foreach ($trips as $organisationName => $tripsGroup)
                                                        <h5>{{ $organisationName }}</h5>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Customer</th>
                                                                    <th>Driver</th>
                                                                    <th>Vehicle</th>
                                                                    <th>Route</th>
                                                                    <th>Pick Up Time</th>
                                                                    <th>Date</th>
                                                                    <th>Pick Up Location</th>
                                                                    <th>Drop Off Location</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($tripsGroup as $trip)
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            {{ $trip->customer->user->name ?? 'N/A' }}</td>
                                                                        <td class="text-center">
                                                                            @if ($trip->vehicle && $trip->vehicle->driver)
                                                                                {{ $trip->vehicle->driver->user->name ?? 'Unassigned' }}
                                                                            @else
                                                                                <span
                                                                                    class="btn btn-danger btn-sm">Unassigned</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @if ($trip->vehicle)
                                                                                <span
                                                                                    class="btn btn-success btn-sm">{{ $trip->vehicle->plate_number }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="btn btn-danger btn-sm">Unassigned</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $trip->route->name ?? 'N/A' }}</td>
                                                                        <td class="text-center">{{ $trip->pick_up_time }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ \Carbon\Carbon::parse($trip->trip_date)->format('F j, Y') }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @php
                                                                                $location = match (
                                                                                    $trip->pick_up_location
                                                                                ) {
                                                                                    'Home' => $trip->customer->user
                                                                                        ->address ?? 'N/A',
                                                                                    'Office' => $trip->customer
                                                                                        ->organisation->user->address ??
                                                                                        'N/A',
                                                                                    default
                                                                                        => $trip->route->route_locations
                                                                                        ->where(
                                                                                            'id',
                                                                                            $trip->pick_up_location,
                                                                                        )
                                                                                        ->first()->name ?? 'N/A',
                                                                                };
                                                                            @endphp
                                                                            {{ $location }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            @php
                                                                                $location = match (
                                                                                    $trip->drop_off_location
                                                                                ) {
                                                                                    'Home' => $trip->customer->user
                                                                                        ->address ?? 'N/A',
                                                                                    'Office' => $trip->customer
                                                                                        ->organisation->user->address ??
                                                                                        'N/A',
                                                                                    default
                                                                                        => $trip->route->route_locations
                                                                                        ->where(
                                                                                            'id',
                                                                                            $trip->drop_off_location,
                                                                                        )
                                                                                        ->first()->name ?? 'N/A',
                                                                                };
                                                                            @endphp
                                                                            {{ $location }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="8" class="text-center">No completed
                                                                            trips available.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    @endforeach
                                                @else
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <th>Driver</th>
                                                                <th>Vehicle</th>
                                                                <th>Route</th>
                                                                <th>Pick Up Time</th>
                                                                <th>Date</th>
                                                                <th>Pick Up Location</th>
                                                                <th>Drop Off Location</th>
                                                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'organisation')
                                                                    <th title="Action" width="150">Action</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($trips as $trip)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        {{ $trip->customer->user->name ?? 'N/A' }}</td>
                                                                    <td class="text-center">
                                                                        @if ($trip->vehicle && $trip->vehicle->driver)
                                                                            {{ $trip->vehicle->driver->user->name ?? 'Unassigned' }}
                                                                        @else
                                                                            <span
                                                                                class="btn btn-danger btn-sm">Unassigned</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if ($trip->vehicle)
                                                                            <span
                                                                                class="btn btn-success btn-sm">{{ $trip->vehicle->plate_number }}</span>
                                                                        @else
                                                                            <span
                                                                                class="btn btn-danger btn-sm">Unassigned</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $trip->route->name ?? 'N/A' }}</td>
                                                                    <td class="text-center">{{ $trip->pick_up_time }}</td>
                                                                    <td class="text-center">
                                                                        {{ \Carbon\Carbon::parse($trip->trip_date)->format('F j, Y') }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @php
                                                                            $location = match (
                                                                                $trip->pick_up_location
                                                                            ) {
                                                                                'Home' => $trip->customer->user
                                                                                    ->address ?? 'N/A',
                                                                                'Office' => $trip->customer
                                                                                    ->organisation->user->address ??
                                                                                    'N/A',
                                                                                default => $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->pick_up_location,
                                                                                    )
                                                                                    ->first()->name ?? 'N/A',
                                                                            };
                                                                        @endphp
                                                                        {{ $location }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @php
                                                                            $location = match (
                                                                                $trip->drop_off_location
                                                                            ) {
                                                                                'Home' => $trip->customer->user
                                                                                    ->address ?? 'N/A',
                                                                                'Office' => $trip->customer
                                                                                    ->organisation->user->address ??
                                                                                    'N/A',
                                                                                default => $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->drop_off_location,
                                                                                    )
                                                                                    ->first()->name ?? 'N/A',
                                                                            };
                                                                        @endphp
                                                                        {{ $location }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if (auth()->user()->can('add billing details'))
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-sm btn-primary"
                                                                                onclick="axiosModal('{{ $trip->id }}/details')"
                                                                                title="Details">
                                                                                <i class="fa-solid fa-circle-info"></i>
                                                                            </a>
                                                                        @endif
                                                                        <span class='m-1'></span>
                                                                        @if ($trip->is_billable())
                                                                            @if (auth()->user()->can('bill trip'))
                                                                                <a href="javascript:void(0);"
                                                                                    onclick="axiosModal('/trip/{{ $trip->id }}/bill')"
                                                                                    class="btn btn-warning btn-sm"
                                                                                    title="Bill">
                                                                                    <i class="fa fa-file text-white"></i>
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No completed
                                                                        trips available.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>

                                            <div id="page-axios-data" data-table-id="#driver-table"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    @include('components.footer')
                </div>
            </div>
        </div>

        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="delete-form" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3">
                                <p>Are you sure you want to delete this item?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
