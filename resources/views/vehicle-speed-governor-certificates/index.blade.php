@extends('layouts.app')

@section('title', 'Speed Governor Certificates')
@section('content')

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
                                        <h6 class="fs-17 fw-semi-bold mb-0">Speed Governor Certificates</h6>
                                        <div class="text-end">
                                            @if (Auth::user()->can('export vehicle speed governors'))
                                                <a class="btn btn-success btn-sm" href="{{ route('vehicle.speed.governor.export') }}"
                                                    title="Export">
                                                    <i class="fa-solid fa-file-export"></i>
                                                    &nbsp;
                                                    Export
                                                </a>
                                            @endif
                                            <span class='m-1'></span>
                                            @if (Auth::user()->can('import vehicles'))
                                                <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('{{ route('vehicle.speed.governor.import') }}')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                            @endif
                                            <span class='m-1'></span>
                                            @if (Auth::user()->can('create vehicle'))
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#certificateModal">
                                                    <i class="fa-solid fa-user-plus"></i>&nbsp; Add Speed Governor Certificate
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
                                                    <th>Vehicle</th>
                                                    <th>Certificate No</th>
                                                    <th>Type</th>
                                                    <th>Installation Date</th>
                                                    <th>Expiry Date</th>
                                                    @if (Auth::user()->role == 'admin')
                                                        <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($speed_governors as $speed_governor)
                                                    <tr>
                                                        <td class="text-center">{{ $speed_governor->vehicle->model }} {{ $speed_governor->vehicle->make }}, {{ $speed_governor->vehicle->plate_number }}</td>
                                                        <td>{{ $speed_governor->certificate_no }}</td>
                                                        <td>{{ $speed_governor->type_of_governor }}</td>
                                                        <td>{{ $speed_governor->date_of_installation }}</td>
                                                        <td>{{ $speed_governor->expiry_date }}</td>
                                                        @if (Auth::user()->role == 'admin')
                                                            <td class="text-center">
                                                                @if (\Auth::user()->can('edit vehicle speed governor'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('speed-governor/{{ $speed_governor->id }}/edit')"
                                                                        title="Edit Certificate">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if ($speed_governor->status == 'active')
                                                                    @if (\Auth::user()->can('deactivate vehicle speed governor'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('speed-governor/{{ $speed_governor->id }}/deactivate')"
                                                                            title="Deactivate Certificate">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if (\Auth::user()->can('activate vehicle speed governor'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('speed-governor/{{ $speed_governor->id }}/activate')"
                                                                            title="Activate Certificate">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (\Auth::user()->can('delete vehicle speed governor'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('speed-governor/{{ $speed_governor->id }}/delete')"
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

    <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('vehicle.speed.governor.create') }}" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Add New Certificate</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="vehicle_id" class="col-sm-5 col-form-label">Select Vehicle</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="vehicle_id"
                                        id="vehicle_id" tabindex="-1" aria-hidden="true">
                                        <option value="">Please Select Vehicle</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->make }}, {{ $vehicle->model }}, {{ $vehicle->plate_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="class_no" class="col-sm-5 col-form-label">Class</label>
                                <div class="col-sm-7">
                                    <select class="form-control basic-single select2" name="class_no"
                                        id="class_no" tabindex="-1" aria-hidden="true">
                                        <option value="">Select Class</option>
                                        <option value="A" {{ old('class_no') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('class_no') == 'B' ? 'selected' : '' }}>B</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row my-2">
                                <label for="installation_date" class="col-sm-5 col-form-label">
                                    Installation Date
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="installation_date" class="form-control" type="date"
                                        placeholder="Installation Date" id="installation_date" value="{{ old('installation_date') }}">
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="copy" class="col-sm-5 col-form-label">
                                    Copy
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="copy" class="form-control" type="file" id="copy" value="{{ old('copy') }}" required>
                                </div>
                            </div>                            
                        </div>

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="certificate_no" class="col-sm-5 col-form-label">
                                    Certificate No
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="certificate_no" class="form-control" type="text" placeholder="Enter Certificate No" id="certificate_no" value="{{ old('certificate_no') }}" required>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="type" class="col-sm-5 col-form-label">
                                    Type
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="type" class="form-control" type="text" placeholder="Enter Type" id="type" value="{{ old('type') }}" required>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="expiry_date" class="col-sm-5 col-form-label">
                                    Expiry Date
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="expiry_date" class="form-control" type="date"
                                        placeholder="Expiry Date" id="expiry_date" value="{{ old('expiry_date') }}">
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="chasis_no" class="col-sm-5 col-form-label">
                                    Chasis No
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="chasis_no" class="form-control" type="text" placeholder="Enter Chasis No" id="chasis_no" value="{{ old('chasis_no') }}" required>
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
