@extends('layouts.mobile-app')

@section('title', 'Successful Verified | Driver')
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
                <a href="sign-up.html">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                <span>Successfully Verified</span>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <!--Successful Verification Information Start-->
                <div class="text-center header-icon-logo-margin header-icon-logo-margin-extra">
                    <img src="{{ asset('mobile-app-assets/icons/verified.svg') }}" alt="Verification Successful" />
                </div>
                <div class="verification-text">Verified!</div>
                <div class="all-container text-center font-weight-light">
                    You have successfully verified your phone number. You can use your
                    phone number as your username.
                </div>
                <!--Successful Verification Information End-->

                <!--Login Button Start-->
                <div class="sign-up-form-container text-center">
                    <form class="width-100">
                        <div class="form-submit-button">
                            <a href="index.html" class="btn btn-primary font-weight-light text-uppercase">Login Now</a>
                        </div>
                    </form>
                </div>
                <!--Login Button End-->
            </div>
        </div>

        <!--Terms And Conditions Agreement Container Start-->
        <div class="col-xs-12 col-sm-12 text-center sms-rate-text font-roboto flex-end margin-bottom-30">
            <div class="container-sms-rate-text width-100 font-11">
                <span class="light-gray font-weight-light">By signing up you have agreed to our
                </span>
                <br />
                <a href="#" class="dark-link">
                    <span class="font-weight-light">Terms of Use & Privacy Policy</span>
                </a>
            </div>
        </div>
        <!--Terms And Conditions Agreement Container End-->
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
@endsection
