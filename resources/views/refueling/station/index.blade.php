@extends('layouts.app')

@section('title', 'Fuel Stations')
@section('content')

    <head>
        <style>
            .generate-btn-container {
                position: absolute;
                top: 0;
                right: 0;
                transform: translateY(-50%);
                cursor: pointer;
            }

            .generate-btn {
                padding: 5px 10px;
                font-size: 0.8em;
            }
        </style>
    </head>

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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Fuel Stations</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#refuellingStationModal">
                                                        <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                        Add Refueling Station
                                                    </button>
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
                                                            <th title="Name">Name</th>
                                                            <th title="Email">Email</th>
                                                            <th title="Phone">Phone</th>
                                                            <th title="Address">Address</th>
                                                            <th title="Status">Status</th>
                                                            <th title="Action" width="80">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($stations as $station)
                                                            <tr>
                                                                <td>{{ $station->user->name }}</td>
                                                                <td>{{ $station->user->email }}</td>
                                                                <td>{{ $station->user->phone }}</td>
                                                                <td>{{ $station->user->address }}</td>
                                                                <td class="text-center">
                                                                    @php
                                                                        $certificateOfOperations =
                                                                            $station->certificate_of_operations;

                                                                        if ($station->status == 'inactive') {
                                                                            if (!$certificateOfOperations) {
                                                                                $badgeClass = 'badge bg-danger';
                                                                                $badgeText = 'Missing Documents';
                                                                            } else {
                                                                                $badgeClass =
                                                                                    'badge bg-warning text-dark';
                                                                                $badgeText = 'Pending Verification';
                                                                            }
                                                                        } else {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Active';
                                                                        }
                                                                    @endphp
                                                                    <span
                                                                        class="{{ $badgeClass }}">{{ $badgeText }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('{{ route('refueling.station.edit', $station->id) }}')"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fa fa-edit fa-sm"></i>
                                                                    </a>
                                                                    @if ($station->status == 'active')
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('{{ route('refueling.station.deactivate', $station->id) }}')"
                                                                            title="Deactivate Station">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @else
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('{{ route('refueling.station.activate', $station->id) }}')"
                                                                            title="Activate Station">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                    <a href="javascript:void(0);"
                                                                        onclick="axiosModal('{{ route('refueling.station.delete', $station->id) }}')"
                                                                        class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash fa-sm"></i>
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

        <div class="modal fade" id="refuellingStationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <form action="{{ route('refueling.station.create') }}" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Fuelling Station</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="name" class="col-sm-5 col-form-label">
                                        Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="station_code" class="col-sm-5 col-form-label">
                                        Station Code
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="station_code" class="form-control" type="text"
                                            placeholder="Station Code" id="station_code" required
                                            value="{{ old('station_code') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="phone" class="col-sm-5 col-form-label">
                                        Phone
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="phone" class="form-control" type="text" placeholder="Phone"
                                            id="phone" required value="{{ old('phone') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="avatar" class="col-sm-5 col-form-label">
                                        Logo
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="avatar" class="form-control" type="file" placeholder="Avatar"
                                            id="avatar" value="{{ old('avatar') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="payment_period" class="col-sm-5 col-form-label">
                                        Payment Period
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="payment_period" class="form-control" id="payment_period" required>
                                            <option value="">Select Payment Period</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="biannually">Bi-Annually</option>
                                            <option value="annually">Annually</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="email" class="col-sm-5 col-form-label">
                                        Email
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="email" class="form-control" type="email" placeholder="Email"
                                            id="email" required value="{{ old('email') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="address" class="col-sm-5 col-form-label">
                                        Address
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            id="address" required value="{{ old('address') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="password" class="col-sm-5 col-form-label">
                                        Password
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7 position-relative">
                                        <input name="password" class="form-control" type="password"
                                            placeholder="Password" id="password" readonly required />
                                        <div class="generate-btn-container">
                                            <span class="input-group-text generate-btn" onclick="generatePassword()"
                                                style="font-size: smaller;">Generate</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="certificate_of_operations" class="col-sm-5 col-form-label">
                                        Certificate of Operations
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="certificate_of_operations" class="form-control" type="file"
                                            placeholder="Certificate of Operations" id="certificate_of_operations"
                                            required value="{{ old('certificate_of_operations') }}" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button class="btn btn-success" type="submit">Save</button>
                        </div>
                </form>
            </div>
        </div>

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
                                <p>Are you sure you want to delete this item? you won t be able to revert this item
                                    back!
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
        <!-- start scripts -->

        <script>
            function generatePassword() {
                var length = 12,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=",
                    password = "";
                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }
                document.getElementById("password").value = password;
            }
        </script>
    @endsection
