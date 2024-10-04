@extends('layouts.app')

@section('title', 'Purchase Report List')
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
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Purchase report</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm mx-2"
                                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                            aria-expanded="true" aria-controls="flush-collapseOne"> <i
                                                                class="fas fa-filter"></i> Filter</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                                    <div class="accordion-item">

                                                        <div id="flush-collapseOne"
                                                            class="accordion-collapse bg-white collapse"
                                                            aria-labelledby="flush-headingOne"
                                                            data-bs-parent="#accordionFlushExample" style="">

                                                            <div class='row pb-3 my-filter-form'>

                                                                <div class="col-sm-12 col-xl-4">
                                                                    <div class="form-group row mb-1">
                                                                        <label for="vendor"
                                                                            class="col-sm-5 col-form-label justify-content-start text-left">Vendor
                                                                        </label>
                                                                        <div class="col-sm-7">
                                                                            <select class="form-control basic-single"
                                                                                name="vendor_id" id="vendor"
                                                                                tabindex="-1" aria-hidden="true">
                                                                                <option value="">Please select one
                                                                                </option>
                                                                                <option value="1">Rahim Motors
                                                                                </option>
                                                                                <option value="2">Karim Cars</option>
                                                                                <option value="3">Tariq Traders
                                                                                </option>
                                                                                <option value="4">Ali Traders</option>
                                                                                <option value="5">Bilal Gears &amp; Co
                                                                                </option>
                                                                                <option value="6">Saeed Brothers
                                                                                </option>
                                                                                <option value="7">JAYESH FILING
                                                                                    STATION</option>
                                                                                <option value="8">C.K. MOTORS</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row mb-1">
                                                                        <label for="code"
                                                                            class="col-sm-5 col-form-label justify-content-start text-left">Invoice
                                                                        </label>
                                                                        <div class="col-sm-7">
                                                                            <input type="text" class="form-control"
                                                                                name="code" id="code"
                                                                                placeholder="Invoice">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-xl-4">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-xl-12">
                                                                            <div class="form-group row mb-1">
                                                                                <label for="date_from"
                                                                                    class="col-sm-5 col-form-label justify-content-start text-left">Date
                                                                                    from </label>
                                                                                <div class="col-sm-7">
                                                                                    <input name="date_from"
                                                                                        autocomplete="off"
                                                                                        class="form-control  w-100"
                                                                                        type="date" placeholder="From"
                                                                                        id="date_from">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-xl-12">
                                                                            <div class="form-group row mb-1">
                                                                                <label for="d_to"
                                                                                    class="col-sm-5 col-form-label justify-content-start text-left">Date
                                                                                    to </label>
                                                                                <div class="col-sm-7">
                                                                                    <input name="date_to" autocomplete="off"
                                                                                        class="form-control w-100"
                                                                                        type="date" placeholder="To"
                                                                                        id="d_to">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-2 d-flex align-items-center">
                                                                    <button class="btn btn-success me-2 search-btn"
                                                                        type="button">Search</button>
                                                                    <button class="btn btn-danger me-2 reset-btn"
                                                                        type="button">Reset</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="purchase-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Sl" width="30">Sl</th>
                                                            <th title="Invoice">Invoice</th>
                                                            <th title="Vendor">Vendor</th>
                                                            <th title="Date">Date</th>
                                                            <th title="Total">Total</th>
                                                            <th title="Updated">Updated</th>
                                                            <th title="Status">Status</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>


                                            <div id="page-axios-data" data-table-id="#purchase-table"></div>
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
                                <p>Are you sure you want to delete this item? you won t be able to revert this item back!
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
