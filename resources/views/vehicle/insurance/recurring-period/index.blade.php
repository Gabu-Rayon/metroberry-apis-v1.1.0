@extends('layouts.app')

@section('title', 'Insurances Recurring Periods')

@section('content')
    <div class="fixed sidebar-mini">
        @include('components.preloader')

        <!-- React page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- Start sidebar -->
                @include('components.sidebar.sidebar')
                <!-- End sidebar -->

                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Insurance Recurring Period Lists
                                                </h6>
                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#recurringPeriodModal">
                                                    <i class="fa-solid fa-user-plus"></i>&nbsp; Add Recurring Period
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Period">Period</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Description">Description</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recurringPeriods as $period)
                                                        <tr>
                                                            <td>{{ $period->period }}</td>
                                                            <td>
                                                                @if ($period->status)
                                                                    <i class="fas fa-check-circle text-success"
                                                                        title="Active"></i>
                                                                @else
                                                                    <i class="fas fa-times-circle text-danger"
                                                                        title="Inactive"></i>
                                                                @endif
                                                            </td>
                                                            <td>{{ $period->description }}</td>
                                                            <td class="d-flex">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                                                    onclick="axiosModal('/vehicle/insurance/recurring-period/{{ $period->id }}/edit')">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <span class='m-1'></span>
                                                                @can('delete insurance company')
                                                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                                        onclick="deleteVehicle({{ $period->id }})">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                @endcan
                                                            </td>
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

                    <div class="modal fade" id="recurringPeriodModal" tabindex="-1"
                        aria-labelledby="recurringPeriodModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('vehicle.insurance.recurring.period.create.store') }}" method="POST"
                                class="needs-validation modal-content" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header my-3 p-2 border-bottom">
                                    <h4>Add Recurring Period</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">
                                            <div class="form-group row my-2">
                                                <label for="period" class="col-sm-5 col-form-label">Period <i
                                                        class="text-danger">*</i></label>
                                                <div class="col-sm-7">
                                                    <input name="period" class="form-control" type="text"
                                                        placeholder="Period" id="period" value="{{ old('period') }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="form-group row my-2">
                                                <label for="description" class="col-sm-5 col-form-label">Description</label>
                                                <div class="col-sm-7">
                                                    <textarea name="description" class="form-control" placeholder="Description" id="description">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-lg-6">
                                            <div class="form-group row my-2">
                                                <label for="status" class="col-sm-5 col-form-label">Status</label>
                                                <div class="col-sm-7">
                                                    <select name="status" class="form-control" id="status" required>
                                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                                            Inactive</option>
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
                </div>
            </div>
        </div>
    </div>
@endsection
