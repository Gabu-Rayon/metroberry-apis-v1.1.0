@extends('layouts.app')

@section('title', 'Vehicles')
@section('content')

    <!-- No need for the body tag here; it's handled by the layout -->
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
                                        <h6 class="fs-17 fw-semi-bold mb-0">Vehicles</h6>
                                        <div class="text-end">
                                            @if (Auth::user()->can('export vehicles'))
                                                <a class="btn btn-success btn-sm" href="{{ route('vehicle.export') }}"
                                                    title="Export">
                                                    <i class="fa-solid fa-file-export"></i>
                                                    &nbsp;
                                                    Export
                                                </a>
                                            @endif
                                            <span class='m-1'></span>
                                            @if (Auth::user()->can('import vehicles'))
                                                <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('{{ route('vehicle.import') }}')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                            @endif
                                            <span class='m-1'></span>
                                            @if (Auth::user()->can('create vehicle'))
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#vehicleModal">
                                                    <i class="fa-solid fa-user-plus"></i>&nbsp; Add Vehicle
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="driver-table">
                                            <thead>
                                                <tr>
                                                    <th>Driver</th>
                                                    <th>Make</th>
                                                    <th>Model</th>
                                                    <th>Plate Number</th>
                                                    <th>Seats</th>
                                                    <th>Fuel Type</th>
                                                    <th>Engine Size (CC)</th>
                                                    <th>Status</th>
                                                    @if (Auth::user()->role == 'admin')
                                                        <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vehicles as $vehicle)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if ($vehicle->driver && $vehicle->driver->user)
                                                                {{ $vehicle->driver->user->name }}
                                                            @else
                                                                @if (\Auth::user()->can('assign vehicle'))
                                                                    @if ($vehicle->status == 'active')
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-primary"
                                                                            onclick="axiosModal('/vehicle/{{ $vehicle->id }}/assign/driver')">
                                                                            Assign Driver
                                                                        </a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $vehicle->make }}</td>
                                                        <td>{{ $vehicle->model }}</td>
                                                        <td>{{ $vehicle->plate_number }}</td>
                                                        <td>{{ $vehicle->seats }}</td>
                                                        <td>{{ $vehicle->fuel_type }}</td>
                                                        <td>{{ $vehicle->engine_size }}<i>CC</i></td>
                                                        <td>
                                                            @if ($vehicle->status == 'active')
                                                                <span class="badge bg-success">Active</span>
                                                            @else
                                                                <span class="badge bg-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                        @if (Auth::user()->role == 'admin')
                                                            <td class="text-center">
                                                                @if (\Auth::user()->can('edit vehicle'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('/vehicle/{{ $vehicle->id }}/edit')"
                                                                        title="Edit Vehicle">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if ($vehicle->status == 'active')
                                                                    @if (\Auth::user()->can('deactivate vehicle'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('/vehicle/{{ $vehicle->id }}/deactivate')"
                                                                            title="Deactivate Vehicle">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if (\Auth::user()->can('activate vehicle'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('/vehicle/{{ $vehicle->id }}/activate')"
                                                                            title="Activate Vehicle">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (\Auth::user()->can('delete vehicle'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('/vehicle/{{ $vehicle->id }}/delete')"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
        <!-- end vue page -->
    </div>
    <!-- END layout-wrapper -->

    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="/vehicle/store" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Add New Vehicle</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="model" class="col-sm-5 col-form-label">Vehicle Model <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="model" class="form-control" type="text" placeholder="Vehicle Model"
                                        id="model" value="{{ old('model') }}" required>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="make" class="col-sm-5 col-form-label">Vehicle Make <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="make" autocomplete="off" required class="form-control" type="text"
                                        placeholder="Vehicle Make" id="make" value="{{ old('make') }}">
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="year" class="col-sm-5 col-form-label">Vehicle Year of Manufacturer <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="year" class="form-control" type="date"
                                        placeholder="Year of Manufacturer" id="year" value="{{ old('year') }}">
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="vehicle_class" class="col-sm-5 col-form-label">Select Vehicle Class</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="vehicle_class"
                                        id="vehicle_class" tabindex="-1" aria-hidden="true">
                                        <option value="">Please Select Vehicle Class</option>
                                        @foreach ($vehicleClasses as $class)
                                            <option value="{{ $class->name }}">Class {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="plate_number" class="col-sm-5 col-form-label">Vehicle Number Plate <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="plate_number" class="form-control" type="text"
                                        placeholder="Enter Number Plate" id="plate_number"
                                        value="{{ old('plate_number') }}" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="vehicle_avatar" class="col-sm-5 col-form-label">Vehicle Avatar <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="vehicle_avatar" class="form-control" type="file" id="vehicle_avatar"
                                        value="{{ old('vehicle_avatar') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="fuel_type" class="form-control" type="text"
                                        placeholder="Enter Vehicle Fuel Type" id="fuel_type"
                                        value="{{ old('fuel_type') }}" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="engine_size" class="col-sm-5 col-form-label">Engine Size <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="engine_size" class="form-control" type="number"
                                        placeholder="Enter Engine Size" id="engine_size"
                                        value="{{ old('engine_size') }}" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="color" class="col-sm-5 col-form-label">Vehicle Color <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="color" class="form-control" type="text"
                                        placeholder="Enter Vehicle Color" id="color" value="{{ old('color') }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="seats" class="col-sm-5 col-form-label">No of Seats <i
                                        class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input name="seats" class="form-control" type="number" placeholder="No of Seats"
                                        id="seats" value="{{ old('seats') }}" required>
                                </div>
                            </div>
                            <div class="form-group row my-2">
                                <label for="organisation_id" class="col-sm-5 col-form-label">Select Vehicle Org</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="organisation_id"
                                        id="organisation_id" tabindex="-1" aria-hidden="true">
                                        <option value="">Please Select Vehicle Organisation</option>
                                        @foreach ($organisations as $organisation)
                                            <option value="{{ $organisation->id }}">
                                                {{ $organisation->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
