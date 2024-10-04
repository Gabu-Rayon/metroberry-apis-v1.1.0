<form action="{{ route('refueling.redo-refuel', $refueling->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Redo Refuelling</h4>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Vehicle
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->vehicle->plate_number }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="refuelling_date" class="col-sm-5 col-form-label">
                        Date
                    </label>
                    <div class="col-sm-7">
                        <input type="date" class="form-control" id="refuelling_date" name="refuelling_date"
                            value="{{ $refueling->refuelling_date }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Volume
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->refuelling_volume }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="attendant_name" class="col-sm-5 col-form-label">
                        Attendant Name
                    </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="attendant_name" name="attendant_name"
                            value="{{ $refueling->attendant_name }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Creator
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->creator->name }}</div>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Station
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->refuellingStation->user->name }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="refuelling_time" class="col-sm-5 col-form-label">
                        Time
                    </label>
                    <div class="col-sm-7">
                        <input type="time" class="form-control" id="refuelling_time" name="refuelling_time"
                            value="{{ $refueling->refuelling_time }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Cost
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->refuelling_cost }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="attendant_phone" class="col-sm-5 col-form-label">
                        Attendant Phone
                    </label>
                    <div class="col-sm-7">
                        <input type="tel" class="form-control" id="attendant_phone" name="attendant_phone"
                            value="{{ $refueling->attendant_phone }}">
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Redo</button>
        </div>
</form>
