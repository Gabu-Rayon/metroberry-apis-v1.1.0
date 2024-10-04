@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
    @include ('components.preloader')
    <div class="container-fluid ">

        <div class="row h-100vh align-aitems-center px-0">

            <div class="col-lg-6 d-flex align-aitems-center">

                <div class="form-wrapper m-auto">

                    <div>

                        <div class="">

                            <div class="mb-4">

                                <h2 class="fs-32 fw-bold text-center">Forgot password?</h3>
                                    <p class="text-muted text-center mb-0">Enter your email to reset your password</p>
                            </div>


                            <form class="register-form validate" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <input type="email" class="form-control input-py " id="email" name="email"
                                        placeholder="Enter email" required autocomplete="email">
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    Send password reset link
                                </button>
                            </form>
                        </div>

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    </div>
                </div>
            </div>
            <div class="col-lg-6 login-bg d-none d-lg-block overflow-hidden text-end py-2"
                style="background-image: url('{{ asset('admin-assets/img/login-bg.png?v=1') }}')">
                <img class="#" height="50" width="150" src="{{ asset('admin-assets/img/sidebar-logo.png?v=1') }}"
                    alt="Brand Logo" />
            </div>
        </div>
    </div>
@endsection
