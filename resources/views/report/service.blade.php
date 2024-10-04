@extends('layouts.app')

@section('title', 'Services Report')

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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Services report</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Vehicle">Vehicle</th>
                                                            <th title="Requested By">Requested By</th>
                                                            <th title="Status">Status</th>
                                                            <th title="Income">Income</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($services as $service)
                                                            <tr>
                                                                <td>{{ $service->vehicle->plate_number }}</td>
                                                                <td>{{ $service->creator->name }}</td>
                                                                <td>
                                                                    @if ($service->service_status == 'pending')
                                                                        <span class="badge bg-secondary">Pending</span>
                                                                    @elseif ($service->service_status == 'billed')
                                                                        <span class="badge bg-success">Billed</span>
                                                                    @elseif ($service->service_status == 'approved')
                                                                        <span class="badge bg-info">Approved</span>
                                                                    @elseif ($service->service_status == 'rejected')
                                                                        <span class="badge bg-danger">Rejected</span>
                                                                    @else
                                                                        <span class="badge bg-warning">Invalid Status</span>
                                                                    @endif
                                                                </td>
                                                                <td
                                                                    class="{{ $service->service_cost ? '' : 'text-center' }}">
                                                                    {{ $service->service_cost ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="3" class="text-center font-bold"><strong>Total
                                                                    Expenses</strong></td>
                                                            @php
                                                                $totalExpense = 0;
                                                                foreach ($services as $service) {
                                                                    if ($service->service_status == 'billed') {
                                                                        $totalExpense += $service->service_cost;
                                                                    }
                                                                }
                                                            @endphp
                                                            <td class="text-center font-bold">
                                                                <strong>{{ $totalExpense }}</strong></td>
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
        </div>
        </div>
        </div>
    </body>
@endsection
