@extends('layouts.app')

@section('title', 'Cancelled Trips')
@section('content')

    <body class="fixed sidebar-mini">

        @include('components.preloader')
        <!-- react page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- start header -->
                @include('components.sidebar.sidebar')
                <!-- end header -->
                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Cancelled Trips</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Name">Customer</th>
                                                            <th title="Location">Driver</th>
                                                            <th title="NoOfEmployee">Vehicle</th>
                                                            <th title="Registration date">Route</th>
                                                            <th title="Email">Time</th>
                                                            <th title="Email">Date</th>
                                                            <th title="Email">Pick Up</th>
                                                            <th title="Email">Drop Off</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($cancelledTrips as $organisation => $trips)
                                                            @foreach ($trips as $trip)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        {{ $trip->customer->user->name }}</td>
                                                                    <td class="text-center">
                                                                        @if ($trip->vehicle)
                                                                            {{ $trip->vehicle->driver->user->name }}
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
                                                                    <td class="text-center">{{ $trip->route->name }}</td>
                                                                    <td class="text-center">{{ $trip->pick_up_time }}</td>
                                                                    <td class="text-center">
                                                                        {{ \Carbon\Carbon::parse($trip->trip_date)->isoFormat('MMMM Do, YYYY') }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @php
                                                                            $location = null;
                                                                            if ($trip->pick_up_location == 'Home') {
                                                                                $location =
                                                                                    $trip->customer->user->address;
                                                                            } elseif (
                                                                                $trip->pick_up_location == 'Office'
                                                                            ) {
                                                                                $location =
                                                                                    $trip->customer->organisation->user
                                                                                        ->address;
                                                                            } else {
                                                                                $location = $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->pick_up_location,
                                                                                    )
                                                                                    ->first()->name;
                                                                            }
                                                                        @endphp
                                                                        {{ $location }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @php
                                                                            $location = null;
                                                                            if ($trip->drop_off_location == 'Home') {
                                                                                $location =
                                                                                    $trip->customer->user->address;
                                                                            } elseif (
                                                                                $trip->drop_off_location == 'Office'
                                                                            ) {
                                                                                $location =
                                                                                    $trip->customer->organisation->user
                                                                                        ->address;
                                                                            } else {
                                                                                $location = $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->drop_off_location,
                                                                                    )
                                                                                    ->first()->name;
                                                                            }
                                                                        @endphp
                                                                        {{ $location }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
            <!--end  vue page -->
        </div>
        <!-- END layout-wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form">
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item? you won t be able to revert this item back!
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-danger" type="submit" id="delete_submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
