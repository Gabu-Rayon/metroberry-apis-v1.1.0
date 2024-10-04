@extends('layouts.app')

@section('title', 'Routes')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Routes</h6>
                                            </div>
                                            <div class="text-end">
                                                @if (Auth::user()->can('export routes'))
                                                    <a class="btn btn-success btn-sm" href={{ route('route.export') }}
                                                        title="Export">
                                                        <i class="fa-solid fa-file-export"></i>
                                                        &nbsp;
                                                        Export
                                                    </a>
                                                @endif
                                                <span class='m-1'></span>
                                                @if (Auth::user()->can('import routes'))
                                                    <a class="btn btn-success btn-sm" href="{{ route('route.import') }}"
                                                        title="Import From csv excel file">
                                                        <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                    </a>
                                                @endif
                                                <span class="m-1"></span>
                                                @if (Auth::user()->can('create route'))
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#routeModal">
                                                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Route
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Name">Name</th>
                                                        <th title="Name">County</th>
                                                        <th title="Email">Start Location</th>
                                                        <th title="Address">Waypoints</th>
                                                        <th title="Phone">End Location</th>
                                                        @if (Auth::user()->role == 'admin')
                                                            <th title="Action" width="80">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($routes as $route)
                                                        <tr>
                                                            <td>{{ $route->name }}</td>
                                                            <td>{{ $route->county }}</td>
                                                            <td class="text-center">
                                                                {{ $route->start_location->name ?? '-' }}</td>
                                                            <td class="text-center">
                                                                @php
                                                                    $waypoints = $route->waypoints->sortBy(
                                                                        'point_order',
                                                                    );
                                                                @endphp
                                                                @foreach ($waypoints as $key => $waypoint)
                                                                    {{ $waypoint->name }}
                                                                    @if (!$loop->last)
                                                                        -
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td class="text-center">{{ $route->end_location->name ?? '-' }}
                                                            </td>
                                                            @if (Auth::user()->role == 'admin')
                                                                <td class="d-flex">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('route/{{ $route->id }}/edit')">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <span class='m-1'></span>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('route/{{ $route->id }}/delete')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            @endif
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

        <div class="modal fade" id="routeModal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('route.store') }}" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Route</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="start_location" class="col-sm-5 col-form-label">
                                        Start Location <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="start_location" class="form-control" type="text"
                                            placeholder="Start Location" id="start_location" required />
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="county" class="col-sm-5 col-form-label">
                                        County <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="county" class="form-control" type="text" placeholder="County"
                                            id="county" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="end_location" class="col-sm-5 col-form-label">
                                        End Location <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="end_location" class="form-control" type="text"
                                            placeholder="End Location" id="end_location" required />
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
                        <h5 class="modal-title">Delete Organisation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0);" class="needs-validation" id="delete-modal-form"
                            method="POST">
                            @csrf
                            <div class="modal-body">
                                <p>Are you sure you want to delete this organisation? This action cannot be undone.</p>
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


    </body>

@endsection
