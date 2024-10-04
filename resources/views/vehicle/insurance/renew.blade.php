<form action="{{ route('vehicle.insurance.renew', $insurance->id) }}" method="POST" class="needs-validation modal-content"
      enctype="multipart/form-data">
    @csrf
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Insurance Renewal</h4>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="issue_date" class="col-sm-5 col-form-label">
                        Issue Date
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="issue_date" class="form-control" type="date" placeholder="Issue Date" id="issue_date"
                               required />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="policy_document" class="col-sm-5 col-form-label">
                        Policy Document
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="policy_document" class="form-control" type="file" placeholder="Policy Document" id="policy_document"
                               required />
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="expiry_date" class="col-sm-5 col-form-label">
                        Expiry Date
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="expiry_date" class="form-control" type="date" placeholder="Expiry Date" id="expiry_date"
                               required />
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-warning" type="submit">Renew</button>
        </div>
</form>
