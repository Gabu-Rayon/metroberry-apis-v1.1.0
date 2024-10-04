@extends('layouts.app')

@section('title', 'Environment Setting')
@section('content')

    <body class="fixed sidebar-mini">

        @include('components.preloader')
        <!-- react page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- start header -->
                @include('components.sidebar.sidebar')
                <!-- end header -->
                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')

                        <div class="body-content">
                            <!--/.Content Header (Page header)-->
                            <div class="body-content">
                                <div class="row">
                                    <div class="col-md-12 my-2">
                                        @include('components.site-setting.site-setting-nav-bar')
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card mb-4 p-5">
                                            <!--/.Content Header (Page header)-->
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="fs-17 fw-semi-bold mb-0">Env setting</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('settings.env.update') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="alert alert-warning">
                                                        <p>
                                                            <strong>Note: </strong>
                                                            Every change there will have a direct impact on your app's
                                                            environment; this may cause your app to crash, so be careful
                                                            with
                                                            every change you make.
                                                        </p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="app_name">System name</label>
                                                                <input type="text" class="form-control" id="app_name"
                                                                    name="app_name" placeholder="System name"
                                                                    value="{{ config('app.name') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="app_url">System site URL</label>
                                                                <input id="app_url" class="form-control" type="text"
                                                                    placeholder="Site Url" name="app_url" id="app_url"
                                                                    value="{{ url('/') }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="app_env">System environment</label>
                                                                <select id="app_env" name="app_env" class="form-control">
                                                                    <option value="local"
                                                                        {{ env('APP_ENV') === 'local' ? 'selected' : '' }}>
                                                                        Local</option>
                                                                    <option value="production"
                                                                        {{ env('APP_ENV') === 'production' ? 'selected' : '' }}>
                                                                        Production</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                role="switch" id="app_debug"
                                                                                name="app_debug"
                                                                                {{ env('APP_DEBUG') ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="app_debug">System app debug</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group mb-3">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                role="switch" id="force_https"
                                                                                name="force_https"
                                                                                {{ env('FORCE_HTTPS') ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="force_https">Force HTTPS</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- SAVE CHANGES ACTION BUTTON -->
                                                        <div class="col-12 border-0 text-right mb-2 mt-1">
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
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
            <!--end vue page -->
        </div>
        <!-- END layout-wrapper -->

        <!-- Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form">
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item? You won't be able to revert this item back!
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-danger" type="submit" id="delete_submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- start scripts -->
    @endsection
