@extends('layouts.app')

@section('title', 'Employees')
@section('content')

    <head>
        <style>
            .generate-btn-container {
                position: absolute;
                top: 0;
                right: 0;
                transform: translateY(-50%);
                cursor: pointer;
            }

            .generate-btn {
                padding: 5px 10px;
                font-size: 0.8em;
            }
        </style>
    </head>

    <body class="fixed sidebar-mini">
        @include('components.preloader')
        <div id="app">
            <div class="wrapper">
                @include('components.sidebar.sidebar')
                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')
                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Employees</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        @if (Auth::user()->can('export customers'))
                                                            <a class="btn btn-success btn-sm"
                                                                href={{ route('employee.export') }} title="Export">
                                                                <i class="fa-solid fa-file-export"></i>&nbsp; Export
                                                            </a>
                                                        @endif
                                                        <span class='m-1'></span>
                                                        @if (Auth::user()->can('import customers'))
                                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('employee/import')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                                        @endif
                                                        <span class='m-1'></span>
                                                        @if (\Auth::user()->can('create customer'))
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#employeeModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                                Add Employee
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Name">Name</th>
                                                        <th title="Email">Email</th>
                                                        <th title="Phone">Phone</th>
                                                        <th title="Address">Address</th>
                                                        <th title="Organisation">Organisation</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($customers as $customer)
                                                        {{ \Log::info($customer) }}
                                                        <tr>
                                                            <td>{{ $customer->user->name }}</td>
                                                            <td>{{ $customer->user->email }}</td>
                                                            <td>{{ $customer->user->phone }}</td>
                                                            <td>{{ $customer->user->address }}</td>
                                                            <td>{{ $customer->organisation->user->name }}</td>
                                                            <td>
                                                                @if ($customer->status == 'active')
                                                                    <span class="badge bg-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if (\Auth::user()->can('edit customer'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('employee/{{ $customer->id }}/edit')">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if ($customer->status == 'active')
                                                                    @if (\Auth::user()->can('deactivate customer'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('employee/{{ $customer->id }}/deactivate')"
                                                                            title="Dectivate Employee">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if (\Auth::user()->can('activate customer'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('employee/{{ $customer->id }}/activate')"
                                                                            title="Activate Employee">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (\Auth::user()->can('delete customer'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('employee/{{ $customer->id }}/delete')"
                                                                        title="Delete Customer">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
        </div>

        {{-- Add Employee Modal --}}

        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('employee.create') }}" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Employee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group row my-3">
                                    <label for="name" class="col-sm-4 col-form-label">
                                        Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="phone" class="col-sm-4 col-form-label">
                                        Phone
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="phone" class="form-control" type="text" placeholder="Phone"
                                            id="phone" required value="{{ old('phone') }}" />
                                    </div>
                                </div>

                                @if (\Auth::user()->role == 'admin')
                                    <div class="form-group row my-3">
                                        <label for="organisation" class="col-sm-4 col-form-label">
                                            Organisation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="organisation" id="organisation" class="form-control" required>
                                                <option value="">Select Organisation</option>
                                                @foreach ($organisations as $organisation)
                                                    <option value="{{ $organisation->organisation_code }}">
                                                        {{ $organisation->user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row my-3">
                                        <label for="organisation" class="col-sm-4 col-form-label">
                                            Organisation
                                            <i class="text-danger">*</i>
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="organisation" id="organisation" class="form-control" required
                                                readonly>
                                                @php
                                                    $organisation = $organisations
                                                        ->where('user_id', Auth::user()->id)
                                                        ->first();
                                                @endphp
                                                <option selected readonly value="{{ $organisation->organisation_code }}">
                                                    {{ $organisation->user->name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row my-3">
                                    <label for="front_page_id" class="col-sm-4 col-form-label">
                                        Front Page ID Picture
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="front_page_id" class="form-control" type="file"
                                            placeholder="Front Page ID Picture" id="front_page_id"
                                            value="{{ old('front_page_id') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="avatar" class="col-sm-4 col-form-label">
                                        Avatar
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="avatar" class="form-control" type="file" placeholder="Avatar"
                                            id="avatar" value="{{ old('avatar') }}" />
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group row my-3">
                                    <label for="email" class="col-sm-4 col-form-label">
                                        Email
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="email" class="form-control" type="email" placeholder="Email"
                                            id="email" required value="{{ old('email') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="address" class="col-sm-4 col-form-label">
                                        Address
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            id="address" required value="{{ old('address') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="national_id" class="col-sm-4 col-form-label">
                                        ID number
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="national_id" class="form-control" type="text"
                                            placeholder="National ID number" id="national_id" required
                                            value="{{ old('national_id') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="back_page_id" class="col-sm-4 col-form-label">
                                        Back Page ID Picture
                                    </label>
                                    <div class="col-sm-8">
                                        <input name="back_page_id" class="form-control" type="file"
                                            placeholder="Back Page ID Picture" id="back_page_id"
                                            value="{{ old('back_page_id') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-3">
                                    <label for="password" class="col-sm-4 col-form-label">
                                        Password
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-8 position-relative">
                                        <input name="password" class="form-control" type="password"
                                            placeholder="Password" id="password" readonly required />
                                        <div class="generate-btn-container" onclick="generatePassword()">
                                            <span class="input-group-text generate-btn"
                                                style="font-size: smaller;">Generate</span>
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


        <!-- Delete Modal -->
        <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form"
                            method="POST">
                            @csrf
                            <div class="modal-body">
                                <p>Are you sure you want to delete this employee? This action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            function deleteCustomer(customerId) {
                // Set the delete form action dynamically
                var form = document.getElementById('delete-modal-form');
                form.action = '/employee/' + customerId + '/delete';

                // Open the delete modal
                var modal = new bootstrap.Modal(document.getElementById('delete-modal'));
                modal.show();
            }

            function confirmDelete() {
                // Submit the delete form
                var form = document.getElementById('delete-modal-form');
                form.submit();
            }

            function generatePassword() {
                var length = 12,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]:;?><,./-=",
                    password = "";
                for (var i = 0, n = charset.length; i < length; ++i) {
                    password += charset.charAt(Math.floor(Math.random() * n));
                }
                document.getElementById("password").value = password;
            }
        </script>

    </body>

@endsection
