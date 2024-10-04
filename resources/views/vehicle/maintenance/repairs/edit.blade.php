<form action="{{ route('vehicle.maintenance.repairs.edit', $repair->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit {{ $repair->name }} Details</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">Name</label>
                    <div class="col-sm-7">
                        <input name="name" required class="form-control" type="text" placeholder="Name"
                            id="name" value="{{ $repair->name }}" />
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">Description</label>
                    <div class="col-sm-7">
                        <textarea name="description" required class="form-control" placeholder="Description" id="description" rows="5">{{ $repair->description }}</textarea>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>
