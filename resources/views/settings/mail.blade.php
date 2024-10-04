@extends('layouts.app')

@section('title', 'Mail Setting')
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
                                                        <h6 class="fs-17 fw-semi-bold mb-0">Mail setting</h6>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('settings.mail.update') }}" method="POST">
                                                    @csrf

                                                    <div class="alert alert-warning">
                                                        <p>
                                                            <strong>Note: </strong>
                                                            Any changes you make will directly affect your app's environment
                                                            and email process. This could cause your app to crash, so please
                                                            exercise caution with every modification.
                                                        </p>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_mailer">Mail mailer</label>
                                                                <select name="mail_mailer" id="mail_mailer"
                                                                    class="form-control">
                                                                    <option value="smtp"
                                                                        {{ env('MAIL_MAILER') === 'smtp' ? 'selected' : '' }}>
                                                                        SMTP</option>
                                                                    <option value="sendmail"
                                                                        {{ env('MAIL_MAILER') === 'sendmail' ? 'selected' : '' }}>
                                                                        Sendmail</option>
                                                                    <option value="mailgun"
                                                                        {{ env('MAIL_MAILER') === 'mailgun' ? 'selected' : '' }}>
                                                                        Mailgun</option>
                                                                    <option value="ses"
                                                                        {{ env('MAIL_MAILER') === 'ses' ? 'selected' : '' }}>
                                                                        SES</option>
                                                                    <option value="postmark"
                                                                        {{ env('MAIL_MAILER') === 'postmark' ? 'selected' : '' }}>
                                                                        Postmark</option>
                                                                    <option value="log"
                                                                        {{ env('MAIL_MAILER') === 'log' ? 'selected' : '' }}>
                                                                        Log</option>
                                                                    <option value="array"
                                                                        {{ env('MAIL_MAILER') === 'array' ? 'selected' : '' }}>
                                                                        Array</option>
                                                                    <option value="failover"
                                                                        {{ env('MAIL_MAILER') === 'failover' ? 'selected' : '' }}>
                                                                        Failover</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_host">Mail host</label>
                                                                <input type="text" class="form-control" id="mail_host"
                                                                    name="mail_host" placeholder="Mail host name"
                                                                    value="{{ env('MAIL_HOST') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_port">Mail port</label>
                                                                <input type="number" class="form-control arrow-hidden"
                                                                    id="mail_port" name="mail_port"
                                                                    placeholder="Mail port number"
                                                                    value="{{ env('MAIL_PORT') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_username">Mail username</label>
                                                                <input type="text" class="form-control"
                                                                    id="mail_username" name="mail_username"
                                                                    placeholder="Mail username"
                                                                    value="{{ env('MAIL_USERNAME') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_password">Mail password</label>
                                                                <input type="password" class="form-control"
                                                                    id="mail_password" name="mail_password"
                                                                    placeholder="Mail password"
                                                                    value="{{ env('MAIL_PASSWORD') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_from_address">Sender email address</label>
                                                                <input type="text" class="form-control"
                                                                    id="mail_from_address" name="mail_from_address"
                                                                    placeholder="Sender email address"
                                                                    value="{{ env('MAIL_FROM_ADDRESS') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_from_name">Sender name</label>
                                                                <input type="text" class="form-control"
                                                                    id="mail_from_name" name="mail_from_name"
                                                                    placeholder="Sender name" value="${APP_NAME}" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group mb-3">
                                                                <label for="mail_encryption">Mail encryption</label>
                                                                <select id="mail_encryption" name="mail_encryption"
                                                                    class="form-control">
                                                                    <option value="tls"
                                                                        {{ env('MAIL_ENCRYPTION') === 'tls' ? 'selected' : '' }}>
                                                                        TLS</option>
                                                                    <option value="ssl"
                                                                        {{ env('MAIL_ENCRYPTION') === 'ssl' ? 'selected' : '' }}>
                                                                        SSL</option>
                                                                </select>
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
            <!--end  vue page -->
        </div>
        <!-- END layout-wrapper -->
    @endsection
