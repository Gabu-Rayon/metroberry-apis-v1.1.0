@extends('layouts.app')

@section('title', 'Checkout Vehicle Service')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Service Payment</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="actions">
                                                <p class="mb-0 mr-3 text-dark fw-bold">Status :</p>
                                                @if ($service->service_status == 'billed')
                                                    <span class="badge bg-success">Billed</span>
                                                @elseif ($service->service_status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-danger">Partially Paid</span>
                                                @endif
                                                <div class="accordion-header d-flex justify-content-end align-items-center"
                                                    id="flush-headingOne">
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                        onclick="axiosModal('{{ route('billed.vehicle.service.send.invoice', ['id' => $service->id]) }}')">
                                                        <i class="fa-solid fa-arrow-right"></i> &nbsp;
                                                        Send Vehicle Service Invoice
                                                    </a>

                                                    <span class="m-1"></span>
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                        onclick="axiosModal('{{ route('billed.vehicle.service.resend.invoice', ['id' => $service->id]) }}')">
                                                        <i class="fas fa-share-square"></i> &nbsp;
                                                        Resend Vehicle Service Invoice
                                                    </a>

                                                    <span class="m-1"></span>
                                                    <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                        onclick="axiosModal('{{ route('billed.vehicle.service.download.invoice', ['id' => $service->id]) }}')">
                                                        <i class="fa-solid fa-download"></i> &nbsp;
                                                        Download Vehicle Service Invoice
                                                    </a>

                                                    <span class="m-1"></span>
                                                    @if (in_array($service->service_status, ['billed', 'partially paid']))
                                                        <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                            onclick="axiosModal('{{ route('billed.vehicle.service.receive.payment', ['id' => $service->id]) }}')">
                                                            <i class="fa-solid fa-plus"></i> &nbsp;
                                                            Receive Vehicle Service Payment
                                                        </a>
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
                                        <div class="col-md-12 col-lg-12">
                                            <table class="table" id="checkout-table">
                                                <thead>
                                                    <tr>
                                                        <th title="SrNo" width="30">SrNo</th>
                                                        <th title="Trip Route">Vehicle</th>
                                                        <th title="Billed By">Service Type</th>
                                                        <th title="Charges or Trip price ">Date </th>
                                                        <th title="Charges or Trip price ">Description </th>
                                                        <th title="Billed By"> Vehicle Plate</th>
                                                        <th title="Charges or Trip price ">Service Category </th>
                                                        <th title="Charges or Trip price ">Cost </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $item = 1 @endphp
                                                    <tr>
                                                        <td>{{ $item++ }}</td>
                                                        <td> {{ $service->vehicle->plate_number ?? null }}</td>
                                                        <td> {{ $service->serviceType->name }} </td>
                                                        <td>{{ $service->service_date }}</td>
                                                        <td> {{ $service->service_description }}</td>
                                                        <td> {{ $service->vehicle->plate_number ?? null  }}</td>
                                                        <td>{{ $service->serviceCategory->name }}</td>
                                                        <td>Kes. {{ $service->service_cost }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-right my-20"><strong>Total</strong>
                                                        </td>
                                                        <td><strong>Kes.{{ $service->service_cost }}</strong></td>
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
                                                    @foreach ($ThisMaintenanceServicePayment as $payment)
                                                        <tr>
                                                            <td> <a href="{{ route('billed.vehicle.service.download.invoice', ['id' => $payment->id]) }}"
                                                                    class="btn btn-primary btn-sm"> <i
                                                                        class="fa-solid fa-download"></i> &nbsp;</a></td>
                                                            <td>{{ $payment->payment_date }}</td>
                                                            <td>Kes.{{ $payment->total_amount }}</td>
                                                            <td>{{ $payment->payment_type_code }}</td>
                                                            <td>{{ $payment->account->holder_name }}</td>
                                                            <td>{{ $payment->reference }}</td>
                                                            <td>{{ $payment->remark }}</td>
                                                            <td>
                                                                <a href="{{ asset($payment->payment_receipt) }}"
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
