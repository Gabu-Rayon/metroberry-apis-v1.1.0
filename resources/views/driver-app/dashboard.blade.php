@extends('layouts.mobile-app')

@section('title', 'Metroberry | Driver')
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

        <div class="col-xs-12 col-sm-12 remaining-height">
            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <span class="float-left back-to-map hidden">
                    <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                </span>
                @if ($driver->status == 'inactive')
                    <span class="title">Account | Inactive</span>
                @else
                    <span class="title">Account | Active</span>
                @endif
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <!--All Notifications & Status Container Start-->
            <div class="change-request-status">
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

                @if ($driver->status == 'inactive')
                    <div class="request-notification-container map-notification offline-notification map-notification-warning">
                        Your account is inactive
                        <div class="font-weight-light">Contact your administrator</div>
                    </div>
                @endif

                <!-- Always show document upload forms below -->
                @if (!$driver->national_id_front_avatar || !$driver->national_id_behind_avatar)
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your national ID pictures
                        </span>
                        <form action="{{ route('driver.personal-documents', $driver->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="national_id_front_avatar" class="form-label">National ID Front Picture</label>
                                <input type="file" id="national_id_front_avatar" name="national_id_front_avatar" required>
                            </div>
                            <div class="mb-3">
                                <label for="national_id_back_avatar" class="form-label">National ID Back Picture</label>
                                <input type="file" id="national_id_back_avatar" name="national_id_back_avatar" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                @else
                    <div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">
                        National ID is valid
                    </div>
                @endif

                @if ($driver->driverLicense)
                    @if (!$driver->driverLicense->verified)
                        <div class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your license has not been verified.
                            <div class="font-weight-light">Contact your administrator</div>
                        </div>
                    @else
                        <div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your license has been verified.
                        </div>
                    @endif
                @else
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your Driver's License
                        </span>
                        <form action="{{ route('driver.license') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="driving_license_no" class="form-label">License No.</label>
                                <input type="text" id="driving_license_no" name="driving_license_no" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="issue_date" class="form-label">Issue Date</label>
                                <input type="date" id="issue_date" name="issue_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="expiry_date" name="expiry_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="license_front_avatar" class="form-label">License Front Picture</label>
                                <input type="file" id="license_front_avatar" name="license_front_avatar" required>
                            </div>
                            <div class="mb-3">
                                <label for="license_back_avatar" class="form-label">License Back Picture</label>
                                <input type="file" id="license_back_avatar" name="license_back_avatar" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                @endif

                <!-- Repeat similar structure for PSV Badge and Assigned Trips -->

            </div>
        </div>

        <!--Main Menu Start-->
        @include('components.driver-mobile-app.main-menu')
        <!--Main Menu End-->
    </div>
@endsection
