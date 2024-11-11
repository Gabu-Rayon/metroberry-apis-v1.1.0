@extends('layouts.app')

@section('title', 'Scheduled Trips')
@section('content')

    @include('components.preloader')

    <div id="app">
        <div class="wrapper">
            @include('components.sidebar.sidebar')

            <div class="content-wrapper">
                <div class="main-content">
                    @include('components.navbar')

                    <div class="body-content">
                        <div class="tile">
                            <div class="mb-4 card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fs-17 fw-semi-bold">
                                            <a href="{{ route('trip.scheduled') }}">Scheduled Trips</a>
                                        </h6>

                                        @can('schedule trip')
                                            <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                onclick="axiosModal('/trip/create')">
                                                <i class="fa fa-plus"></i>&nbsp; Schedule A Trip
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Trip Filter Form -->
                        <form action="{{ route('trip.scheduled.filter') }}" method="POST">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-6 col-sm-3">
                                        <input type="time" id="filter-time" name="filter_time" class="form-control"
                                            placeholder="Filter by Time">
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <input type="date" id="filter-date" name="filter_date" class="form-control"
                                            placeholder="Filter by Date">
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <select id="filter-route" name="filter_route" class="form-control">
                                            <option value="">Select Route</option>
                                            @foreach ($givenRoutes as $route)
                                                <option value="{{ $route->id }}">{{ $route->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <select name="filter_route_location_for_pickup"
                                            id="filter-route-location-for-pickup" class="form-control" disabled>
                                            <option value="">Select Pickup Location</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-sm-3 p-2">
                                        <button class="btn btn-primary" type="submit"
                                            id="trip-scheduled-filter">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Trip Table -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="driver-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" title="Customer">Customer</th>
                                            <th class="text-center" title="Company">Company</th>
                                            <th class="text-center" title="Driver">Driver</th>
                                            <th class="text-center" title="Vehicle">Vehicle</th>
                                            <th class="text-center" title="Route">Route</th>
                                            <th class="text-center" title="Time">Time</th>
                                            <th class="text-center" title="Date">Date</th>
                                            <th class="text-center" title="Pick Up">Pick Up</th>
                                            <th class="text-center" title="Drop Off">Drop Off</th>

                                            <!-- Conditionally display "Assign" column if filteredTrips are present -->
                                            @if (isset($filteredTrips) && $filteredTrips->isNotEmpty())
                                                <th class="text-center" title="Assign" width="150">Assign</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="scheduledTripsContainer">
                                        {{-- Check if filteredTrips exist, else fallback to scheduledTrips --}}
                                        @foreach ($filteredTrips ?? $scheduledTrips as $trip)
                                            <tr>
                                                <td>{{ $trip->customer->user->name }}</td>
                                                <td>
                                                    @php
                                                        $companyName =
                                                            optional($trip->customer->organisation->user)->name ??
                                                            'TBD';
                                                    @endphp
                                                    {{ $companyName }}
                                                </td>
                                                <td>
                                                    @if ($trip->driver)
                                                        {{ $trip->driver->user->name }}
                                                    @else
                                                        <span class="btn btn-warning btn-sm">TBD</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($trip->vehicle)
                                                        {{ $trip->vehicle->plate_number }}
                                                    @else
                                                        <span class="btn btn-warning btn-sm">TBD</span>
                                                    @endif
                                                </td>
                                                <td>{{ $trip->route->name }}</td>
                                                <td>{{ $trip->pick_up_time }}</td>
                                                <td>{{ $trip->trip_date }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $location =
                                                            $trip->pick_up_location === 'Home'
                                                                ? $trip->customer->user->address
                                                                : ($trip->pick_up_location === 'Office'
                                                                    ? $trip->customer->organisation->user->address
                                                                    : $trip->route->route_locations
                                                                        ->where('id', $trip->pick_up_location)
                                                                        ->first()->name);
                                                    @endphp
                                                    {{ $location }}
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $location =
                                                            $trip->drop_off_location === 'Home'
                                                                ? $trip->customer->user->address
                                                                : ($trip->drop_off_location === 'Office'
                                                                    ? $trip->customer->organisation->user->address
                                                                    : $trip->route->route_locations
                                                                        ->where('id', $trip->drop_off_location)
                                                                        ->first()->name);
                                                    @endphp
                                                    {{ $location }}
                                                </td>

                                                <!-- Conditionally display "Assign" checkbox if filteredTrips are present -->
                                                @if (isset($filteredTrips) && $filteredTrips->isNotEmpty())
                                                    <td class="text-center">
                                                        <input class="form-check-input trip-checkbox" type="checkbox"
                                                            role="switch" id="{{ $trip->id }}" name="trip_ids[]"
                                                            value="{{ $trip->id }}">
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9"></td>
                                            <!-- Conditionally display the button only if filteredTrips are present -->
                                            @if (isset($filteredTrips) && $filteredTrips->isNotEmpty())
                                                <td>
                                                    <button class="btn btn-sm btn-success" id="assign-driver"
                                                        type="button">Assign Vehicle</button>
                                                </td>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                @include('components.footer')
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="assign-driver-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" action="{{ route('trip.scheduled') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Driver</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Selected Trips:</h6>
                        <div id="selected-trips-list" class="row">
                            <!-- Selected trips will be dynamically added here -->
                        </div>
                        <input type="hidden" name="trip_ids" id="trip_ids" value="">
                        <div class="mt-4 row">
                            <label for="vehicle">Vehicles</label>
                            <select name="vehicle" id="vehicle" class="form-control" required>
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">
                                        {{ $vehicle->make . ' ' . $vehicle->model }} - Seats: {{ $vehicle->seats }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-3 font-black text-danger">The selected vehicle has the following scheduled
                                trips
                            </div>
                            <div id="scheduled-trips-div"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('trip.scheduled') }}" type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">Close</a>
                        <button class="btn btn-primary" type="submit" id="confirm-assign">Assign</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- JavaScript Section -->
    <script>
        ///Javascript  to filter the route 
        document.getElementById('filter-route').addEventListener('change', function() {
            const routeId = this.value;
            const locationSelect = document.getElementById('filter-route-location-for-pickup');

            // Reset the dropdown and disable it initially
            locationSelect.disabled = true;
            locationSelect.innerHTML = '<option value="">Select Pickup Location</option>';

            if (routeId) {
                // Fetch route locations based on selected routeId
                fetch(`/trip/route-locations?route_id=${routeId}`)
                    .then(response => response.json())
                    .then(routeLocations => {
                        routeLocations.forEach(location => {
                            const option = document.createElement('option');
                            option.value = location.id;
                            option.textContent = location.name;
                            locationSelect.appendChild(option);
                        });
                        locationSelect.disabled = false; // Enable dropdown after loading locations
                    })
                    .catch(error => console.error('Error fetching route locations:', error));
            }
        });

        const selectedTrips = [];
        document.querySelectorAll('.trip-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const tripId = this.value;
                if (this.checked) {
                    selectedTrips.push(tripId);
                } else {
                    const index = selectedTrips.indexOf(tripId);
                    if (index > -1) selectedTrips.splice(index, 1);
                }
                document.getElementById('trip_ids').value = selectedTrips.join(',');
            });
        });

        document.getElementById('assign-driver').addEventListener('click', function() {
            if (selectedTrips.length === 0) {
                alert('Please Filter First the Trips to assign a vehicle.');
            } else {
                new bootstrap.Modal(document.getElementById('assign-driver-modal')).show();
            }
        });
        ///Javascript  to filter the route locations for the pick up 
        document.getElementById('filter-route-location-for-pickup').addEventListener('change', function() {
            const routeId = document.getElementById('filter-route').value;
            const initialPickupLocationId = this.value;
            const pickupTime = document.getElementById('filter-time').value;

            if (routeId && initialPickupLocationId && pickupTime) {
                fetch(
                        `/trip/filter?route_id=${routeId}&pickup_location=${initialPickupLocationId}&pickup_time=${pickupTime}`
                    )
                    .then(response => response.json())
                    .then(filteredTrips => {
                        renderFilteredTrips(filteredTrips);
                    })
                    .catch(error => console.error('Error fetching filtered trips:', error));
            }
        });

        function renderFilteredTrips(trips) {
            const tbody = document.querySelector('table tbody');
            tbody.innerHTML = ''; // Clear existing rows

            trips.forEach(trip => {
                const row = document.createElement('tr');

                // Construct HTML content for each row
                row.innerHTML = `
                <td>${trip.customer.user.name}</td>
                <td>${trip.companyName}</td>
                <td>${trip.driver ? trip.driver.user.name : 'TBD'}</td>
                <td>${trip.vehicle ? trip.vehicle.plate_number : 'TBD'}</td>
                <td>${trip.route.name}</td>
                <td>${trip.pick_up_time}</td>
                <td>${trip.trip_date}</td>
                <td>${trip.pick_up_location_name}</td>
                <td>${trip.drop_off_location_name}</td>
                <td>
                    <input class="form-check-input trip-checkbox" type="checkbox" value="${trip.id}">
                </td>
            `;
                tbody.appendChild(row);
            });
        }

        ///Javascript  to assgign driver and vehicle
        document.getElementById('assign-driver').addEventListener('click', function() {
            const selectedTrips = [];
            const checkboxes = document.querySelectorAll('.trip-checkbox:checked');

            checkboxes.forEach((checkbox) => {
                const tripId = checkbox.value;
                const tripRow = checkbox.closest('tr');
                const customerName = tripRow.cells[0].innerText;
                const companyName = tripRow.cells[1].innerText; // Added company name
                const driverName = tripRow.cells[2].innerText || 'TBD';
                const vehicleNumber = tripRow.cells[3].innerText || 'TBD';
                const routeName = tripRow.cells[4].innerText;
                const time = tripRow.cells[5].innerText;
                const date = tripRow.cells[6].innerText;
                const pickupLocation = tripRow.cells[7].innerText;
                const dropoffLocation = tripRow.cells[8].innerText;

                selectedTrips.push({
                    tripId,
                    customerName,
                    companyName,
                    driverName,
                    vehicleNumber,
                    routeName,
                    time,
                    date,
                    pickupLocation,
                    dropoffLocation,
                });
            });

            const tripsList = document.getElementById('selected-trips-list');
            tripsList.innerHTML = '';

            if (selectedTrips.length > 0) {
                // Create a string of selected trip IDs for the hidden input
                const tripIds = selectedTrips.map(trip => trip.tripId).join(',');
                document.getElementById('trip_ids').value =
                    tripIds; // Update the hidden input with selected trip IDs

                selectedTrips.forEach(trip => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('row');
                    listItem.innerHTML +=
                        `
                <div class="col-md-3">
                    <div class="pt-1 pb-1 form-group">
                        <div class="font-black">Customer</div>
                        <div class="form-control">
                            ${trip.customerName}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="font-black">Company</div>
                    <div class="pt-1 pb-1 form-group">
                        <div class="form-control">
                            ${trip.companyName}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="font-black">Pick Up</div>
                    <div class="pt-1 pb-1 form-group">
                        <div class="form-control">
                            ${trip.pickupLocation}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="font-black">To</div>
                    <div class="pt-1 pb-1 form-group">
                        <div class="form-control">
                            ${trip.dropoffLocation}
                        </div>
                    </div>
                </div>
                `;
                    tripsList.appendChild(listItem);
                });

                // Show the modal
                var assignDriverModal = new bootstrap.Modal(document.getElementById('assign-driver-modal'));
                assignDriverModal.show();
            } else {
                alert('Please select at least one trip to assign a driver.');
            }
        });


        const vehicleSelect = document.getElementById('vehicle');
        const scheduledTripsDiv = document.getElementById('scheduled-trips-div');
        vehicleSelect.addEventListener('click', e => {
            fetch(`/get-vehicle/${e.target.value}`)
                .then(response => response.json())
                .then(data => {
                    const {
                        assigned_trips
                    } = data;

                    scheduledTripsDiv.innerHTML = '';


                    if (assigned_trips.length > 0) {
                        assigned_trips.forEach(trip => {
                            const tripDiv = document.createElement('div');
                            tripDiv.classList.add('form-control');
                            console.log('TRIP');
                            console.log(trip);

                            tripDiv.innerHTML =
                                `
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="pt-1 pb-1 form-group">
                                                <div class="font-black text-muted">Customer</div>
                                                <div class="form-control" id="vehicle-trip-customer">${trip.customer.user.name}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="pt-1 pb-1 form-group">
                                                <div class="font-black text-muted">Company</div>
                                                <div class="form-control" id="vehicle-trip-company">${trip.customer.customer_organisation_code}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="pt-1 pb-1 form-group">
                                                <div class="font-black text-muted">From</div>
                                                <div class="form-control" id="vehicle-trip-from">${trip.pick_up_location_name}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="pt-1 pb-1 form-group">
                                                <div class="font-black text-muted">To</div>
                                                <div class="form-control" id="vehicle-trip-to">${trip.drop_off_location_name}</div>
                                            </div>
                                        </div>
                                    </div>
                                    `;
                            scheduledTripsDiv.appendChild(tripDiv);
                        });
                    } else {
                        scheduledTripsDiv.innerHTML = 'No scheduled trips for this vehicle';
                    }

                });
        })
    </script>

@endsection
