@extends('layouts.mobile-app')

@section('title', 'Vehicle Registration | Driver')
@section('content')
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12">
            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="{{ route('driver.dashboard') }}">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                <span>Driver Vehicle Registration</span>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('mobile-app-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>

            <!--Page Title & Icons End-->
            <div class="rest-container">
                <div class="text-center header-icon-logo-margin header-icon-logo-margin-extra">
                    <div class="profile-picture-container">
                        <img src="{{ asset('mobile-app-assets/images/driver-registration.svg') }}"
                            alt="Driver Vehicle Registration Icon" />
                    </div>
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
            
                <div class="address-title">Driver Vehicle Registration</div>

                <!--Driver Vheicle Registration Information Links Container Start-->
                <div class="sign-up-form-container">
                    <div class="width-100">
                        <!--Driver Vehicle'sItem Start-->
                        <div class="border-bottom-primary">
                            <a href="{{ route('driver.registration.vehicle') }}" class="home-options-list href-decoration-none">
                                Vehicle
                                <span class="fas fa-check icon chosen hidden"></span>
                                <span class="icon choose float-right">
                                    <img src="{{ asset('mobile-app-assets/icons/angle-right.svg') }}"
                                        alt="Angle Right Icon" />
                                </span>
                            </a>
                        </div>
                        <!--Driver Vehicle's Item End-->

                        <!--Driver Vehicle Insruance Card Item Start-->
                        <div class="border-bottom-primary">
                            <a href="{{ route('driver.registration.vehicle.insurance.document') }}"
                                class="home-options-list href-decoration-none">
                                Vehicle Insurance
                                <span class="fas fa-check icon chosen hidden"></span>
                                <span class="icon choose float-right">
                                    <img src="{{ asset('mobile-app-assets/icons/angle-right.svg') }}"
                                        alt="Angle Right Icon" />
                                </span>
                            </a>
                        </div>
                        <!--Driver   VwehicleInsruance Card Item End-->

                        <!--Driver NTSA INSPECTION Certificate Item Start-->
                        <div class="border-bottom-primary">
                            <a href="{{ route('driver.registration.ntsa.ispection.certificate.document') }}" class="home-options-list href-decoration-none">
                                NTSA Inspect Certificate
                                <span class="fas fa-check icon chosen hidden"></span>
                                <span class="icon choose float-right">
                                    <img src="{{ asset('mobile-app-assets/icons/angle-right.svg') }}"
                                        alt="Angle Right Icon" />
                                </span>
                            </a>
                        </div>
                        <!--Driver  NTSA INSPECTION Certificate Item End-->

                         <!--Driver Speed Governor Item Start-->
                        <div class="border-bottom-primary">
                            <a href="{{ route('driver.speed.governor.registration') }}" class="home-options-list href-decoration-none">
                                Speed Governor
                                <span class="fas fa-check icon chosen hidden"></span>
                                <span class="icon choose float-right">
                                    <img src="{{ asset('mobile-app-assets/icons/angle-right.svg') }}"
                                        alt="Angle Right Icon" />
                                </span>
                            </a>
                        </div>
                        <!--Driver  Speed Governor  Item End-->

                    </div>
                </div>
                <!--Driver Vehicle Registration Information Links Container End-->
            </div>
        </div>
        <!--Terms And Conditions Agreement Container Start-->
        <div class="col-xs-12 col-sm-12 text-center sms-rate-text font-roboto flex-end margin-bottom-30">
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
@endsection
