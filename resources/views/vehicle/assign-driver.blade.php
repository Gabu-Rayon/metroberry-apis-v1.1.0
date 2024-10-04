<form action="{{ route('vehicle.assign.driver', $vehicle->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Assign Vehicle Driver</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="model" class="col-sm-5 col-form-label">Model <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->model }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="make" class="col-sm-5 col-form-label">Manufacturer <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->make }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="year" class="col-sm-5 col-form-label">Vehicle Year of Manufacturer <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->year }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="plate_number" class="col-sm-5 col-form-label">Number Plate <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->plate_number }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="fuel_type" class="col-sm-5 col-form-label">Fuel Type <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->fuel_type }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="engine_size" class="col-sm-5 col-form-label">Engine Size <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->engine_size }}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="color" class="col-sm-5 col-form-label">Vehicle Color <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->color }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="seats" class="col-sm-5 col-form-label">No of Seats <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        {{ $vehicle->seats }}
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="vehicle_avatar" class="col-sm-5 col-form-label">Vehicle Avatar</label>
                    <div class="col-sm-7">
                        @if ($vehicle->avatar)
                            <img src="{{ asset('images/' . $vehicle->avatar) }}" alt="Vehicle Avatar"
                                class="img-thumbnail mt-2" style="max-height: 150px;">
                        @endif
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="driver_id" class="col-sm-5 col-form-label">Driver</label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single select2" name="driver_id" id="driver_id" tabindex="-1"
                            aria-hidden="true">
                            <option value="">Please select one</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Update</button>
    </div>
</form>
