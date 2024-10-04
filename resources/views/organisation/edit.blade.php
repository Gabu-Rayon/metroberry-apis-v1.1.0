<form action="{{ route('organisation.update', $organisation->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit {{ $organisation->user->name }}'s Details</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">
                        Name
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="name" required class="form-control" type="text" placeholder="Name"
                            id="name" value="{{ $organisation->user->name }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="phone" class="col-sm-5 col-form-label">
                        Phone
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="phone" required class="form-control" type="text" placeholder="Phone"
                            id="phone" value="{{ $organisation->user->phone }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="organisation_code" class="col-sm-5 col-form-label">
                        Organisation Code
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="organisation_code" required class="form-control" type="text"
                            placeholder="Organisation Code" id="organisation_code"
                            value="{{ $organisation->organisation_code }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="logo" class="col-sm-5 col-form-label">
                        Logo
                    </label>
                    <div class="col-sm-7">
                        <input name="logo" class="form-control" type="file" placeholder="Logo" id="logo"
                            value="" />
                        <img src="{{ url('storage/' . $organisation->user->avatar) }}" alt="Avatar"
                            class="form-control" />
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="email" class="col-sm-5 col-form-label">
                        Email
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="email" required class="form-control" type="email" placeholder="Email"
                            id="email" value="{{ $organisation->user->email }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="address" class="col-sm-5 col-form-label">
                        Address
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="address" required class="form-control" type="text" placeholder="Address"
                            id="address" value="{{ $organisation->user->address }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="certificate_of_organisation" class="col-sm-5 col-form-label">
                        Certificate of Organisation
                    </label>
                    <div class="col-sm-7">
                        <input name="certificate_of_organisation" class="form-control" type="file"
                            placeholder="Certificate of Organisation" id="certificate_of_organisation" value="" />
                        @if ($organisation->certificate_of_organisation)
                            <div class="mt-2">
                                <a href="{{ url('storage/' . $organisation->certificate_of_organisation) }}"
                                    download>Download Certificate of Organisation</a>
                            </div>
                        @endif
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
