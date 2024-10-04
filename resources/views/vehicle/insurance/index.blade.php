@extends('layouts.app')

@section('title', 'Vehicles Insurances')
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
                                            <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Insurances</h6>
                                            <div class="text-end">
                                                <div class="actions">
                                                    @if (Auth::user()->can('export vehicle insurances'))
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('vehicle.insurance.export') }}" title="Export">
                                                            <i class="fa-solid fa-file-export"></i>
                                                            &nbsp;Export
                                                        </a>
                                                    @endif
                                                    <span class="m-1"></span>
                                                    @if (Auth::user()->can('import vehicle insurances'))
                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('vehicle.insurance.import') }}" title="Import">
                                                            <i class="fa-solid fa-file-import"></i>
                                                            &nbsp;Import
                                                        </a>
                                                    @endif
                                                    <span class="m-1"></span>
                                                    @if (Auth::user()->can('create vehicle insurance'))
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#vehicleInsuranceModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp; Add Vehicle
                                                            Insurance
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @include ('components.vehicles.insurances.table')
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

        <div class="modal fade" id="vehicleInsuranceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('vehicle.insurance.store') }}" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Vehicle Insurance Details</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="insurance_company_id" class="col-sm-5 col-form-label">Company <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="insurance_company_id"
                                            id="insurance_company_id" required>
                                            <option value="">Select Company</option>
                                            @foreach ($insuranceCompanies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="insurance_policy_no" class="col-sm-5 col-form-label">Policy Number <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="insurance_policy_no" class="form-control" type="text"
                                            placeholder="Policy number" id="insurance_policy_no"
                                            value="{{ old('insurance_policy_no') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="insurance_date_of_issue" class="col-sm-5 col-form-label">Start Date</label>
                                    <div class="col-sm-7">
                                        <input name="insurance_date_of_issue" class="form-control" type="date"
                                            id="insurance_date_of_issue" value="{{ old('insurance_date_of_issue') }}">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="recurring_period_id" class="col-sm-5 col-form-label">Recurring Period <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="recurring_period_id"
                                            id="recurring_period_id" required>
                                            <option value="">Select Recurring Period</option>
                                            @foreach ($recurringPeriods as $period)
                                                <option value="{{ $period->id }}">{{ $period->period }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="reminder" class="col-sm-5 col-form-label">Add Reminder</label>
                                    <div class="col-sm-7">
                                        <select name="reminder" id="reminder" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="status" class="col-sm-5 col-form-label">Status</label>
                                    <div class="col-sm-7">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="remarks" class="col-sm-5 col-form-label">Remarks</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="remark" id="remarks" cols="30" rows="3">{{ old('remark') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row mb-1">
                                    <label for="vehicle_id" class="col-sm-5 col-form-label">Vehicle <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="vehicle_id" id="vehicle_id"
                                            required>
                                            <option value="">Select Vehicle</option>
                                            @foreach ($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">{{ $vehicle->model }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="charges_payable" class="col-sm-5 col-form-label">Charge Payable <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="charges_payable" class="form-control" type="number" step="any"
                                            placeholder="Charge payable" id="charges_payable"
                                            value="{{ old('charges_payable') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="insurance_date_of_expiry" class="col-sm-5 col-form-label">End Date</label>
                                    <div class="col-sm-7">
                                        <input name="insurance_date_of_expiry" class="form-control" type="date"
                                            id="insurance_date_of_expiry" value="{{ old('insurance_date_of_expiry') }}">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="recurring_date" class="col-sm-5 col-form-label">Recurring Date</label>
                                    <div class="col-sm-7">
                                        <input name="recurring_date" class="form-control" type="date"
                                            id="recurring_date" value="{{ old('recurring_date') }}">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="deductible" class="col-sm-5 col-form-label">Deductible <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="deductible" class="form-control" type="number" step="any"
                                            placeholder="Deductible" id="deductible" value="{{ old('deductible') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="policy_document" class="col-sm-5 col-form-label">Policy Document <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input type="file" name="policy_document" id="policy_document" required
                                            onchange="get_img_url(this, '#document_image');">
                                        <img id="document_image" src="" width="120px" class="mt-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
@endsection
