@extends('layouts.mobile-app')

@section('title', 'Vehicle Assigned Status | Driver')
@section('content')
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        @php
            $user = Auth::user();
            $driver = $user->driver;
        @endphp
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="text-center header-icons-container">
                <a href="{{ route('driver.registration.page') }}">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                @if ($driver->status == 'inactive')
                    <span>Deactivated</span>
                @else
                    <span>Vehicle Assigned Status</span>
                @endif
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title"></div>

                <!--Driver's License Fields Container Start-->
                <div class="all-container all-container-with-classes">
                    <form class="width-100" action="{{ route('driver.license.document.update', $driver->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="license_back_avatar" id="national-id-back-input" />
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
                        <!--Car Registration Field Start-->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Current Organisation</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info" name="organisation_id">
                                        @foreach ($organisations as $organisation)
                                            <option value="{{ $organisation->id }}"
                                                {{ $driver->vehicle && $driver->vehicle->organisation_id == $organisation->id ? 'selected' : '' }}>
                                                {{ $organisation->user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </span>
                            </label>
                        </div>
                        <!--Car Registration Field End-->
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <!--Car Registration Field Start-->
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Current Vehicle Class</span>
                                <span class="car-info-wrap display-block">
                                    <select class="custom-select font-weight-light car-info" name="vehicle_class_id">
                                        @foreach ($vehicleClasses as $vehicleClass)
                                            <option value="{{ $vehicleClass->id }}"
                                                {{ $driver->vehicle && $driver->vehicle->class_id == $vehicleClass->id ? 'selected' : '' }}>
                                                {{ $vehicleClass->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Car Registration Number</span>
                                <input class="form-control text-input font-weight-light" type="text" autocomplete="off"
                                    name="car-registration-num" value="{{ $driver->vehicle->plate_number ?? null }}" />
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Fuel Type</span>
                                <input class="form-control text-input font-weight-light" type="text" autocomplete="off"
                                    name="car-registration-num" value="{{ $driver->vehicle->fuel_type ?? null }}" />
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="width-100">
                                <span class="label-title">Fuel Type</span>
                                <input class="form-control text-input font-weight-light" type="text" autocomplete="off"
                                    name="car-registration-num" value="{{ $driver->vehicle->fuel_type ?? null }}" />
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <span class="label-title">Date of Manufacture</span>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                    <span class="far fa-calendar-alt"></span>
                                </div>
                                <input class="form-control" type="text" name="date"
                                    value="{{ $driver->vehicle->year ?? null }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <span class="label-title">Manufacture</span>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                </div>
                                <input class="form-control" type="text" name="date"
                                    value="{{ $driver->vehicle->make ?? null }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="width-100 mb-0">
                                <span class="label-title">Engine Size</span>
                            </label>
                            <div class="input-group light-field">
                                <div class="input-group-prepend">
                                </div>
                                <input class="form-control" type="text" name="date"
                                    value="{{ $driver->vehicle->engine_size ?? null }}" />
                            </div>
                        </div>

                        <hr>
                        <div class="text-center car-registration-container">
                            <h4>
                                Please Upload Car Registration<br />
                                Certificate Below
                            </h4>
                        </div>
                        <!-- Upload Front License -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="license_front_avatar" id="national-id-front-input" />
                                    </span>
                                    <span class="text-uppercase">FRONT</span>
                                    <span class="delete-btn" id="national-id-front-delete">
                                        <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img src="{{ asset('mobile-app-assets/icons/photocamera.svg') }}" />
                                                    {{-- <img id="national-id-front-preview"
                                                          src="{{ $driver->driverLicense->driving_license_avatar_front
                                                              ? asset( $driver->driverLicense->driving_license_avatar_front)
                                                              : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                          alt="Front" /> --}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>


                        <!-- Upload behind License -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="license_back_avatar" id="national-id-back-input" />
                                    </span>
                                    <span class="text-uppercase">BACK</span>
                                    <span class="delete-btn" id="national-id-back-delete">
                                        <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    <img src="{{ asset('mobile-app-assets/icons/photocamera.svg') }}" />
                                                    {{-- <img id="national-id-back-preview"
                                                          src="{{ $driver->driverLicense->driving_license_avatar_back
                                                              ? asset( $driver->driverLicense->driving_license_avatar_back)
                                                              : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                          alt="Back" /> --}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="text-center form-submit-button">
                            <button type="submit" class="btn btn-dark text-uppercase">
                                Update
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
    <hr>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>
        function previewImage(event, previewElementId) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const imgElement = document.getElementById(previewElementId);
                imgElement.src = e.target.result;
                imgElement.style.display = 'block'; // Show the image
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
