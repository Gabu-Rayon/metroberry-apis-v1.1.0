@extends('layouts.mobile-app')

@section('title', 'Send Code | Driver')
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
                <span>Send Code</span>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <!--Verification Information Container Start-->
                <div class="text-center header-icon-logo-margin">
                    <img src="{{ asset('mobile-app-assets/images/logo-main.svg') }}" alt="Main Logo" />
                    <div class="margin-top-25">
                        <div class="verify-text">
                            <span class="font-20">Verify Code</span>
                        </div>
                        <span class="font-weight-light font-roboto font-15">
                            Please check your SMS. <br />
                            We just sent a verification code on your phone
                            <br />
                            + 1 (000) 555 - 0000
                        </span>
                    </div>
                </div>
                <!--Verification Information Container End-->

                <!--Verification Code Container Start-->
                <div class="sign-up-form-container text-center">
                    <form class="width-100">
                        <div class="form-group">
                            <div class="input-group border-bottom">
                                <input class="form-control verify-sms" type="tel" name="username" placeholder="----"
                                    maxlength="4" />
                            </div>
                        </div>
                        <div>
                            <span>Didn't get a code? </span>
                            <a href="#" class="href-decoration-none primary-color">Try Again</a>
                        </div>
                        <div class="form-submit-button">
                            <a href="successful-verification.html"
                                class="btn btn-primary text-uppercase verify-btn">Verify</a>
                        </div>
                    </form>
                </div>
                <!--Verification Code Container Start-->
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
