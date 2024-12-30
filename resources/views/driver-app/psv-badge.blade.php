@extends('layouts.mobile-app')

@section('title', 'Psv Badge | Driver')
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
                        <img src=" {{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                @if ($driver->status == 'inactive')
                    <span>Deactivated</span>
                @else
                    <span>Psv Badge</span>
                @endif
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src=" {{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="address-title">Psv Badge

                    @if ($driver->psvBadge)
                        @if ($driver->psvBadge->verified != 0)
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
                    <form class="width-100" action="{{ route('psvbadge.document.update', $driver->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Psv badge no : </label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="text" name="psv_badge_no"
                                    autocomplete="off" placeholder="Psv badge no"
                                    value="{{ $driver->psvBadge->psv_badge_no ?? null }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->
                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Date of Issue : <span class="text-primary">
                                    {{ $driver->psvBadge->psv_badge_date_of_issue ?? null }}</span></label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="psv_badge_date_of_issue" autocomplete="off"
                                    value="{{ $driver->psvBadge->psv_badge_date_of_issue ?? null }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Input Field Container Start-->
                        <div class="form-group form-control-margin">
                            <label class="label-title">Expiry Date : <span class="text-primary">
                                    {{ $driver->psvBadge->psv_badge_date_of_expiry ?? null }}</span></label>
                            <div class="input-group">
                                <input class="form-control form-control-with-padding" type="date"
                                    name="psv_badge_date_of_expiry" autocomplete="off"
                                    value="{{ $driver->psvBadge->psv_badge_date_of_expiry ?? null }}" />
                                <div class="input-group-append">
                                    <span class="fas fa-id-card icon-inherited-color"></span>
                                </div>
                            </div>
                        </div>
                        <!--Input Field Container End-->

                        <!--Upload Front Start-->
                        <div class="form-group">
                            <label class="width-100">
                                <div class="display-flex justify-content-between">
                                    <span class="position-relative upload-btn">
                                        <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}" alt="Upload Icon" />
                                        <input class="scan-prompt" type="file" accept="image/*" name="badge_copy"
                                            value="{{ old('badge_copy') }}" required id="national-id-back-input" />
                                    </span>
                                    <span class="text-uppercase">PSV Badge Copy</span>
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
                                                        src="{{ $driver->psvBadge && $driver->psvBadge->psv_badge_avatar
                                                            ? asset('uploads/psvbadge-avatars/' .basename($driver->psvBadge->psv_badge_avatar))
                                                            : asset('mobile-app-assets/icons/photocamera.svg') }}?{{ time() }}"
                                                        alt="PSV Badge Avatar" />

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <!--Upload Front End-->

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
        // Image preview function
        document.getElementById('psvBadgeInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('psvBadgePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
