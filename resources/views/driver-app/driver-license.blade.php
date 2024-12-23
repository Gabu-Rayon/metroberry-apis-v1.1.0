@extends('layouts.mobile-app')

@section('title', 'License | Driver')
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
                    <span>Driver's License</span>
                @endif
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title">Driver's License

                    @if ($driver->driverLicense)
                        @if ($driver->driverLicense->verified != 0)
                            <span class="badge badge-pill fs-4 badge-success">Active</span>
                        @else
                            <span class="badge badge-pill fs-4 badge-danger">Inactive</span>
                        @endif
                    @else
                        <span class="badge badge-pill fs-4 badge-danger">Inactive</span>
                    @endif

                </div>

                <!--Driver's License Fields Container Start-->
                <div class="all-container all-container-with-classes">
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
                    <form class="width-100" action="{{ route('driver.license.document.update', $driver->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Driver License Number</label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text"
                                    name="driving_license_no" autocomplete="off" placeholder="Driver License Number"
                                    value="{{ $driver->driverLicense->driving_license_no ?? null }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->


                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">First Date of issue : <span class="text-primary">
                                    {{ $driver->driverLicense->first_date_of_issue ?? null }}</span></label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="first_date_of_issue" autocomplete="off" placeholder="Driver First Date of Issue"
                                    value="#" />
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Renewal Date : <span class="text-primary">
                                    {{ $driver->driverLicense->driving_license_renewal_date_issue ?? null }}</span></label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driving_license_renewal_date_issue" autocomplete="off"
                                    placeholder="Driver License Date  of Renewal" value="#" />
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Expiry Date : <span
                                    class="text-primary">{{ $driver->driverLicense->driving_license_date_of_expiry ?? null }}</span>
                            </label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="driving_license_date_of_expiry" autocomplete="off"
                                    placeholder="Driver License Number" value="#" />
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!-- Upload Front License -->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*"
                                            name="license_front_avatar" id="national-id-front-input" />
                                    </span>
                                    <span class="text-uppercase">License FRONT</span>
                                    <span class="delete-btn" id="national-id-front-delete">
                                        <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    {{-- <img id="national-id-front-preview"
                                                          src="{{ $driver->driverLicense->driving_license_avatar_front
                                                              ? asset( $driver->driverLicense->driving_license_avatar_front)
                                                              : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                          alt="Lincense Front Avatar" /> --}}
                                                    <img id="national-id-front-preview"
                                                        src="{{ $driver->driverLicense && $driver->driverLicense->driving_license_avatar_front
                                                            ? asset('uploads/front-license-pics/'.basename($driver->driverLicense->driving_license_avatar_front))
                                                            : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                        alt="License Front Avatar" />

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
                                    <span class="text-uppercase">License BACK</span>
                                    <span class="delete-btn" id="national-id-back-delete">
                                        <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}" alt="Delete Icon" />
                                    </span>
                                </div>
                                <div class="scan-your-card-prompt margin-top-5">
                                    <div class="position-relative">
                                        <div class="upload-picture-container">
                                            <div class="upload-camera-container text-center">
                                                <span class="#">
                                                    {{-- <img id="national-id-back-preview"
                                                        src="{{ $driver->driverLicense->driving_license_avatar_back
                                                            ? asset($driver->driverLicense->driving_license_avatar_back)
                                                            : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                        alt="License Back Avatar" /> --}}

                                                    <img id="national-id-back-preview"
                                                        src="{{ $driver->driverLicense && $driver->driverLicense->driving_license_avatar_back
                                                            ? asset('uploads/back-license-pics/'.basename($driver->driverLicense->driving_license_avatar_back))
                                                            : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                        alt="License Back Avatar" />

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
