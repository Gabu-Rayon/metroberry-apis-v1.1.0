<form action="{{ route('vehicle.insurance.company.update', $company->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Insurance Company</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">Company Name <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="name" class="form-control" type="text" placeholder="Company Name"
                            id="name" value="{{ old('name', $company->name) }}" required>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="email" class="col-sm-5 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input name="email" autocomplete="off" class="form-control" type="email" placeholder="Email"
                            id="email" value="{{ old('email', $company->email) }}">
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="address" class="col-sm-5 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input name="address" class="form-control" type="text" placeholder="Address" id="address"
                            value="{{ old('address', $company->address) }}">
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="website" class="col-sm-5 col-form-label">Website</label>
                    <div class="col-sm-7">
                        <input name="website" class="form-control" type="text" placeholder="Website" id="website"
                            value="{{ old('website', $company->website) }}">
                    </div>
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
