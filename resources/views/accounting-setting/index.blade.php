@extends('layouts.app')

@section('title', 'Metro-Berry Account Settings')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Manage Bank Account</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#accountsModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                            Create Account
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="table-responsive">
                                                <table class="table" id="driver-table">
                                                    <thead>
                                                        <tr>
                                                            <th title="Sl" width="30">SrNo</th>
                                                            <th title="name">Name</th>
                                                            <th title="Bank">Bank</th>
                                                            <th title="Account Number">Account No</th>
                                                            <th title="Current Balance">Current Balance</th>
                                                            <th title="Contact">Contact
                                                            </th>
                                                            <th title="Bank branch">Branch
                                                            </th>
                                                            <th title="Action" width="150">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($settings as $key => $setting)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $setting->holder_name }}</td>
                                                                <td>{{ $setting->bank_name }}</td>
                                                                <td>{{ $setting->account_number }}</td>
                                                                <td>{{ $setting->opening_balance }}</td>
                                                                <td>{{ $setting->contact_number }}</td>
                                                                <td>{{ $setting->bank_address }}</td>
                                                                <td class="d-flex">
                                                                    @if (\Auth::user()->can('edit accounting setting'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-primary"
                                                                            onclick="axiosModal('/accounting-setting/{{ $setting->id }}/edit')"
                                                                            title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                    @endif
                                                                    <span class='m-1'></span>
                                                                    @if (\Auth::user()->can('delete accounting setting'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-danger"
                                                                            onclick="axiosModal('/accounting-setting/{{ $setting->id }}/delete')"
                                                                            title="Delete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="page-axios-data" data-table-id="#driver-table"></div>
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

        <div class="modal fade" id="accountsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('metro.berry.account.setting.store') }}" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Create New Bank Account</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="holder_name" class="col-sm-5 col-form-label">
                                        Account Holder Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="holder_name" class="form-control" type="text"
                                            placeholder="Account Holder Name" id="holder_name" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="bank_name" class="col-sm-5 col-form-label">
                                        Bank Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="bank_name" class="form-control" type="text" placeholder="Bank Name"
                                            id="bank_name" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="account_number" class="col-sm-5 col-form-label">
                                        Account Number
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="account_number" class="form-control" type="text"
                                            placeholder="Account Number" id="account_number" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="opening_balance" class="col-sm-5 col-form-label">
                                        Opening Balance
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="opening_balance" class="form-control" type="number"
                                            placeholder="Opening Balance" id="opening_balance" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="contact_number" class="col-sm-5 col-form-label">
                                        Contact Number
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="contact_number" class="form-control" type="text"
                                            placeholder="Contact Number" id="contact_number" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="bank_address" class="col-sm-5 col-form-label">
                                        Bank Address
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="bank_address" class="form-control" placeholder="Bank Address" id="bank_address" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </form>

            </div>
        </div>

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
    @endsection
