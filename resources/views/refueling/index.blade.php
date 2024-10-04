@extends('layouts.app')

@section('title', 'Refueling List')
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
                                        <h6 class="fs-17 fw-semi-bold mb-0">Refueling List</h6>
                                        <div class="text-end">

                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#refuellingModal">
                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                Refuel Vehicle
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table" id="driver-table">
                                            <thead>
                                                <tr>
                                                    <th title="Vehicle">Vehicle</th>
                                                    <th title="Station">Station</th>
                                                    <th title="Volume">Volume</th>
                                                    <th title="Cost">Cost</th>
                                                    <th title="Status">Status</th>
                                                    <th title="Action" width="80">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($refuelings as $refueling)
                                                    <tr>
                                                        <td>{{ $refueling->vehicle->plate_number }}</td>
                                                        <td>{{ $refueling->refuellingStation->user->name }}</td>
                                                        <td>{{ $refueling->refuelling_volume }}</td>
                                                        <td>{{ $refueling->refuelling_cost }}</td>
                                                        <td class="text-center">
                                                            @if ($refueling->status == 'pending')
                                                                <span class="badge bg-secondary">Pending</span>
                                                            @elseif ($refueling->status == 'billed')
                                                                <span class="badge bg-success">Billed</span>
                                                            @elseif ($refueling->status == 'approved')
                                                                <span class="badge bg-info">Approved</span>
                                                            @elseif ($refueling->status == 'rejected')
                                                                <span class="badge bg-danger">Rejected</span>
                                                            @else
                                                                <span class="badge bg-warning">Invalid
                                                                    Status</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($refueling->status == 'pending' || $refueling->status == 'approved')
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('refueling.edit', $refueling->id) }}')"
                                                                    class="btn btn-info btn-sm" title="Edit">
                                                                    <i class="fa-solid fa-edit"></i>
                                                                </a>
                                                            @endif
                                                            @if ($refueling->status == 'billed' || $refueling->status == 'rejected')
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('refueling.redo-refuel', $refueling->id) }}')"
                                                                    class="btn btn-secondary btn-sm" title="Redo Refuel">
                                                                    <i class="fa-solid fa-rotate-right"></i>
                                                                </a>
                                                            @endif
                                                            @if ($refueling->status == 'pending')
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('refueling.approve', $refueling->id) }}')"
                                                                    class="btn btn-primary btn-sm" title="Approve">
                                                                    <i class="fa-solid fa-thumbs-up"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('refueling.reject', $refueling->id) }}')"
                                                                    class="btn btn-warning btn-sm" title="Reject">
                                                                    <i class="fa-solid fa-ban"></i>
                                                                </a>
                                                            @endif
                                                            @if ($refueling->status == 'approved')
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('refueling.bill', $refueling->id) }}')"
                                                                    class="btn btn-primary btn-sm" title="Bill">
                                                                    <i class="fa-solid fa-money-bill"></i>
                                                                </a>
                                                            @endif
                                                            @if ($refueling->status == 'pending' || $refueling->status == 'approved')
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('refueling.delete', $refueling->id) }}')"
                                                                    class="btn btn-danger btn-sm" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            @endif
                                                        </td>
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
                <div class="overlay"></div>
                @include('components.footer')
            </div>
        </div>
        <!-- end vue page -->
    </div>
    <!-- END layout-wrapper -->

    <div class="modal fade" id="refuellingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <form action="{{ route('refueling.create') }}" method="POST" class="needs-validation modal-content"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header my-3 p-2 border-bottom">
                    <h4>Refueling List</h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 col-lg-6">

                            <div class="form-group row my-2">
                                <label for="vehicle" class="col-sm-5 col-form-label">
                                    Vehicle
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="vehicle" class="form-control" id="vehicle" required>
                                        <option value="" disabled selected>Select a vehicle</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="date" class="col-sm-5 col-form-label">
                                    Date
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="date" class="form-control" type="date" id="date" required
                                        value=" {{ old('date') }}" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="volume" class="col-sm-5 col-form-label">
                                    Volume (L)
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="volume" class="form-control" type="number" id="volume" required
                                        value=" {{ old('volume') }}" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="attendant_name" class="col-sm-5 col-form-label">
                                    Attendant Name
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="attendant_name" class="form-control" type="text" id="attendant_name"
                                        required value=" {{ old('attendant_name') }}" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="creator_id" class="col-sm-5 col-form-label">
                                    Requested By
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <select name="creator_id" class="form-control" id="creator_id" readonly>
                                        <option value="{{ auth()->user()->name }}" selected>
                                            {{ auth()->user()->name }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 col-lg-6">

                            @if (Auth::user()->role == 'admin')
                                <div class="form-group row my-2">
                                    <label for="station" class="col-sm-5 col-form-label">
                                        Station
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="station" class="form-control" id="station" required>
                                            <option value="" disabled selected>Select a Fuel Station</option>
                                            @foreach ($stations as $station)
                                                <option value="{{ $station->id }}">{{ $station->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                @php
                                    $station = $stations->where('user_id', auth()->user()->id)->first();
                                @endphp
                                <div class="form-group row my-2">
                                    <label for="station" class="col-sm-5 col-form-label">
                                        Station
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="station"
                                            value="{{ $station->user->name }}" readonly>
                                        <input type="hidden" name="station" value="{{ $station->id }}">
                                    </div>
                                </div>

                            @endif

                            <div class="form-group row my-2">
                                <label for="time" class="col-sm-5 col-form-label">
                                    Time
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="time" class="form-control" type="time" id="time" required
                                        value=" {{ old('time') }}" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="cost" class="col-sm-5 col-form-label">
                                    Cost
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="cost" class="form-control" type="number" id="cost" required
                                        value=" {{ old('cost') }}" />
                                </div>
                            </div>

                            <div class="form-group row my-2">
                                <label for="attendant_phone" class="col-sm-5 col-form-label">
                                    Attendant Phone
                                    <i class="text-danger">*</i>
                                </label>
                                <div class="col-sm-7">
                                    <input name="attendant_phone" class="form-control" type="text"
                                        id="attendant_phone" required value=" {{ old('attendant_phone') }}" />
                                </div>
                            </div>

                        </div>
                        <div>
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
@endsection
