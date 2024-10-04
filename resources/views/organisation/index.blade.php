@extends('layouts.app')

@section('title', 'Organisations')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Organisations</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        @if (Auth::user()->can('export organisations'))
                                                            <a class="btn btn-success btn-sm"
                                                                href={{ route('organisation.export') }} title="Export">
                                                                <i class="fa-solid fa-file-export"></i>
                                                                &nbsp;
                                                                Export
                                                            </a>
                                                        @endif
                                                        <span class="m-1"></span>
                                                        @if (Auth::user()->can('import organisations'))
                                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                                onclick="axiosModal('{{ route('organisation.import.file') }}')"
                                                                title="Import From csv excel file">
                                                                <i class="fa-solid fa-file-arrow-up"></i>&nbsp; Import
                                                            </a>
                                                        @endif
                                                        <span class="m-1"></span>
                                                        @if (\Auth::user()->can('create organisation'))
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#organisationModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                                Add Organisation
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
                                                        <th title="Organisation">Code</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($organisations as $organisation)
                                                        <tr>
                                                            <td>{{ $organisation->user->name }}</td>
                                                            <td>{{ $organisation->user->email }}</td>
                                                            <td>{{ $organisation->user->phone }}</td>
                                                            <td>{{ $organisation->user->address }}</td>
                                                            <td>{{ $organisation->organisation_code }}</td>
                                                            <td>
                                                                @if ($organisation->status == 'active')
                                                                    <span class="badge bg-success">Active</span>
                                                                @else
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                @endif
                                                            </td>
                                                            <td class="d-flex">
                                                                @if (\Auth::user()->can('edit organisation'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('organisation/{{ $organisation->id }}/edit')">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if ($organisation->status == 'active')
                                                                    @if (\Auth::user()->can('deactivate organisation'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('organisation/{{ $organisation->id }}/deactivate')"
                                                                            title="Deactivate Organisation">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if (\Auth::user()->can('activate organisation'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('organisation/{{ $organisation->id }}/activate')"
                                                                            title="Activate Organisation">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (\Auth::user()->can('delete organisation'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="deleteOrganisation('{{ $organisation->id }}')">
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

        <!-- Organisation Modal -->
        <div class="modal fade" id="organisationModal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('organisation.create') }}" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add Organisation</h4>
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
                                            id="name" required value="{{ old('name') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="phone" class="col-sm-5 col-form-label">
                                        Phone
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="phone" class="form-control" type="text" placeholder="Phone"
                                            id="phone" required value="{{ old('phone') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="organisation_code" class="col-sm-5 col-form-label">
                                        Organisation Code
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="organisation_code" class="form-control" type="text"
                                            placeholder="Organisation Code" id="organisation_code"
                                            value="{{ old('organisation_code') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="logo" class="col-sm-5 col-form-label">
                                        Logo
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="logo" class="form-control" type="file" placeholder="Logo"
                                            id="logo" value="{{ old('logo') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="email" class="col-sm-5 col-form-label">
                                        Email
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="email" class="form-control" type="email" placeholder="Email"
                                            id="email" value="{{ old('email') }}" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="address" class="col-sm-5 col-form-label">
                                        Address
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="address" class="form-control" type="text" placeholder="Address"
                                            id="address" value="{{ old('address') }}" required />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="organisation_certificate" class="col-sm-5 col-form-label">
                                        Certificate of Organisation
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="organisation_certificate" class="form-control" type="file"
                                            placeholder="Certificate of Organisation" id="organisation_certificate"
                                            value="{{ old('organisation_certificate') }}" />
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Map Modal -->
        <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mapModalLabel">Select Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="map" style="height: 400px;"></div>
                        <div class="input-group mt-3">
                            <input id="location-search" class="form-control" type="text"
                                placeholder="Search for a location" />
                            <button class="btn btn-primary" onclick="saveLocation()">Save Location</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjAxAszIxcGy7sHQxpFh0c1EDs-3AO76Q&libraries=places" async
            defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const addressInput = document.getElementById("address");
                const mapModal = new bootstrap.Modal(document.getElementById("mapModal"));
                const mapElement = document.getElementById("map");

                addressInput.addEventListener("focus", function() {
                    mapModal.show();
                    initMap();
                });

                let map, marker;

                function initMap() {
                    map = new google.maps.Map(mapElement, {
                        zoom: 12,
                    });

                    marker = new google.maps.Marker({
                        map: map,
                    });

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const userLatLng = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };

                                map.setCenter(userLatLng);
                                marker.setPosition(userLatLng);

                                const searchBox = new google.maps.places.SearchBox(document.getElementById(
                                    'location-search'));
                                map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById(
                                    'location-search'));

                                searchBox.addListener('places_changed', function() {
                                    const places = searchBox.getPlaces();
                                    if (places.length === 0) {
                                        return;
                                    }

                                    marker.setMap(null);

                                    const bounds = new google.maps.LatLngBounds();
                                    places.forEach(function(place) {
                                        if (!place.geometry) {
                                            console.log("Returned place contains no geometry");
                                            return;
                                        }

                                        marker = new google.maps.Marker({
                                            map: map,
                                            position: place.geometry.location,
                                        });

                                        bounds.extend(place.geometry.location);
                                    });

                                    map.fitBounds(bounds);
                                });
                            },
                            function() {
                                handleLocationError(true, map.getCenter());
                            }
                        );
                    } else {
                        handleLocationError(false, map.getCenter());
                    }
                }

                function handleLocationError(browserHasGeolocation, pos) {
                    const infoWindow = new google.maps.InfoWindow({
                        map: map,
                    });
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(
                        browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.'
                    );
                }

                window.saveLocation = function() {
                    const position = marker.getPosition();
                    addressInput.value = `${position.lat()}, ${position.lng()}`;
                    mapModal.hide();
                }
            });

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
