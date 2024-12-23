<form action="{{ route('vehicle.speed.governor.edit', $certificate->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Speed Governor Certificate</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="vehicle_id" class="col-sm-5 col-form-label">
                        Vehicle
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="vehicle" class="form-control" id="vehicle" required>
                            <option value="" disabled {{ is_null($certificate->vehicle_id) ? 'selected' : '' }}>
                                Select a vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ $vehicle->id == $certificate->vehicle_id ? 'selected' : '' }}>
                                    {{ $vehicle->make }} {{ $vehicle->model }}, {{ $vehicle->plate_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="date_of_installation" class="col-sm-5 col-form-label">
                        Date of Installation
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="date_of_installation" class="form-control" type="date"
                            id="date_of_installation" required
                            value="{{ $certificate->date_of_installation }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="certificate_copy" class="col-sm-5 col-form-label">
                        Certificate Copy
                    </label>
                    <div class="col-sm-7">
                        <input name="avatar" class="form-control" type="file" accept="image/*" id="avatar" />
                        @if ($certificate->copy)

                            <a href="{{ asset('uploads/speed-governor-cert-copies'.basename($certificate->copy)) }}"
                                target="_blank">
                                <img src="{{ asset('uploads/speed-governor-cert-copies'.basename($certificate->copy)) }}"
                                    alt="Certificate Copy" class="img-fluid mt-2" />
                            </a>
                        @endif
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="chasis_no" class="col-sm-5 col-form-label">
                        Chasis No
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="chasis_no" class="form-control" type="text"
                            placeholder="Chasis No" id="chasis_no" required
                            value="{{ $certificate->chasis_no }}">
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="certificate_no" class="col-sm-5 col-form-label">
                        Certificate No
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="certificate_no" class="form-control" type="text"
                            placeholder="Certificate No" id="certificate_no" required
                            value="{{ $certificate->certificate_no }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="expiry_date" class="col-sm-5 col-form-label">
                        Date of Expiry
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="expiry_date" class="form-control" type="date"
                            id="expiry_date" required
                            value="{{ $certificate->expiry_date }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="class_no" class="col-sm-5 col-form-label">
                        Class
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="class_no" class="form-control" type="text"
                            placeholder="Class" id="class_no" required
                            value="{{ $certificate->class_no }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="type_of_governor" class="col-sm-5 col-form-label">
                        Type
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="type_of_governor" class="form-control" type="text"
                            placeholder="Type" id="type_of_governor" required
                            value="{{ $certificate->type_of_governor }}">
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
