@extends ('layouts.app')

@section('title', '404 Not Found')

@section('content')

    @include ('components.preloader')

    <div class="container-fluid ">
        <div class="d-flex align-items-center justify-content-center text-center h-100vh">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="four_zero_four_bg">
                        <h1 class="fw-bold text-monospace">404</h1>
                    </div>
                    <div class="contant_box_505">
                        <h3 class="h2">Not Found!</h3>
                        <p><b>404 - Not Found:</b>
                            Sorry i looked everywhere and still came up empty handed</p>
                    </div>
                    <div>
                        <a class="btn btn-success mt-3" href="{{ route('sign.up.options.page') }}">
                            <i class="typcn typcn-arrow-back-outline mr-1"></i>
                            Home
                        </a>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <footer class="text-center text-black">
                        <div class="">
                            <div class="copy">© 2024 <a class="text-capitalize" href="https://metroberry.co.ke/"
                                    target="_blank">Metroberry Tours & Travel</a>.</div>
                            <div class="credit">Designed &amp; developed by: <a href="https://yourapps.co.ke/"
                                    target="_blank">Your Apps Limited</a></div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </div>

@endsection
