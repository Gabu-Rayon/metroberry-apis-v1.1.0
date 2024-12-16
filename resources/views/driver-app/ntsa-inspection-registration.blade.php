@extends('layouts.mobile-app')

@section('title', 'Speed Governor | Driver')
@section('content')
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>

    @php
        $driver = Auth::user()->driver;
    @endphp

    <div class="row h-100">
        @php
            $user = Auth::user();
            $driver = $user->driver;
            $isUpdate = isset($driver->speedGovernorCertificate);
            $route = $isUpdate
                ? route('driver.registration.speed.governor.update', $driver->speedGovernorCertificate->id)
                : route('driver.registration.speed.governor.store');
            $method = $isUpdate ? 'PUT' : 'POST';
        @endphp
        <div class="col-xs-12 col-sm-12">
            <!-- Page Title & Icons Start -->
            <div class="text-center header-icons-container">
                <a href="{{ route('driver.vehicle.docs.registration') }}">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                @if ($driver->status == 'inactive')
                    <span>Deactivated</span>
                @else
                    <span>Speed Governor</span>
                @endif
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!-- Page Title & Icons End -->

            <div class="rest-container">
                <div class="address-title">Speed Governor Registration</div>
                @if (session('success'))
                    <div id="success-message" class="alert alert-success" style="display: block;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="error-message" class="alert alert-danger" style="display: block;">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="all-container all-container-with-classes">
                    <form class="width-100"
                        action="{{ $route }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($isUpdate)
                            @method('PUT')
                        @else
                            @method('POST')
                        @endif

                        <!-- Certificate Number -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Certificate No</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driver_ntsa_inspection_certificate_no" autocomplete="on"
                                    placeholder="Driver NTSA Inspection Certificate No"
                                    value="{{ old('driver_ntsa_inspection_certificate_no', $driver->inspectionCertificate->ntsa_inspection_certificate_no ?? '') }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Certificate Copy -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="driver_ntsa_certificate_copy" id="certificate-copy-input" />
                                    </span>
                                    <span class="text-uppercase">NTSA Certificate Copy</span>
                                    <span class="delete-btn" id="certificate-copy-delete">
                                        <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img id="certificate-copy-preview"
                                                        src="{{ $driver->inspectionCertificate->ntsa_inspection_certificate_avatar ?? asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                        alt="Certificate Copy" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Class No -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Class No</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driver_class_no" autocomplete="on" placeholder="Driver Class No"
                                    value="{{ old('driver_class_no', $driver->speedGovernorCertificate->class_no ?? '') }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Issue Date -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Date of Issue</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_ntsa_inspection_certificate_date_of_issue" autocomplete="on"
                                    value="{{ old('driver_ntsa_inspection_certificate_date_of_issue', $driver->inspectionCertificate->ntsa_inspection_certificate_date_of_issue ?? '') }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Expiry Date -->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Expiry Date</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driver_inspection_certificate_date_of_expiry" autocomplete="on"
                                    value="{{ old('driver_inspection_certificate_date_of_expiry', $driver->inspectionCertificate->ntsa_inspection_certificate_date_of_expiry ?? '') }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Selection -->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Vehicle</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info" name="driver_vehicle_id">
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}"
                                                {{ old('driver_vehicle_id', $driver->vehicle_id ?? '') == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </span>
                            </label>
                        </div>

                        <div class="form-submit-button text-center">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                {{ $isUpdate ? 'Update' : 'Register' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center col-xs-12 col-sm-12 sms-rate-text font-roboto flex-end margin-bottom-30">
            <div class="container-sms-rate-text width-100 font-11">
                <span class="light-gray font-weight-light"></span>
                <br />
                <a href="#" class="dark-link">
                    <span class="font-weight-light">Metroberry Tours & Travel</span>
                </a>
            </div>
        </div>

        @include('components.driver-mobile-app.main-menu')
    </div>

    <script>
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
            };
            reader.readAsDataURL(file);
        }

        document.getElementById('certificate-copy-input').addEventListener('change', function(event) {
            previewImage(event, 'certificate-copy-preview');
        });
    </script>
@endsection
