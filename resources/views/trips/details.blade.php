<form action="{{ $trip->id }}/details" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @php
        $billable = (bool) $trip->is_billable;
    @endphp
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Billing Details</h4>
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
                    <label for="driver" class="col-sm-5 col-form-label">
                        Driver
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="driver" readonly class="form-control" type="text" placeholder="Driver"
                            id="driver" value="{{ $trip->vehicle->driver->user->name }}" />
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
                        <input name="vehicle_mileage" {{ $trip->vehicle_mileage ? 'readonly' : '' }} required
                            class="form-control" type="number" placeholder="Vehicle Mileage" id="vehicle_mileage"
                            value="{{ $trip->vehicle_mileage ?? old('vehicle_mileage') }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="engine_hours" class="col-sm-5 col-form-label">
                        Engine Hours (Hrs)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="engine_hours" {{ $trip->engine_hours ? 'readonly' : '' }} required
                            class="form-control" type="number" placeholder="Engine Hours" id="engine_hours"
                            value="{{ $trip->engine_hours ?? old('engine_hours') }}" />
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
                    <label for="driving_license_no" class="col-sm-5 col-form-label">
                        Driver License
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="driving_license_no" readonly class="form-control" type="text"
                            placeholder="Driver License" id="driving_license_no"
                            value="{{ $trip->vehicle->driver->license->driving_license_no }}" />
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
                        <input name="fuel_consumed" {{ $trip->fuel_consumed ? 'readonly' : '' }} required
                            class="form-control" type="number" placeholder="Fuel Consumed" id="fuel_consumed"
                            value="{{ $trip->fuel_consumed ?? old('fuel_consumed') }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="idle_time" class="col-sm-5 col-form-label">
                        Idle Time (Hrs)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="idle_time" {{ $trip->idle_time ? 'readonly' : '' }} required
                            class="form-control" type="number" placeholder="Idle Time" id="idle_time"
                            value="{{ $trip->idle_time ?? old('idle_time') }}" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit" {{ $trip->is_billable ? 'disabled' : '' }}>
            Save
        </button>
    </div>
</form>
