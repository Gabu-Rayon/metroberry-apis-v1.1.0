@extends('layouts.app')

@section('title', 'Profile')
@section('content')

    <div class="wrapper">
        @include('components.preloader')
        @include('components.sidebar.sidebar')
        <div class="content-wrapper">
            <div class="main-content">
                @include('components.navbar')
                <div class="body-content">
                    <div class="tile">

                        <div class="row justify-content-center">
                            <div class="col-md-8 col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="fs-17 fw-semi-bold mb-0">Profile</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="media m-1 ">
                                                <div class="align-left p-1">
                                                    <a href="#" class="profile-image">
                                                        <a href="#" class="profile-image">
                                                            <img src="{{ url('storage/' . \Auth::user()->avatar) }}"
                                                                class="avatar avatar-xl rounded-circle img-border height-100"
                                                                alt="Profile Image">
                                                        </a>
                                                    </a>
                                                </div>
                                                <div class="media-body ms-3 mt-1">
                                                    <h3 class="font-large-1 white">
                                                        {{ Auth::user()->name }}
                                                        <span class="font-medium-1 white">({{ Auth::user()->role }})</span>
                                                    </h3>
                                                    <div class="row justify-content-center">

                                                        <table class="table table-borderless table-responsive">

                                                            <tbody>

                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-map-marker-alt"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        {{ Auth::user()->address }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-phone"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        {{ Auth::user()->phone }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-envelope"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        {{ Auth::user()->email }}
                                                                    </td>
                                                                </tr>

                                                                 @if (Auth::user()->role == 'organisation' && Auth::user()->organisation)
                                                                <tr>
                                                                    <th class="white">
                                                                        <i class="fas fa-building"></i>
                                                                    </th>
                                                                    <td class="white text-start">
                                                                        {{ Auth::user()->organisation->organisation_code }}
                                                                    </td>
                                                                </tr>
                                                            @endif

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overlay"></div>
            @include('components.footer')
        </div>
    </div>
    <!--end  vue page -->
    </div>
    <!-- END layout-wrapper -->

@endsection
