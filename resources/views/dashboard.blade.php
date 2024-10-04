@extends('layouts.app')

@section('title', 'Dashboard')
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
                            @include('components.dashboard.card-stats')

                            <div class="row mb-4">
                                <div class="col-xl-8 mb-4 mb-xl-0">
                                    <div class="card rounded-0">
                                        <div class="card-header card_header px-3">
                                            <div class="d-lg-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Maintenance Cost Report</h6>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="card-body px-2">
                                            {!! $maintenanceCostReport->container() !!}
                                            {!! $maintenanceCostReport->script() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="card rounded-0">
                                        <div class="card-header card_header px-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Expense Report</h6>
                                            </div>
                                        </div>
                                        <div class="card-body p-0 px-2">
                                            {!! $expensePieChart->container() !!}
                                            {!! $expensePieChart->script() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 2nd  -->
                            <div class="row mb-4">
                                <div class="col-xl-4 mb-4 mb-xl-0">
                                    <div class="card rounded-0 w-100">
                                        <div class="card-header card_header px-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="fs-16 fw-bold mb-0">Annual Trips Report
                                                </h6>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="card-body w-100 p-0 px-2">
                                            {!! $venDiagram->container() !!}
                                            {!! $venDiagram->script() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- new chart.js End -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fs-17 font-weight-600 mb-0">Reminder</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-borderless table-hover rounded-3 table-light">
                                            <thead>
                                                <tr>
                                                    <th class="py-3">Document Name</th>
                                                    <th class="py-3">Document Holder</th>
                                                    <th class="py-3">Current Status</th>
                                                    <th class="py-3">Issue Date</th>
                                                    <th class="py-3">Expiry Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($expiredInsurances as $insurance)
                                                    <tr>
                                                        <td>Vehicle Insurance</td>
                                                        <td>{{ $insurance->vehicle->plate_number }}</td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td>{{ $insurance->insurance_date_of_issue }}</td>
                                                        <td>{{ $insurance->insurance_date_of_expiry }}</td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($expiredInspectionCertificates as $certificate)
                                                    <tr>
                                                        <td>NTSA Inspection Certificate</td>
                                                        <td>{{ $certificate->vehicle->plate_number }}</td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td>{{ $certificate->ntsa_inspection_certificate_date_of_issue }}
                                                        </td>
                                                        <td>{{ $certificate->ntsa_inspection_certificate_date_of_expiry }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($expiredLicenses as $license)
                                                    <tr>
                                                        <td>Driver's License</td>
                                                        <td>{{ $license->driver->user->name }}</td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td>{{ $license->driving_license_date_of_issue }}</td>
                                                        <td>{{ $license->driving_license_date_of_expiry }}</td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($expiredPSVBadges as $badge)
                                                    <tr>
                                                        <td>Driver's PSV Badges</td>
                                                        <td>{{ $badge->driver->user->name }}</td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm rounded-0"><i
                                                                    class="fas fa-exclamation-triangle"></i>
                                                                Expired</button>
                                                        </td>
                                                        <td>{{ $badge->psv_badge_date_of_issue }}</td>
                                                        <td>{{ $badge->psv_badge_date_of_expiry }}</td>
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
