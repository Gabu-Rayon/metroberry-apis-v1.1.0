@extends('layouts.app')

@section('title', 'Checkout To A Trip')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Trip Route : {{ $trip->route->name }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="actions">
                                                <div class="accordion-header d-flex justify-content-end align-items-center"
                                                    id="flush-headingOne">
                                                    @if (\Auth::user()->can('send trip invoice'))
                                                        <a href="{{ route('billed.trip.send.invoice', ['id' => $trip->id]) }}"
                                                            class="btn btn-success btn-sm" title="Send Invoice.">
                                                            <i class="fas fa-arrow-right"></i> &nbsp;
                                                            Send Trip Invoice
                                                        </a>
                                                    @endif

                                                    <span class="m-1"></span>
                                                    @if (\Auth::user()->can('resend trip invoice'))
                                                        <a href="{{ route('billed.trip.resend.invoice', ['id' => $trip->id]) }}"
                                                            class="btn btn-success btn-sm" title="Resend Invoice.">
                                                            <i class="fas fa-share-square"></i> &nbsp;
                                                            Resend Trip Invoice
                                                        </a>
                                                    @endif

                                                    <span class="m-1"></span>
                                                    @if (in_array($trip->status, ['billed', 'partially paid']))
                                                        @if (Auth::user()->role == 'organisation')
                                                            <a class="btn btn-primary btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('{{ route('billed.trip.recieve.payment', ['id' => $trip->id]) }}')">
                                                                <i class="fa-solid fa-plus"></i> &nbsp;
                                                                Pay My Trip
                                                            </a>
                                                        @elseif (Auth::user()->role == 'admin')
                                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('{{ route('billed.trip.recieve.payment', ['id' => $trip->id]) }}')">
                                                                <i class="fa-solid fa-plus"></i> &nbsp;
                                                                Receive Trip Payment
                                                            </a>
                                                        @endif
                                                    @endif
                                                    <span class="m-1"></span>
                                                    @if (in_array($trip->status, ['billed', 'partially paid', 'paid']))
                                                        @if (\Auth::user()->can('download trip invoice'))
                                                            <a href="{{ route('trip.download.invoice', ['id' => $trip->id]) }}"
                                                                class="btn btn-primary btn-sm" title="Download.">
                                                                <small><i class="fa-solid fa-download"></i> &nbsp;</small>

                                                            </a>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-6">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Customer :</p>
                                                <div class="form-group row my-2">
                                                    <label for="plate_number" class="col-sm-5 col-form-label"> Name <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->customer->user->name }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="fuel_type" class="col-sm-5 col-form-label">Address
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->customer->user->address }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="engine_size" class="col-sm-5 col-form-label">org Code
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->customer->customer_organisation_code }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Vehicle :</p>
                                                <div class="form-group row my-2">
                                                    <label for="plate_number" class="col-sm-5 col-form-label"> Plate No <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->vehicle->plate_number }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="plate_number" class="col-sm-5 col-form-label"> Model <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->vehicle->model }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="fuel_type" class="col-sm-5 col-form-label">Driver
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->vehicle->driver->user->name }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="engine_size" class="col-sm-5 col-form-label">Driver
                                                        Contact
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->vehicle->driver->user->phone }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="engine_size" class="col-sm-5 col-form-label">Vehicle Org
                                                        <i class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->vehicle->organisation->user->name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Customer Org :</p>
                                                <div class="form-group row my-2">
                                                    <label for="color" class="col-sm-5 col-form-label">Org name <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->customer->organisation->user->name }}
                                                    </div>
                                                </div>
                                                <div class="form-group row my-2">
                                                    <label for="color" class="col-sm-5 col-form-label">Org Address <i
                                                            class="text-danger">:</i></label>
                                                    <div class="col-sm-7">
                                                        {{ $trip->customer->organisation->user->address }}
                                                    </div>
                                                </div>
                                                <p class="mb-0 mr-3 text-dark fw-bold">Status :</p>
                                                @if ($trip->status == 'billed')
                                                    <span class="badge bg-success">Billed</span>
                                                @elseif ($trip->status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-danger">Partially Paid</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12">
                                            <table class="table" id="checkout-table">
                                                <thead>
                                                    <tr>
                                                        <th title="SrNo" width="30">SrNo</th>
                                                        <th title="Trip Route">Trip Route</th>
                                                        <th title="Billed By">Billed By</th>
                                                        <th title="Charges or Trip price ">Charges :</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $item = 1 @endphp
                                                    <tr>
                                                        <td>{{ $item++ }}</td>
                                                        <td> {{ $trip->route->name }}</td>
                                                        <td> {{ $trip->billed_by }}</td>
                                                        <td>Kes. {{ $trip->total_price }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right my-20"><strong>Total</strong>
                                                        </td>
                                                        <td><strong>Kes.{{ $trip->total_price }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right my-20">
                                                            <strong>Balance</strong>
                                                        </td>
                                                        <td><strong>Kes.{{ $remainingAmount }}</strong></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12 col-lg-12">
                                            <div class="d-flex align-items-center mb-3">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Pay with IntaSend</p>
                                                <span></span>
                                                <img src="{{ asset('admin-assets/img/payment-img/intasend-icon-20x27.png') }}"
                                                    alt="IntaSend Logo" class="img-fluid">
                                            </div>
                                            <div class="bg-secondary bg-gradient border rounded p-3">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('admin-assets/img/payment-img/IntasendPaymentGateways.png') }}"
                                                        alt="IntaSend payments Gateways" class="mr-3">
                                                </div>
                                                <p class="mb-0 mt-6 text-white fw-bold text-left">Secure mobile and card
                                                    payments.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Receipt Summary</h6>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12 col-lg-12">
                                            <table class="table" id="checkout-table">
                                                <thead>
                                                    <tr>
                                                        <th title="PAYMENT RECEIPT" width="30">Payment Receipt</th>
                                                        <th title="Date">Date</th>
                                                        <th title="Date">Amount</th>
                                                        <th title="Payment Type">Payment Type</th>
                                                        <th title="Account">Account</th>
                                                        <th title="Reference">Reference</th>
                                                        <th title="description">Description</th>
                                                        <th title="Receipt ">Receipt</th>
                                                        <th title="ORDERID">OrderID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($ThisTripPayments as $payment)
                                                        <tr>
                                                            <td> <a href="{{ route('billed.trip.download.invoice.receipt', ['id' => $payment->id]) }}"
                                                                    class="btn btn-primary btn-sm"> <i
                                                                        class="fa-solid fa-download"></i> &nbsp;</a></td>
                                                            <td>{{ $payment->payment_date }}</td>
                                                            <td>Kes.{{ $payment->total_amount }}</td>
                                                            <td>{{ $payment->payment_type_code }}</td>
                                                            <td>{{ $payment->account->holder_name }}</td>
                                                            <td>{{ $payment->reference }}</td>
                                                            <td>{{ $payment->remark }}</td>
                                                            <td>
                                                                <a href="{{ asset('payment_receipts/' . $payment->payment_receipt) }}"
                                                                    download>
                                                                    <i class="fa-solid fa-file-pdf"></i> Receipt
                                                                </a>
                                                            </td>
                                                            </td>
                                                            <td>{{ $payment->invoice_no }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
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
        @endsection
