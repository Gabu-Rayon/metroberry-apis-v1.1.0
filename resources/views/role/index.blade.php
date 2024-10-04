@extends('layouts.app')

@section('title', 'Roles')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Roles</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <a class="btn btn-success btn-sm" href="/admin/role/create">
                                                        <i class="fa fa-plus-circle"></i>&nbsp;
                                                        Add Role
                                                    </a>
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
                                                            <th title="Name">Name</th>
                                                            <th title="Guard">Guard</th>
                                                            <th title="Updated">Updated</th>
                                                            <th title="Action" width="80">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($roles as $role)
                                                            <tr>
                                                                <td>{{ $role->name }}</td>
                                                                <td>{{ $role->guard_name }}</td>
                                                                <td>{{ $role->updated_at }}</td>
                                                                <td>
                                                                    <div class="d-flex gap-2">
                                                                        @if (\Auth::user()->can('edit role'))
                                                                            <a href="javascript:void(0);"
                                                                                onclick="axiosModal('role/{{ $role->id }}/edit')"
                                                                                class="btn btn-primary btn-sm">
                                                                                <i class="fa fa-edit fa-sm"></i>
                                                                            </a>
                                                                        @endif
                                                                        @if (\Auth::user()->can('delete role'))
                                                                            <a href="javascript:void(0);"
                                                                                onclick="axiosModal('role/{{ $role->id }}/delete')"
                                                                                class="btn btn-danger btn-sm">
                                                                                <i class="fa fa-trash fa-sm"></i>
                                                                            </a>
                                                                        @endif
                                                                        @if (\Auth::user()->can('assign permission'))
                                                                            <a href="javascript:void(0);"
                                                                                onclick="axiosModal('role/{{ $role->id }}/permissions')"
                                                                                class="btn btn-info btn-sm">
                                                                                <i class="fa fa-key fa-sm"></i>
                                                                            </a>
                                                                        @endif
                                                                    </div>
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
                    </div>
                    <div class="overlay"></div>
                    @include('components.sidebar.sidebar')
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
