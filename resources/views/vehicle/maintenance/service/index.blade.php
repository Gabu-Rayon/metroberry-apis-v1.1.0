@extends('layouts.app')

@section('title', 'Service Types')
@section('content')

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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Service Types</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#serviceTypeModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                            Add Service Type
                                                        </button>
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
                                                        <th title="Email">Description</th>
                                                        <th title="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($serviceTypes as $serviceType)
                                                        <tr>
                                                            <td>{{ $serviceType->name }}</td>
                                                            <td>{{ $serviceType->description }}</td>
                                                            <td>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('service/{{ $serviceType->id }}/edit')"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('service/{{ $serviceType->id }}/delete')"
                                                                    class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
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

        <div class="modal fade" id="serviceTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('vehicle.maintenance.service.create') }}" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Service Type</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="name" class="col-sm-5 col-form-label">
                                        Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="{{ old('name') }}">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="description" class="col-sm-5 col-form-label">
                                        Description
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="description" class="form-control" placeholder="Description" id="description" required rows="5">{{ old('description') }}</textarea>
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

    </body>

@endsection
