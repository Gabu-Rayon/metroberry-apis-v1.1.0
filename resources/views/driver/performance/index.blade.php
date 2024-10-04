@extends('layouts.app')

@section('title', 'Driver Performance')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Driver Performance</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Driver name">Driver</th>
                                                            <th title="Over time status">Total Number of Trips</th>
                                                            <th title="Salary status">Cancelled Trips</th>
                                                            <th title="Overtime payment">Billed Trips</th>
                                                            <th title="Action" width="80">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($drivers as $driver)
                                                            <tr>
                                                                <td class="text-center">{{ $driver->user->name }}</td>
                                                                <td class="text-center">
                                                                    {{ $driver->vehicle ? count($driver->vehicle->trips) : '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $driver->vehicle ? count($driver->vehicle->trips->where('status', 'cancelled')) : '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $driver->vehicle ? count($driver->vehicle->trips->where('status', 'billed')) : '-' }}
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="" class="btn btn-primary btn-sm">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
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
