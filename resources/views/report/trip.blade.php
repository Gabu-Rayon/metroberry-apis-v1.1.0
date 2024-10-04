@extends('layouts.app')

@section('title', 'Trips Report')


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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Trips report</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Customer">Customer</th>
                                                            <th title="Driver">Driver</th>
                                                            <th title="Vehicle">Vehicle</th>
                                                            <th title="Status">Status</th>
                                                            <th title="Income">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($trips as $trip)
                                                            <tr>
                                                                <td>{{ $trip->customer->user->name }}</td>
                                                                <td class="{{ $trip->vehicle ? '' : 'text-center' }}">
                                                                    {{ $trip->vehicle ? $trip->vehicle->driver->user->name : '-' }}
                                                                </td>
                                                                <td class="{{ $trip->vehicle ? '' : 'text-center' }}">
                                                                    {{ $trip->vehicle ? $trip->vehicle->plate_number : '-' }}
                                                                </td>
                                                                <td>
                                                                    @if ($trip->status == 'scheduled')
                                                                        <span class="badge bg-secondary">Scheduled</span>
                                                                    @elseif ($trip->status == 'billed')
                                                                        <span class="badge bg-success">Billed</span>
                                                                    @elseif ($trip->status == 'completed')
                                                                        <span class="badge bg-info">Completed</span>
                                                                    @elseif ($trip->status == 'cancelled')
                                                                        <span class="badge bg-danger">Cancelled</span>
                                                                    @else
                                                                        <span class="badge bg-warning">Invalid Status</span>
                                                                    @endif
                                                                </td>
                                                                <td class="{{ $trip->total_price ? '' : 'text-center' }}">
                                                                    {{ $trip->total_price ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="4" class="text-center font-bold"><strong>Total
                                                                    Income</strong></td>
                                                            @php
                                                                $totalIncome = 0;
                                                                foreach ($trips as $trip) {
                                                                    $totalIncome += $trip->total_price;
                                                                }
                                                            @endphp
                                                            <td class="text-center font-bold">
                                                                <strong>{{ $totalIncome }}</strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
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
    @endsection
