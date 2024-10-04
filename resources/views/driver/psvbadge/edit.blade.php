<form action="psvbadge/{{ $psvbadge->id }}/update" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit {{ $psvbadge->driver->user->name }}'s Badge Details</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="psvbadge_no" class="col-sm-5 col-form-label">
                        Badge Number
                    </label>
                    <div class="col-sm-7">
                        <input name="psvbadge_no" readonly class="form-control" type="text"
                            placeholder="Badge Number" id="psvbadge_no" value="{{ $psvbadge->psv_badge_no }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="psv_badge_date_of_issue" class="col-sm-5 col-form-label">
                        Issue Date
                    </label>
                    <div class="col-sm-7">
                        <input name="psv_badge_date_of_issue" required class="form-control" type="date"
                            placeholder="Issue Date" id="psv_badge_date_of_issue"
                            value="{{ $psvbadge->psv_badge_date_of_issue }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="psv_badge_avatar" class="col-sm-5 col-form-label">
                        Badge Copy
                    </label>
                    <div class="col-sm-7">
                        <input name="psv_badge_avatar" class="form-control" type="file" placeholder="Badge Copy"
                            id="psv_badge_avatar" value="" />
                        @if ($psvbadge->psv_badge_avatar)
                            <div class="mt-2">
                                <a href="{{ url('storage/' . $psvbadge->psv_badge_avatar) }}" download>Download Badge
                                    Copy</a>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="driver" class="col-sm-5 col-form-label">
                        Driver
                    </label>
                    <div class="col-sm-7">
                        <input name="driver" readonly class="form-control" type="text" placeholder="Driver"
                            id="driver" value="{{ $psvbadge->driver->user->name }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="psv_badge_date_of_expiry" class="col-sm-5 col-form-label">
                        Expiry Date
                    </label>
                    <div class="col-sm-7">
                        <input name="psv_badge_date_of_expiry" required class="form-control" type="date"
                            placeholder="Expiry Date" id="psv_badge_date_of_expiry"
                            value="{{ $psvbadge->psv_badge_date_of_expiry }}" />
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
