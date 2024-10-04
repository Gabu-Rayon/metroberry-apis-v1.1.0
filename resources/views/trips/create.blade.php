<head>
    <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
</head>

<form action="{{ route('trip.store') }}" method="POST"
    class="needs-validation modal-content"enctype="multipart/form-data">
    @csrf
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Schedule A Trip</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="customer_id" class="col-sm-5 col-form-label">Employee <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select name="customer_id" class="form-control" id="customer_id" required>
                            <option value="" disabled>Select Employee</option>
                            @foreach ($employees as $employeeData)
                                <option value="{{ $employeeData->id }}">{{ $employeeData->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="preferred_route_id" class="col-sm-5 col-form-label">Route <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select name="preferred_route_id" class="form-control preferred_route_id"
                            id="preferred_route_id" data-url="{{ route('route.location.waypoints') }}" required>
                            <option value="" readonly>Select Route</option>
                            @foreach ($routes as $routeData)
                                <option value="{{ $routeData->id }}">{{ $routeData->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="pickup_time" class="col-sm-5 col-form-label">Pickup Time <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="pickup_time" class="form-control" type="time" id="pickup_time"
                            value="{{ old('pickup_time') }}" required>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="pick_up_location" class="col-sm-5 col-form-label">PickUp Location <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <select name="pick_up_location" class="form-control" id="pick_up_location" required>
                            <option value="" readonly>Select Location</option>
                            <option value="Home">Home</option>
                            <option value="Office">Office</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="drop_off_location" class="col-sm-5 col-form-label">
                        Drop Off Location
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="drop_off_location" class="form-control select2" id="drop_off_location" required>
                            <option value="" readonly>Select Your preference Drop Off Location</option>
                            <option value="Home">Home</option>
                            <option value="Office">Office</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="trip_date" class="col-sm-5 col-form-label">
                        Trip Date
                        <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="trip_date" class="form-control" type="date" id="trip_date" required
                            value="{{ old('trip_date') }}">
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

<script>
    $(document).ready(function() {
        var pickUpLocationSelect = $('#pick_up_location');
        var dropOffLocationSelect = $('#drop_off_location');
        var preferredRouteSelect = $('.preferred_route_id');

        // Function to disable the same option in another select
        function disableSameOption(select1, select2) {
            $(select1).on('change', function() {
                var selectedValue = $(this).val();
                $(select2).find('option').each(function() {
                    if ($(this).val() === selectedValue) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });
            });
            $(select1).trigger('change'); // Trigger change event to initialize
        }

        disableSameOption(pickUpLocationSelect, dropOffLocationSelect);
        disableSameOption(dropOffLocationSelect, pickUpLocationSelect);

        // Function to populate locations based on selected route
        function populateLocations(routeId) {
            var url = preferredRouteSelect.data('url');
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Retrieve CSRF token

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Set CSRF token in request header
                },
                data: {
                    route_id: routeId
                },
                success: function(data) {
                    dropOffLocationSelect.empty();
                    pickUpLocationSelect.empty();

                    dropOffLocationSelect.append(
                        '<option value="">Select Your preference Drop Off Location</option>');
                    pickUpLocationSelect.append('<option value="">Select Location</option>');

                    // Assuming data is an array of objects with id, name, and point_order properties
                    data.sort(function(a, b) {
                        return a.point_order - b.point_order;
                    });

                    $.each(data, function(key, location) {
                        dropOffLocationSelect.append('<option value="' + location.id +
                            '">' + location.name + '</option>');
                        pickUpLocationSelect.append('<option value="' + location.id + '">' +
                            location.name + '</option>');
                    });

                    // Add static options after dynamic ones
                    dropOffLocationSelect.append('<option value="Home">Home</option>');
                    dropOffLocationSelect.append('<option value="Office">Office</option>');
                    pickUpLocationSelect.append('<option value="Home">Home</option>');
                    pickUpLocationSelect.append('<option value="Office">Office</option>');

                    // Re-enable/disable options based on current selections
                    disableSameOption(pickUpLocationSelect, dropOffLocationSelect);
                    disableSameOption(dropOffLocationSelect, pickUpLocationSelect);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert(
                        'An error occurred while fetching locations.'
                    ); // Provide feedback to the user
                }
            });
        }

        preferredRouteSelect.on('change', function() {
            var preferredRouteId = $(this).val();
            populateLocations(preferredRouteId);
        });

        // Check initial value and trigger AJAX if route is already selected
        var initialRouteId = preferredRouteSelect.val();
        if (initialRouteId) {
            populateLocations(initialRouteId);
        }
    });
</script>
