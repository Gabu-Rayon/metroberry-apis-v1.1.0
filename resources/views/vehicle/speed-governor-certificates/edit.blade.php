<form action="{{ route('vehicle.inspection.certificate.edit', $certificate->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Inspection Certificate</h4>
    </div>

    {{-- 'certificate_no',
        'vehicle_id',
        'class_no',
        'type_of_governor',
        'date_of_installation',
        'expiry_date',
        'certificate_copy',
         --}}

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
                        <input name="ntsa_inspection_certificate_date_of_issue" class="form-control" type="date"
                            id="ntsa_inspection_certificate_date_of_issue" required
                            value="{{ $certificate->ntsa_inspection_certificate_date_of_issue }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="certificate_copy" class="col-sm-5 col-form-label">
                        Certificate Copy
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="avatar" class="form-control" type="file" accept="image/*" id="avatar"
                            required />
                        @if ($certificate->ntsa_inspection_certificate_avatar)
                            <a href="{{ asset($certificate->ntsa_inspection_certificate_avatar) }}"
                                target="_blank">
                                <img src="{{ asset($certificate->ntsa_inspection_certificate_avatar) }}"
                                    alt="Certificate Copy" class="img-fluid mt-2" />
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="ntsa_inspection_certificate_no" class="col-sm-5 col-form-label">
                        Certificate No
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="ntsa_inspection_certificate_no" class="form-control" type="text"
                            placeholder="Certificate No" id="ntsa_inspection_certificate_no" required
                            value="{{ $certificate->ntsa_inspection_certificate_no }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="ntsa_inspection_certificate_date_of_expiry" class="col-sm-5 col-form-label">
                        Date of Expiry
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="ntsa_inspection_certificate_date_of_expiry" class="form-control" type="date"
                            id="ntsa_inspection_certificate_date_of_expiry" required
                            value="{{ $certificate->ntsa_inspection_certificate_date_of_expiry }}" />
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
