@extends('layouts.mobile-app')

@section('title', 'Sign in | Metroberry Be-Spoken')
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
                <a href="{{ route('sign.up.options.page') }}">
                    <span class="float-left">
                        <img src="{{ asset('mobile-app-assets/icons/back.svg') }}" alt="Back Icon">
                    </span>
                </a>
                <span>Sign In | Metroberry Be-Spoken </span>
            </div>
            <!--Page Title & Icons End-->

            <div class="rest-container">
                <div class="text-center header-icon-logo-margin header-icon-logo-margin-extra">
                    <img src="{{ asset('company-logos/logo_white.png') }}" height="150" width="300" alt="Main Logo">
                    <div>
                        <p class="text-dark fs-16">Be-Spoken</p>
                    </div>
                </div>

                <!--Sign Up Container Start-->
                <div class="sign-up-form-container text-center">

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
                </div>
                <div class="sign-up-form-container text-center">

                    <form class="width-100"method="POST" action="{{ route('auth.users.sign.in') }}">
                        @csrf
                        <!--Sign In Form Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span>
                                        <img src="{{ asset('mobile-app-assets/icons/avatar-light.svg') }}"
                                            alt="Avatar Icon">
                                    </span>
                                </div>
                                <input class="form-control" type="text" autocomplete="off" name="email"
                                    placeholder="Email Address" value="{{ old('email') }}">
                            </div>
                        </div>
                        <!--Sign In Form Field End-->

                        <!--Sign In Form Field Start-->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span>
                                        <img src="{{ asset('mobile-app-assets/icons/lock.svg') }}" alt="Lock Icon">
                                    </span>
                                </div>
                                <input class="form-control" type="password" name="password" placeholder="Password">
                                <div class="input-group-append password-visibility">
                                    <span>
                                        <img src="{{ asset('mobile-app-assets/icons/eye.svg') }}"
                                            alt="Password Visibility Icon">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--Sign In Form Field End-->
                        <div class="form-submit-button">
                            <button class="btn btn-primary text-uppercase" type="submit">Sign In </button>
                        </div>
                    </form>

                    <div class="have-an-account text-center mt-3">
                        <a href="{{ route('sign.up.options.page') }}" class="regular-link">Don't have an account ? Sign
                            up</a>
                    </div>

                    <div class="have-an-account text-center mt-3">
                        <a href="{{ route('password.request') }}" class="regular-link">Forgot Password?</a>
                    </div>
                </div>
                <!--Sign Up Container Start-->

            </div>
        </div>
    @endsection
