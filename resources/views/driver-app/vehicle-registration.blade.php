@extends('layouts.mobile-app')

@section('title', 'Vehicle Registration | Driver')
@section('content')
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    @php
        $user = Auth::user();
        $driver = $user->driver;

        \Log::debug('Driver Vehicle:', [
            'organisation_id' => $driver->vehicle->organisation_id ?? 'null',
            'manufacture_id' => $driver->vehicle->manufacturer_id ?? 'null',
            'fuel_type_id' => $driver->vehicle->fuel_type_id ?? 'null',
            'class_id' => $driver->vehicle->class ?? 'null',
        ]);

    @endphp

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="text-center header-icons-container">
                <a href="{{ route('driver.vehicle.docs.registration') }}">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                @if ($driver->status == 'inactive')
                    <span> Account Deactivated</span>
                @else
                    <span>Vehicle Registration/(Assigned)</span>
                @endif

                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title">
                    <span>Vehicle Registration</span>
                    
                    @if ($driver->vehicle->status == 'inactive')
                        <span class="badge badge-pill fs-6 badge-danger">Inactive</span>
                    @else
                        <span class="badge badge-pill fs-6 badge-success">Active</span>
                    @endif

                </div>

                @if (session('success'))
                    <div id="success-message" class="alert alert-success" style="display: none;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="error-message" class="alert alert-danger" style="display: none;">
                        {{ session('error') }}
                    </div>
                @endif

                <!--Driver's License Fields Container Start-->
                <div class="all-container all-container-with-classes">
                    <form class="width-100"
                        action="{{ $driver->vehicle ? route('driver.registration.vehicle.update', $driver->vehicle->id) : route('driver.registration.vehicle.store') }}"
                        method="POST" enctype="multipart/form-data">

                        @csrf
                        @if ($driver->vehicle)
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif

                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Vehicle Model</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="text" name="driver_vehicle_model"
                                    value="{{ old('driver_vehicle_model', $driver->vehicle->model ?? '') }}"
                                    placeholder="Toyota Auris" />
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Vehicle Plate No.</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="text" name="driver_vehicle_plate_number"
                                    value="{{ old('driver_vehicle_plate_number', $driver->vehicle->plate_number ?? '') }}"
                                    placeholder="KDR 999Z" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Vehicle Seats No.</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="number" name="driver_vehicle_seats_no"
                                    value="{{ old('driver_vehicle_seats_no', $driver->vehicle->seats ?? '') }}"
                                    placeholder="4" />
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="driver_vehicle_avatar" id="national-id-back-input" />
                                    </span>
                                    <span class="text-uppercase">Vehicle</span>
                                    <span class="delete-btn" id="national-id-back-delete">
                                        <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img id="national-id-back-preview"
                                                        src="{{ $driver->vehicle && $driver->vehicle->avatar ? asset($driver->vehicle->avatar) : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                        alt="Back"
                                                        onerror="this.onerror=null; this.src='{{ asset('mobile-app-assets/icons/photocamera.svg') }}';" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!--Input Field Container Start-->

                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Current Vehicle Organisation</span>
                                <span class="car-info-wrap display-block">


                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_organisation">
                                        @foreach ($organisations as $organisation)
                                            <option value="{{ $organisation->id }}"
                                                {{ old('driver_vehicle_organisation', $driver->vehicle->organisation_id ?? '') == $organisation->id ? 'selected' : '' }}>
                                                {{ $organisation->user->name }}
                                            </option>
                                        @endforeach
                                    </select>



                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Current Vehicle Class</span>
                                <span class="car-info-wrap display-block">


                                    <select class="custom-select font-weight-light car-info" name="driver_vehicle_class">
                                        @foreach ($vehicleClasses as $vehicleClass)
                                            <option value="{{ $vehicleClass->id }}"
                                                {{ old('driver_vehicle_class', $driver->vehicle->class ?? '') == $vehicleClass->name ? 'selected' : '' }}>
                                                {{ $vehicleClass->name }}({{ $vehicleClass->max_passengers }} seater)
                                            </option>
                                        @endforeach
                                    </select>


                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Fuel Type</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_fuel_type">
                                        @foreach ($vehicleFuelTypes as $fuelType)
                                            <option value="{{ $fuelType->id }}"
                                                {{ old('driver_vehicle_fuel_type', $driver->vehicle->fuel_type_id ?? '') == $fuelType->id ? 'selected' : '' }}>
                                                {{ $fuelType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Year of Manufacture


                                    <i>Current : </i>
                                    <span class="text-primary">{{ $driver->vehicle->year ?? null }}</span>

                                </label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="number" name="driver_vehicle_date_of_manufacture"
                                    value="{{ old('driver_vehicle_date_of_manufacture', $driver->vehicle->year ?? '') }}"
                                    placeholder="2022" min="1900" max="{{ date('Y') }}" />
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Manufacturer</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info"
                                        name="driver_vehicle_manufacturer">
                                        @foreach ($VehicleManufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->id }}"
                                                {{ old('driver_vehicle_manufacturer', $driver->vehicle->manufacturer_id ?? '') == $manufacturer->id ? 'selected' : '' }}>
                                                {{ $manufacturer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <label class="label-title">Engine Size</label>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class=""></span>
                                </div>
                                <input class="form-control" type="number" name="driver_vehicle_engine_size"
                                    value="{{ old('driver_vehicle_engine_size', $driver->vehicle->engine_size ?? '') }}"
                                    placeholder="2000cc" />
                            </div>
                        </div>

                        <div class="text-center form-submit-button">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                {{ $driver->vehicle ? 'Update' : 'Register Now' }}
                            </button>
                        </div>
                    </form>
                </div>
                <!--Driver's License Fields Container End-->
            </div>
        </div>


        <!--Terms And Conditions Agreement Container Start-->
        <div class="text-center col-xs-12 col-sm-12 sms-rate-text font-roboto flex-end margin-bottom-30">
            <div class="container-sms-rate-text width-100 font-11">
                <span class="light-gray font-weight-light">
                </span>
                <br />
                <a href="#" class="dark-link">
                    <span class="font-weight-light">Metroberry Tours & Travel</span>
                </a>
            </div>
        </div>
        <!--Terms And Conditions Agreement Container End-->

        <!--Main Menu Start-->
        @include('components.driver-mobile-app.main-menu')
        <!--Main Menu End-->
    </div>
@endsection
