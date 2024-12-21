@extends('layouts.mobile-app')

@section('title', 'Trips Completed | Driver')

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
        @php
            $user = Auth::user();
            $driver = $user->driver;
        @endphp
        <div class="col-xs-12 col-sm-12 remaining-height">

            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="{{ route('trips.history.page') }}">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                <span class="title"> Trips | Completed</span>

                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="all-history-items remaining-height">
                    <div class="change-request-status">
                        <!-- Trips Completed -->
                        <div
                            class="request-notification-container map-notification meters-left-450 map-notification-warning">
                            <h3>Completed Trips</h3>
                            <div class="all-history-items remaining-height">
                                <!-- Check if there are trips booked -->
                                @if ($trips->isEmpty())
                                    <div class="text-center">
                                        <p>No booked trips found.</p>
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
                                                        <div class="status-none float-right text-uppercase">
                                                            Charges Kes {{ number_format($trip->total_price, 2) }}
                                                            <!-- Format charges -->
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <!--Date and Price Container End-->
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
                                                                <input class="controls flex-1 font-weight-light"
                                                                    type="text" placeholder="Enter an origin location"
                                                                    value="{{ $trip->drop_off_location }}" disabled>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="href-decoration-none">
                                                            <div
                                                                class="w-100 map-input-container map-input-container-bottom">
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
                        <!-- End of Trips Completed -->
                    </div>
                </div>
            </div>




            <!--Main Menu Start-->
            @include('components.driver-mobile-app.main-menu')
            <!--Main Menu End-->

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

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    @endsection
