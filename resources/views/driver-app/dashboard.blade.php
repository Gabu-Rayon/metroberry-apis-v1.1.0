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
                <span class="title">{{ $driver->status == 'inactive' ? 'Account | Inactive' : 'Account | Active' }}</span>
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
                        <span class="font-weight-dark m-3 my-3">Kindly upload your national ID pictures</span>
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
                        <span class="font-weight-dark m-3 my-3">Kindly upload your Driver's License</span>
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

                @if ($driver->psvBadge)
                    @if (!$driver->psvBadge->verified)
                        <div class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your PSV Badge has not been verified.
                            <div class="font-weight-light">Contact your administrator</div>
                        </div>
                    @else
                        <div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your PSV Badge has been verified.
                        </div>
                    @endif
                @else
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">Kindly upload your PSV Badge</span>
                        <form action="{{ route('driver.psvbadge.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="psv_badge_no" class="form-label">Badge No.</label>
                                <input type="text" id="psv_badge_no" name="psv_badge_no" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="psv_issue_date" class="form-label">Issue Date</label>
                                <input type="date" id="psv_issue_date" name="psv_issue_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="psv_expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="psv_expiry_date" name="psv_expiry_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="badge_copy" class="form-label">Copy</label>
                                <input type="file" id="badge_copy" name="badge_copy" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                @endif

                @if (!$driver->vehicle)
                    <div class="request-notification-container map-notification offline-notification map-notification-warning">
                        You have not been assigned a vehicle
                        <div class="font-weight-light">Contact your administrator</div>
                    </div>
                @endif

                <!-- Trips Assigned -->
                <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                    <h3>Assigned Trips</h3>
                    <div class="all-history-items remaining-height">
                        <!-- Check if there are trips booked -->
                        @if ($trips->isEmpty())
                            <div class="text-center">
                                <p>No Assigned trips found.</p>
                            </div>
                        @else
                            <!-- Loop through booked trips -->
                            @foreach ($trips as $trip)
                                <div class="history-items-container history-items-padding">
                                    <div class="history-item">
                                        <!--Date and Price Container Start-->
                                        <div class="border-bottom-primary thin">
                                            <div class="status-container">
                                                <div class="date float-left">
                                                    Date: {{ \Carbon\Carbon::parse($trip->trip_date)->format('d M Y') }},
                                                    Time: {{ $driver->time_format === '12-hour' ? \Carbon\Carbon::parse($trip->pick_up_time)->format('h:i A') : \Carbon\Carbon::parse($trip->pick_up_time)->format('H:i') }}
                                                </div>
                                                <div class="price float-right">
                                                    <span class="font-weight-light">Ksh</span>
                                                    <span class="font-weight-bold">{{ number_format($trip->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Date and Price Container End-->
                                        <!--Pick-up and Drop-off Location Container Start-->
                                        <div class="border-bottom-primary">
                                            <div class="location-container">
                                                <div class="pick-up-location">
                                                    <span>Pick-up:</span>
                                                    <span class="font-weight-bold">{{ $trip->pick_up_location }}</span>
                                                </div>
                                                <div class="drop-off-location">
                                                    <span>Drop-off:</span>
                                                    <span class="font-weight-bold">{{ $trip->drop_off_location }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--Pick-up and Drop-off Location Container End-->
                                        <!--Trip Status Container Start-->
                                        <div class="border-bottom-primary">
                                            <div class="status-container">
                                                <span>Status: </span>
                                                <span class="font-weight-bold">{{ $trip->status }}</span>
                                            </div>
                                        </div>
                                        <!--Trip Status Container End-->
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <!--All Notifications & Status Container End-->
        </div>
    </div>
@endsection
