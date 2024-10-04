@extends('layouts.app')

@section('title', 'Insurance Companies')
@section('content')
    <!-- Begin layout-wrapper -->
    <div class="fixed sidebar-mini">
        @include('components.preloader')

        <!-- React page -->
        <div id="app">
            <!-- Begin page -->
            <div class="wrapper">
                <!-- Start sidebar -->
                @include('components.sidebar.sidebar')
                <!-- End sidebar -->

                <!-- Content Wrapper -->
                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')

                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Insurance Companies</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#insCompanyModal">
                                                        <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                        Add Insurance Company
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Address</th>
                                                        <th>Email</th>
                                                        <th>Website</th>
                                                        <th>Status</th>
                                                        <th width="150">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($insuranceCompanies as $key => $company)
                                                        <tr>
                                                            <td>{{ $company->name }}</td>
                                                            <td>{{ $company->address }}</td>
                                                            <td>{{ $company->email }}</td>
                                                            <td>{{ $company->website }}</td>
                                                            <td>
                                                                @if ($company->status == 1)
                                                                    <span class="badge bg-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                @endif
                                                            </td>
                                                            <td class="d-flex">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                                                    onclick="axiosModal('/vehicle/insurance/company/{{ $company->id }}/edit')"
                                                                    title="Edit Insurance Company">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <span class="m-1"></span>
                                                                @if ($company->status == 1)
                                                                    @can('activate insurance company')
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('/vehicle/insurance/company/{{ $company->id }}/deactivate')"
                                                                            title="Deactivate Insurance Company">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endcan
                                                                @else
                                                                    @can('activate insurance company')
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('/vehicle/insurance/company/{{ $company->id }}/activate')"
                                                                            title="Activate Insurance Company">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endcan
                                                                @endif
                                                                <span class="m-1"></span>
                                                                @can('delete insurance company')
                                                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('/vehicle/insurance/company/{{ $company->id }}/delete')"
                                                                        title="Delete Insurance Company">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                @endcan
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
                    <div class="overlay"></div>
                    @include('components.footer')
                </div>
            </div>
            <!-- End page -->
        </div>
        <!-- End React page -->

        <!-- Add Insurance Company Modal -->
        <div class="modal fade" id="insCompanyModal" tabindex="-1" aria-labelledby="insCompanyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('vehicle.insurance.company.store') }}" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Insurance Company</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="name" class="col-sm-5 col-form-label">Company Name <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="name" class="form-control" type="text" placeholder="Company Name"
                                            id="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="email" class="col-sm-5 col-form-label">Email</label>
                                    <div class="col-sm-7">
                                        <input name="email" autocomplete="off" class="form-control" type="email"
                                            placeholder="Email" id="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="address" class="col-sm-5 col-form-label">Address</label>
                                    <div class="col-sm-7">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            id="address" value="{{ old('address') }}">
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="website" class="col-sm-5 col-form-label">Website</label>
                                    <div class="col-sm-7">
                                        <input name="website" class="form-control" type="text" placeholder="Website"
                                            id="website" value="{{ old('website') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form">
                            <p>Are you sure you want to delete this item? You won't be able to revert this action.</p>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-danger" type="submit" id="delete_submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modals -->

        <!-- Start scripts -->
    @endsection
