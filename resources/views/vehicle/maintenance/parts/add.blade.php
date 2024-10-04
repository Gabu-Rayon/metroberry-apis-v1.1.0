<form action="{{ route('vehicle.maintenance.parts.add', $part->id) }}" method="POST" class="needs-validation modal-content"
      enctype="multipart/form-data">
    @csrf
    @METHOD('POST')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Vehicle Parts</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="quantity" class="col-sm-5 col-form-label">
                        Quantity
                    </label>
                    <div class="col-sm-7">
                        <input name="quantity" class="form-control" type="number" placeholder="Quantity"
                               id="quantity" value="" />
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Cancel
        </button>
        <button class="btn btn-success" type="submit">Add</button>
    </div>
</form>
