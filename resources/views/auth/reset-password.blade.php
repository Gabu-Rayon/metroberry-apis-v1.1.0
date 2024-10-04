@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    @include ('components.preloader')
    <div class="container-fluid ">

        <div class="row h-100vh align-aitems-center px-0">

            <div class="col-lg-6 d-flex align-aitems-center">

                <div class="form-wrapper m-auto">

                    <div>

                        <div class="">

                            <div class="mb-4">

                                <h2 class="fs-32 fw-bold text-center">Reset Your Password</h3>

                            </div>


                            <form class="register-form validate" method="POST" action="{{ route('password.store') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="mb-3">
                                    <input type="email" class="form-control input-py" id="email" name="email"
                                        placeholder="Email" required autocomplete="email"
                                        value="{{ old('email', $request->email) }}">
                                </div>

                                <div class="mb-3">
                                    <input type="password" class="form-control input-py" id="password" name="password"
                                        placeholder="Password" required />
                                </div>

                                <div class="mb-3">
                                    <input type="password" class="form-control input-py" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm Password" required />
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    Reset Password
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
