<form action="{{ $trip->id }}/bill" method="POST" class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Bill Trip</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="customer" class="col-sm-5 col-form-label">
                        Customer
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="customer" readonly class="form-control" type="text" placeholder="Customer"
                            id="customer" value="{{ $trip->customer->user->name }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="pick_up_time" class="col-sm-5 col-form-label">
                        Pick up Time
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="pick_up_time" readonly class="form-control" type="text"
                            placeholder="Pick Up Time" id="pick_up_time" value="{{ $trip->pick_up_time }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="vehicle_mileage" class="col-sm-5 col-form-label">
                        Vehicle Mileage (KM)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="vehicle_mileage" readonly class="form-control" type="number"
                            placeholder="Vehicle Mileage" id="vehicle_mileage" value="{{ $trip->vehicle_mileage }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="engine_hours" class="col-sm-5 col-form-label">
                        Engine Hours (Hrs)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="engine_hours" readonly class="form-control" type="number"
                            placeholder="Engine Hours" id="engine_hours" value="{{ $trip->engine_hours }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="billing_rate_id" class="col-sm-5 col-form-label">
                        Billing Rate
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="billing_rate_id" class="form-control" id="billing_rate_id">
                            @foreach ($billingRates as $rate)
                                <option value="{{ $rate->id }}"
                                    {{ $trip->billing_rate_id == $rate->id ? 'selected' : '' }}>
                                    {{ $rate->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group row my-2">
                    <label for="bill_by" class="col-sm-5 col-form-label">
                        Bill By
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_by" id="bill_by_distance"
                                value="distance">
                            <label class="form-check-label" for="bill_by_distance">
                                Distance
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_by" id="bill_by_car_class"
                                value="car_class">
                            <label class="form-check-label" for="bill_by_car_class">
                                Car Class
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="bill_by" id="bill_by_time"
                                value="time">
                            <label class="form-check-label" for="bill_by_time">
                                Time
                            </label>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="national_id_no" class="col-sm-5 col-form-label">
                        Customer ID
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="national_id_no" readonly class="form-control" type="text"
                            placeholder="Customer ID" id="national_id_no"
                            value="{{ $trip->customer->national_id_no }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="drop_off_time" class="col-sm-5 col-form-label">
                        Drop Off Time
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="drop_off_time" readonly class="form-control" type="text"
                            placeholder="Drop Off Time" id="drop_off_time" value="{{ $trip->drop_off_time }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="fuel_consumed" class="col-sm-5 col-form-label">
                        Fuel Consumed (L)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="fuel_consumed" readonly class="form-control" type="number"
                            placeholder="Fuel Consumed" id="fuel_consumed" value="{{ $trip->fuel_consumed }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="idle_time" class="col-sm-5 col-form-label">
                        Idle Time (Hrs)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="idle_time" readonly class="form-control" type="number" placeholder="Idle Time"
                            id="idle_time" value="{{ $trip->idle_time }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="rate_per_km" class="col-sm-5 col-form-label">
                        Rate Per KM
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="rate_per_km" class="form-control" type="number" placeholder="Rate Per KM"
                            id="rate_per_km" value="{{ old('rate_per_km') }}" readonly>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="rate_per_minute" class="col-sm-5 col-form-label">
                        Rate Per Minute
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="rate_per_minute" class="form-control" type="number"
                            placeholder="Rate Per Minute" id="rate_per_minute" value="{{ old('rate_per_minute') }}"
                            readonly>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="rate_by_car_class" class="col-sm-5 col-form-label">
                        Rate By Car Class
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="rate_by_car_class" class="form-control" type="number"
                            placeholder="Rate By Car Class" id="rate_by_car_class"
                            value="{{ old('rate_by_car_class') }}" readonly>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="total" class="col-sm-5 col-form-label">
                        Total
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="total" class="form-control" type="number" placeholder="Total Price"
                            id="total" value="" readonly>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        // Function to fetch and populate rates based on billing rate ID
        function populateRates(billingRateId) {
            if (billingRateId) {
                $.ajax({
                    url: '/get-billing-rate/' +
                        billingRateId, // Replace with your endpoint to fetch rates
                    type: 'GET',
                    success: function(data) {
                        $('#rate_per_km').val(data.rate_per_km);
                        $('#rate_per_minute').val(data.rate_per_minute);

                        // Parse rate_by_car_class JSON string to an object
                        var rateByCarClass = JSON.parse(data.rate_by_car_class);

                        // Retrieve vehicle class from trip data
                        var vehicleClass =
                            "{{ $trip->vehicle->class }}"; // Replace with actual PHP blade syntax to fetch vehicle class

                        // Set rate_by_car_class based on vehicle class
                        if (rateByCarClass[vehicleClass]) {
                            $('#rate_by_car_class').val(rateByCarClass[vehicleClass]);
                        } else {
                            // Handle case where rate for vehicle class is not found
                            $('#rate_by_car_class').val('');
                            console.error('Rate for vehicle class ' + vehicleClass + ' not found.');
                        }

                        // Recalculate total after rates are populated
                        calculateTotal();
                    },
                    error: function(xhr, status, error) {
                        // Handle error scenario
                        console.error('Failed to fetch billing rates: ' + error);
                    }
                });
            } else {
                $('#rate_per_km').val('');
                $('#rate_per_minute').val('');
                $('#rate_by_car_class').val('');
                calculateTotal(); // Recalculate total even if rates are cleared
            }
        }

        // Trigger populateRates function on billing rate change
        $('#billing_rate_id').change(function() {
            var billingRateId = $(this).val();
            populateRates(billingRateId);
        });

        // Function to calculate total price based on billing method
        function calculateTotal() {
            console.log("Calculating total...");
            var billBy = $('input[name="bill_by"]:checked').val();
            console.log("Billing Method:", billBy);
            var total = 0;
            var ratePerKm = parseFloat($('#rate_per_km').val()) || 0;
            console.log("Rate per Km:", ratePerKm);
            var ratePerMinute = parseFloat($('#rate_per_minute').val()) || 0;
            console.log("Rate per Minute:", ratePerMinute);
            var rateByCarClass = parseFloat($('#rate_by_car_class').val()) || 0;
            console.log("Rate by Car Class:", rateByCarClass);
            var distance = parseFloat($('#vehicle_mileage').val()) || 0;
            console.log("Distance:", distance);

            var pickUpTimeStr = $('#pick_up_time').val(); // Get the pick-up time as a string
            var dropOffTimeStr = $('#drop_off_time').val(); // Get the drop-off time as a string

            // Split the time strings into components
            var pickUpTimeParts = pickUpTimeStr.split(':');
            var dropOffTimeParts = dropOffTimeStr.split(':');

            // Create Date objects for the pick-up and drop-off times
            var pickUpTime = new Date();
            pickUpTime.setHours(parseInt(pickUpTimeParts[0]), parseInt(pickUpTimeParts[1]), parseInt(
                pickUpTimeParts[2]), 0);

            var dropOffTime = new Date();
            dropOffTime.setHours(parseInt(dropOffTimeParts[0]), parseInt(dropOffTimeParts[1]), parseInt(
                dropOffTimeParts[2]), 0);

            // Calculate the difference in milliseconds
            var diffMilliseconds = dropOffTime - pickUpTime;

            // Convert milliseconds to hours
            var timeDifference = diffMilliseconds / (1000 * 60 * 60);

            console.log("Pick Up Time:", pickUpTimeStr);
            console.log("Drop Off Time:", dropOffTimeStr);
            console.log("Difference (Milliseconds):", diffMilliseconds);
            console.log("Time Difference (Hrs):", timeDifference.toFixed(2));

            switch (billBy) {
                case 'distance':
                    total = ratePerKm * distance;
                    break;
                case 'car_class':
                    total = rateByCarClass;
                    break;
                case 'time':
                    total = ratePerMinute * (timeDifference * 60);
                    break;
                default:
                    total = 0;
                    break;
            }

            console.log("Total:", total);
            // Update the total input field
            $('#total').val(total.toFixed(2));
        }

        // Bind calculateTotal function to radio button change events
        $('input[name="bill_by"]').change(function() {
            calculateTotal();
        });

        // Bind calculateTotal function to input field change events (in case mileage or hours change)
        $('#vehicle_mileage').on('input', function() {
            calculateTotal();
        });

        // Populate rates initially if billing rate is pre-selected
        var initialBillingRateId = $('#billing_rate_id').val();
        populateRates(initialBillingRateId);

        // Calculate initial total based on default billing method (if any)
        calculateTotal();
    });
</script>
