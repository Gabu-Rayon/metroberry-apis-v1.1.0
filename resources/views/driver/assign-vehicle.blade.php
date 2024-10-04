<form action="{{ route('driver.vehicle.assign', $driver->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Assign Driver to Vehicle</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Driver
                        <i class="text-danger">*</i>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $driver->user->name }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Driver's License Number
                        <i class="text-danger">*</i>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $driver->license->driving_license_no }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="vehicle_id" class="col-sm-5 col-form-label">
                        Vehicle
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="vehicle_id" class="form-control" id="vehicle_id" required>
                            <option value="">Select a vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->make }} {{ $vehicle->model }},
                                    {{ $vehicle->plate_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        ID Number
                        <i class="text-danger">*</i>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $driver->national_id_no }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        PSV Badge Number
                        <i class="text-danger">*</i>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $driver->psvBadge->psv_badge_no }}</div>
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
