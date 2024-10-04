<form action="{{ route('refueling.bill', $refueling->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Bill Repair</h4>
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
                    <div class="col-sm-5 col-form-label">
                        Date
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->refuelling_date }}</div>
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
                    <div class="col-sm-5 col-form-label">
                        Attendant Name
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->attendant_name }}</div>
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
                    <div class="col-sm-5 col-form-label">
                        Time
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->refuelling_time }}</div>
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
                    <div class="col-sm-5 col-form-label">
                        Attendant Phone
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $refueling->attendant_phone }}</div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Bill</button>
        </div>
</form>
