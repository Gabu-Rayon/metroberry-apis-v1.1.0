@extends('layouts.app')

@section('title', 'Route Locations')
@section('content')

    @include('components.preloader')

    <!-- React page -->
    <div id="app">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- Start sidebar -->
            @include('components.sidebar.sidebar')
            <!-- End sidebar -->

            <div class="content-wrapper">
                <div class="main-content">
                    @include('components.navbar')

                    <div class="body-content">
                        <div class="tile">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fs-17 fw-semi-bold mb-0">Route Locations</h6>
                                        <div class="text-end">
                                            <div class="actions">
                                                @if (Auth::user()->can('export route locations'))
                                                    <a class="btn btn-success btn-sm"
                                                        href={{ route('route.location.export') }} title="Export">
                                                        <i class="fa-solid fa-file-export"></i>&nbsp;
                                                        Export
                                                    </a>
                                                @endif
                                                <span class='m-1'></span>
                                                @if (Auth::user()->can('import route locations'))
                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('route.location.import') }}"
                                                        title="Import From csv excel file">
                                                        <i class="fa-solid fa-file-arrow-up"></i>&nbsp;
                                                        Import
                                                    </a>
                                                @endif
                                                <span class="m-1"></span>
                                                @if (Auth::user()->can('create route location'))
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#routeLocationsModal">
                                                        <i class="fa-solid fa-user-plus"></i>
                                                        &nbsp;
                                                        Add Route Location
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table" id="driver-table">
                                            <thead>
                                                <tr>
                                                    <th title="Route">Route</th>
                                                    <th title="Name">Name</th>
                                                    <th title="Point Order">Point Order</th>
                                                    @if (Auth::user()->role = 'admin')
                                                        <th title="Action" width="80">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($routelocations as $routelocation)
                                                    <tr>
                                                        <td>{{ $routelocation->route->name }}</td>
                                                        <td>{{ $routelocation->name }}</td>
                                                        <td class="text-center">
                                                            @php
                                                                if ($routelocation->is_start_location) {
                                                                    $point_order = 'Start Location';
                                                                } elseif ($routelocation->is_end_location) {
                                                                    $point_order = 'End Location';
                                                                } else {
                                                                    $point_order = $routelocation->point_order;
                                                                }
                                                            @endphp
                                                            <span>{{ $point_order }}</span>
                                                        </td>
                                                        @if (Auth::user()->role = 'admin')
                                                            <td class="d-flex">
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary"
                                                                    onclick="axiosModal('location/{{ $routelocation->id }}/edit')">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <span class='m-1'></span>
                                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                                    onclick="axiosModal('location/{{ $routelocation->id }}/delete')">
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
            </div>
            <div class="overlay"></div>
        </div>
        <!-- End page wrapper -->

        <div class="modal fade" id="routeLocationsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('route.location.store') }}" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Route location</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="route" class="col-sm-5 col-form-label">
                                        Route
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="route" id="route" class="form-control" required>
                                            <option value="">Select Route</option>
                                            @foreach ($routes as $route)
                                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="type" class="col-sm-5 col-form-label">
                                        Type
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type"
                                                id="start-location" value="start_location" required>
                                            <label class="form-check-label" for="start-location">
                                                Start Location
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="end-location"
                                                value="end_location" required>
                                            <label class="form-check-label" for="end-location">
                                                End Location
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="waypoint"
                                                value="waypoint" required>
                                            <label class="form-check-label" for="waypoint">
                                                Waypoint
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="name" class="col-sm-5 col-form-label">
                                        Name
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="point_order" class="col-sm-5 col-form-label">
                                        Point Order
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="point_order" class="form-control" type="number"
                                            placeholder="Point Order" id="point_order" disabled
                                            value="{{ old('point_order') }}" />
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

                <script>
                    const pointOrder = document.getElementById('point_order');
                    const routeLocationType = document.querySelectorAll('input[name="type"]');

                    routeLocationType.forEach((type) => {
                        type.addEventListener('change', (e) => {
                            if (e.target.value === 'waypoint') {
                                pointOrder.removeAttribute('disabled');
                            } else {
                                pointOrder.setAttribute('disabled', 'disabled');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
