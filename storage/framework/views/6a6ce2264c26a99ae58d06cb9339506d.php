<?php $__env->startSection('title', 'Scheduled Trips'); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('components.preloader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div id="app">
        <div class="wrapper">
            <?php echo $__env->make('components.sidebar.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="content-wrapper">
                <div class="main-content">
                    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="body-content">
                        <div class="tile">
                            <div class="mb-4 card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 fs-17 fw-semi-bold">Scheduled Trips</h6>
                                        </div>
                                        <div class="text-end">
                                            <div class="actions">
                                                <div class="accordion-header d-flex justify-content-end align-items-center"
                                                    id="flush-headingOne">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('schedule trip')): ?>
                                                        <a class="btn btn-success btn-sm" href="javascript:void(0);"
                                                            onclick="axiosModal('/trip/create')">
                                                            <i class="fa fa-plus"></i>&nbsp; Schedule A Trip
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div>
                                        <div class="table-responsive">
                                            <table class="table">
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
                                                        <th class="text-center" title="Assign" width="150">Assign</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $__currentLoopData = $scheduledTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($trip->customer->user->name); ?></td>
                                                            <td>
                                                                <?php
                                                                    $companyName =
                                                                        optional($trip->customer->organisation->user)
                                                                            ->name ?? 'TBD';
                                                                ?>
                                                                <?php echo e($companyName); ?>

                                                            </td>
                                                            <td>
                                                                <?php if($trip->driver): ?>
                                                                    <?php echo e($trip->driver->user->name); ?>

                                                                <?php else: ?>
                                                                    <span class="btn btn-warning btn-sm">TBD</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if($trip->vehicle): ?>
                                                                    <?php echo e($trip->vehicle->plate_number); ?>

                                                                <?php else: ?>
                                                                    <span class="btn btn-warning btn-sm">TBD</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?php echo e($trip->route->name); ?></td>
                                                            <td><?php echo e($trip->pick_up_time); ?></td>
                                                            <td><?php echo e($trip->trip_date); ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                    $location =
                                                                        $trip->pick_up_location === 'Home'
                                                                            ? $trip->customer->user->address
                                                                            : ($trip->pick_up_location === 'Office'
                                                                                ? $trip->customer->organisation->user
                                                                                    ->address
                                                                                : $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->pick_up_location,
                                                                                    )
                                                                                    ->first()->name);
                                                                ?>
                                                                <?php echo e($location); ?>

                                                            </td>
                                                            <td class="text-center">
                                                                <?php
                                                                    $location =
                                                                        $trip->drop_off_location === 'Home'
                                                                            ? $trip->customer->user->address
                                                                            : ($trip->drop_off_location === 'Office'
                                                                                ? $trip->customer->organisation->user
                                                                                    ->address
                                                                                : $trip->route->route_locations
                                                                                    ->where(
                                                                                        'id',
                                                                                        $trip->drop_off_location,
                                                                                    )
                                                                                    ->first()->name);
                                                                ?>
                                                                <?php echo e($location); ?>

                                                            </td>
                                                            <td class="text-center">
                                                                <input class="form-check-input trip-checkbox"
                                                                    type="checkbox" role="switch" id="<?php echo e($trip->id); ?>"
                                                                    name="trip_ids[]" value="<?php echo e($trip->id); ?>">
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <td colspan="9"></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" id="assign-driver"
                                                                type="button">Assign Vehicle</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="overlay"></div>
                    </div>
                </div>
                <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="assign-driver-modal" data-bs-keyboard="false" tabindex="-1" data-bs-backdrop="true"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" action="<?php echo e(route('trip.scheduled')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
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
                                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($vehicle->id); ?>">
                                        <?php echo e($vehicle->make . ' ' . $vehicle->model); ?> - Seats: <?php echo e($vehicle->seats); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="mt-3 font-black text-danger">The selected vehicle has the following scheduled trips
                            </div>
                            <div id="scheduled-trips-div"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" id="confirm-assign">Assign</button>
                    </div>
                </form>

            </div>
        </div>

        <script>
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
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/chris-droid/Desktop/metro/metroberry-apis-v1.1.0/resources/views/trips/scheduled.blade.php ENDPATH**/ ?>