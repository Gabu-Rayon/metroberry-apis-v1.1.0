@extends('layouts.app')

@section('title', 'Billed Trips')
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
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                @if ($billedTrips->isNotEmpty())
                                                    @foreach ($billedTrips as $organisationName => $trips)
                                                        <h5>{{ $organisationName }}</h5>
                                                        <table class="table" id="driver-table">
                                                            <thead>
                                                                <tr>
                                                                    <th title="Name">Customer</th>
                                                                    <th title="Billing Rate">Billing Rate</th>
                                                                    <th title="Total Price" width="150">Total Price</th>
                                                                    <th title="Billed At">Billed At</th>
                                                                    <th title="Trip Status">Status</th>
                                                                    <th title="Action" width="150">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($trips as $trip)
                                                                    <tr>
                                                                        <td>{{ $trip->customer->user->name ?? 'N/A' }}</td>
                                                                        <td>{{ $trip->billingRate->name ?? 'N/A' }}</td>
                                                                        <td>{{ $trip->total_price }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($trip->billed_at)->format('F jS, Y \a\t h:i a') }}
                                                                        </td>
                                                                        <td>
                                                                            @if ($trip->status == 'billed')
                                                                                <span class="badge bg-success">Billed</span>
                                                                            @elseif ($trip->status == 'paid')
                                                                                <span class="badge bg-success">Paid</span>
                                                                            @else
                                                                                <span class="badge bg-danger">Partially
                                                                                    Paid</span>
                                                                            @endif
                                                                        </td>

                                                                        <td class="text-center">
                                                                            @if (Auth::user()->can('pay for trip'))
                                                                                <a href="{{ route('trip.payment.checkout', ['id' => $trip->id]) }}"
                                                                                    class="btn btn-primary btn-sm"
                                                                                    title="Proceed to pay for your trip.">
                                                                                    <small><i
                                                                                            class="fa-solid fa-money-bill"></i></small>
                                                                                </a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endforeach
                                                @else
                                                    <p>No billed trips available.</p>
                                                @endif
                                            </div>
                                            <div id="page-axios-data" data-table-id="#driver-table">
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
