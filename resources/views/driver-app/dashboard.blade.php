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
                    <img src=" {{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                </span>
                @if ($driver->status == 'inactive')
                    <span class="title">Account | Inactive</span>
                @else
                    <span class="title">Account | Active</span>
                @endif
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src=" {{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
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
                    <div
                        class="request-notification-container map-notification offline-notification map-notification-warning">
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
                        <form action="{{ route('driver.personal-documents', $driver->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Upload Front national ID -->
                            <div class="form-group">
                                <label class="width-100">
                                    <div class="display-flex justify-content-between">
                                        <span class="position-relative upload-btn">
                                            <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}"
                                                alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*"
                                                name="national_id_front_avatar" id="national-id-front-input"
                                                value="{{ old('national_id_front_avatar') }}" required />
                                        </span>
                                        <span class="text-uppercase">National ID FRONT</span>
                                        <span class="delete-btn" id="national-id-front-delete">
                                            <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}"
                                                alt="Delete Icon" />
                                        </span>
                                    </div>
                                    <div class="scan-your-card-prompt margin-top-5">
                                        <div class="position-relative">
                                            <div class="upload-picture-container">
                                                <div class="upload-camera-container text-center">
                                                    <span class="#">
                                                        <img id="national-id-front-preview"
                                                            src="{{ $driver->national_id_front_avatar
                                                                ? asset($driver->national_id_front_avatar)
                                                                : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                            alt="National ID Front" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Upload behind national ID -->
                            <div class="form-group">
                                <label class="width-100">
                                    <div class="display-flex justify-content-between">
                                        <span class="position-relative upload-btn">
                                            <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}"
                                                alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*"
                                                name="national_id_back_avatar" id="national-id-back-input"
                                                value="{{ old('national_id_back_avatar') }}" required />
                                        </span>
                                        <span class="text-uppercase">National ID BACK</span>
                                        <span class="delete-btn" id="national-id-back-delete">
                                            <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}"
                                                alt="Delete Icon" />
                                        </span>
                                    </div>
                                    <div class="scan-your-card-prompt margin-top-5">
                                        <div class="position-relative">
                                            <div class="upload-picture-container">
                                                <div class="upload-camera-container text-center">
                                                    <span class="#">
                                                        <img id="national-id-back-preview"
                                                            src="{{ $driver->national_id_behind_avatar
                                                                ? asset($driver->national_id_behind_avatar)
                                                                : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                            alt="National ID Back" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                @endif

                @if ($driver->driverLicense)
                    @if (!$driver->driverLicense->verified)
                        <div
                            class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your license has not been verified.
                            <div class="font-weight-light">Contact your administrator</div>
                        </div>
                    @endif
                @else
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your Driver's License
                        </span>
                        <form action="{{ route('driver.add.license') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="driving_license_no" class="form-label">License No.</label>
                                <input type="text" id="driving_license_no" name="driving_license_no" class="form-control"
                                    required value="{{ old('driving_license_no') }}">
                            </div>
                            <div class="mb-3">
                                <label for="first_date_of_issue" class="form-label">First Date of Issue</label>
                                <input type="date" id="first_date_of_issue" name="first_date_of_issue"
                                    class="form-control" value="{{ old('first_date_of_issue') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="issue_date" class="form-label">Renewal Date</label>
                                <input type="date" id="issue_date" name="driving_license_renewal_date_issue"
                                    class="form-control" value="{{ old('driving_license_renewal_date_issue') }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="expiry_date" name="expiry_date" class="form-control"
                                    value="{{ old('expiry_date') }}" required>
                            </div>
                            <!-- Upload Front License -->
                            <div class="form-group">
                                <label class="width-100">
                                    <div class="display-flex justify-content-between">
                                        <span class="position-relative upload-btn">
                                            <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}"
                                                alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*"
                                                name="license_front_avatar" id="national-id-front-input" />
                                        </span>
                                        <span class="text-uppercase">License FRONT</span>
                                        <span class="delete-btn" id="national-id-front-delete">
                                            <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}"
                                                alt="Delete Icon" />
                                        </span>
                                    </div>
                                    <div class="scan-your-card-prompt margin-top-5">
                                        <div class="position-relative">
                                            <div class="upload-picture-container">
                                                <div class="upload-camera-container text-center">
                                                    <span class="#">
                                                        <img id="national-id-front-preview"
                                                            src="{{ $driver->driverLicense && $driver->driverLicense->driving_license_avatar_front
                                                                ? asset($driver->driverLicense->driving_license_avatar_front)
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
                                            <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}"
                                                alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*"
                                                name="license_back_avatar" id="national-id-back-input" />
                                        </span>
                                        <span class="text-uppercase">License BACK</span>
                                        <span class="delete-btn" id="national-id-back-delete">
                                            <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}"
                                                alt="Delete Icon" />
                                        </span>
                                    </div>
                                    <div class="scan-your-card-prompt margin-top-5">
                                        <div class="position-relative">
                                            <div class="upload-picture-container">
                                                <div class="upload-camera-container text-center">
                                                    <span class="#">
                                                        <img id="national-id-back-preview"
                                                            src="{{ $driver->driverLicense && $driver->driverLicense->driving_license_avatar_back
                                                                ? asset($driver->driverLicense->driving_license_avatar_back)
                                                                : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                            alt="License Back Avatar" />

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <button type="submit"
                                class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                @endif

                @if ($driver->psvBadge)
                    @if (!$driver->psvBadge->verified)
                        <div
                            class="request-notification-container map-notification offline-notification map-notification-warning">
                            Your PSV Badge has not been verified.
                            <div class="font-weight-light">Contact your administrator</div>
                        </div>
                    @endif
                @else
                    <div class="request-notification-container map-notification meters-left-450 map-notification-warning">
                        <span class="font-weight-dark m-3 my-3">
                            Kindly upload your PSV Badge
                        </span>
                        <form action="{{ route('driver.psvbadge.create') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="psv_badge_no" class="form-label">Badge No.</label>
                                <input type="text" id="psv_badge_no" name="psv_badge_no"
                                    value="{{ old('psv_badge_no') }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="psv_issue_date" class="form-label">Issue Date</label>
                                <input type="date" id="psv_issue_date" name="psv_issue_date"
                                    value="{{ old('psv_issue_date') }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="psv_expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" id="psv_expiry_date" name="psv_expiry_date"
                                    value="{{ old('psv_expiry_date') }}" class="form-control" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="badge_copy" class="form-label">Copy</label>
                                <input type="file" id="badge_copy" name="badge_copy" value="{{ old('badge_copy') }}"
                                    required>
                            </div> --}}
                            <!--Upload Front Start-->
                            <div class="form-group">
                                <label class="width-100">
                                    <div class="display-flex justify-content-between">
                                        <span class="position-relative upload-btn">
                                            <img src="{{ asset('mobile-app-assets/icons/upload.svg') }}"
                                                alt="Upload Icon" />
                                            <input class="scan-prompt" type="file" accept="image/*" name="badge_copy"
                                                value="{{ old('badge_copy') }}" required id="national-id-back-input" />
                                        </span>
                                        <span class="text-uppercase">PSV Badge Copy</span>
                                        <span class="delete-btn" id="national-id-back-delete">
                                            <img src="{{ asset('mobile-app-assets/icons/delete.svg') }}"
                                                alt="Delete Icon" />
                                        </span>
                                    </div>
                                    <div class="scan-your-card-prompt margin-top-5">
                                        <div class="position-relative">
                                            <div class="upload-picture-container">
                                                <div class="upload-camera-container text-center">
                                                    <span class="#">
                                                        <img id="national-id-back-preview"
                                                            src="{{ $driver->psvBadge && $driver->psvBadge->psv_badge_avatar
                                                                ? asset($driver->psvBadge->psv_badge_avatar)
                                                                : asset('mobile-app-assets/icons/photocamera.svg') }}"
                                                            alt="PSV Badge Avatar" />

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <!--Upload Front End-->
                            <button type="submit"
                                class="btn btn-primary w-50 m-2 float-end text-uppercase">Submit</button>
                        </form>
                    </div>
                @endif

                @if (!$driver->vehicle)
                    <div
                        class="request-notification-container map-notification offline-notification map-notification-warning">
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
                                                    Date :
                                                    {{ \Carbon\Carbon::parse($trip->trip_date)->format('d M Y') }},
                                                    @if ($driver->time_format === '12-hour')
                                                        Time :
                                                        {{ \Carbon\Carbon::parse($trip->pick_up_time)->format('h:i A') }}
                                                        <!-- 12-hour format -->
                                                    @else
                                                        Time :
                                                        {{ \Carbon\Carbon::parse($trip->pick_up_time)->format('H:i') }}
                                                        <!-- 24-hour format -->
                                                    @endif
                                                </div>
                                                <br>
                                                <div class="status-none float-right text-uppercase">
                                                    Charges Kes {{ number_format($trip->total_price, 2) }}
                                                    <!-- Format charges -->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="addresses-container position-relative">
                                            Customer : {{ $trip->customer->user->name }}
                                            <br>
                                            Route : {{ $trip->route->name }}
                                        </div>
                                        <!--Trips Details Address Container Start-->
                                        <div class="addresses-container position-relative">
                                            <div class="height-auto">
                                                <div class="w-100 map-input-container map-input-container-top">
                                                    <span
                                                        class="fas fa-location-arrow location-icon-rotate map-input-icon"></span>
                                                    <div class="map-input display-flex">
                                                        <input class="controls flex-1 font-weight-light" type="text"
                                                            placeholder="Enter an origin location"
                                                            value="{{ $trip->drop_off_location }}" disabled>
                                                    </div>
                                                </div>
                                                <a href="#" class="href-decoration-none">
                                                    <div class="w-100 map-input-container map-input-container-bottom">
                                                        <span class="map-input-icon"><img
                                                                src="{{ asset('mobile-app-assets/icons/circle.svg') }}"
                                                                alt="Current Location Icon"></span>
                                                        <div
                                                            class="map-input display-flex controls flex-1 align-items-center">
                                                            {{ $trip->pick_up_location }}
                                                        </div>
                                                        <span class="dotted-line"></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!--Trip Details Address Container End-->
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!-- End of Assgined Completed -->
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
    <!--Terms And Conditions Agreement Container End-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="{{ asset('mobile-app-assets/js/jquery-3.4.1.js') }}"></script>

    <script>
        const divHtml =
            '<div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">National ID is valid</div>';
        const frontAvatar = '{{ $driver->national_id_front_avatar }}';
        const backAvatar = '{{ $driver->national_id_behind_avatar }}';
        const licenseVerified =
            "{{ $driver->driverLicense ? ($driver->driverLicense->verified ? 'true' : 'false') : 'false' }}";
        const psvBadgeVerified = "{{ $driver->psvBadge ? ($driver->psvBadge->verified ? 'true' : 'false') : 'false' }}";
        const parent = document.querySelector('.change-request-status');
        const assignedTripsDiv = document.querySelector(
            '.request-notification-container.map-notification.meters-left-450.map-notification-warning');

        const licenseHtml =
            '<div id="verified-message" class="request-notification-container map-notification offline-notification map-notification-warning">Your license has been verified.</div>';
        const psvBadgeHtml =
            '<div id="verified-message"class="request-notification-container map-notification offline-notification map-notification-warning">Your PSV Badge has been verified.</div>';

        $(document).ready(function() {
            if (frontAvatar && backAvatar) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = divHtml;

                const verifiedMessageNode = tempDiv.firstChild;
                parent.insertBefore(verifiedMessageNode, assignedTripsDiv);

                setTimeout(() => {
                    verifiedMessageNode.remove();
                }, 5000);
            }


            if (licenseVerified === 'true') {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = licenseHtml;

                const verifiedMessageNode = tempDiv.firstChild;
                parent.insertBefore(verifiedMessageNode, assignedTripsDiv);

                setTimeout(() => {
                    verifiedMessageNode.remove();
                }, 5000);
            }

            if (psvBadgeVerified === 'true') {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = psvBadgeHtml;

                const verifiedMessageNode = tempDiv.firstChild;
                parent.insertBefore(verifiedMessageNode, assignedTripsDiv);

                setTimeout(() => {
                    verifiedMessageNode.remove();
                }, 5000);
            }
        });

        document.getElementById('id-upload-form').addEventListener('submit', function(e) {
            const frontInput = document.getElementById('national-id-front-input').files[0];
            const backInput = document.getElementById('national-id-back-input').files[0];

            // Ensure both files are selected
            if (!frontInput || !backInput) {
                alert('Please upload both front and back images of your ID.');
                e.preventDefault();
                return;
            }

            // Check file types
            if (frontInput.type.split('/')[0] !== 'image' || backInput.type.split('/')[0] !== 'image') {
                alert('Please upload valid image files.');
                e.preventDefault();
                return;
            }

            // Check file sizes
            const maxSize = 2 * 1024 * 1024; // 2 MB limit
            if (frontInput.size > maxSize || backInput.size > maxSize) {
                alert('Each file should be less than 2MB.');
                e.preventDefault();
                return;
            }

            // Additional custom checks can be added here
        });
    </script>



@endsection
