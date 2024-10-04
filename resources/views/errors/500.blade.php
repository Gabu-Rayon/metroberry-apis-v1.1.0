@extends ('layouts.app')

@section ('title', '500 - Server Error')

@section('content')

    @include ('components.preloader')

    <div class="container-fluid ">
        <div class="d-flex align-items-center justify-content-center text-center h-100vh">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="four_zero_four_bg">
                        <h1 class="fw-bold text-monospace">500</h1>
                    </div>
                    <div class="contant_box_505">
                        <h3 class="h2">Something is wrong with our server</h3>
                        <p><b>500 - Server Error</b>
                            Sit tight while we take a look</p>
                    </div>
                    <div>
                        <a class="btn btn-success mt-3" href="{{ route('dashboard') }}">
                            <i class="typcn typcn-arrow-back-outline mr-1"></i>
                            Home
                        </a>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <footer class="text-center text-black">
                        <div class="">
                            <div class="copy">© 2024 <a class="text-capitalize" href="https://metroberry.co.ke/"
                                                        target="_blank">MetroBerry</a>.</div>
                            <div class="credit">Designed &amp; developed by: <a href="https://yourapps.co.ke/"
                                                                                target="_blank">Your Apps</a></div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </div>

@endsection
