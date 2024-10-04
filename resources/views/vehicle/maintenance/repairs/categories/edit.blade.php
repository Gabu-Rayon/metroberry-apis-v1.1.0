<form action="{{ route('vehicle.maintenance.repairs.categories.edit', $repairCategory->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit {{ $repairCategory->name }} Details</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group row my-2">
                    <label for="repair_id" class="col-sm-5 col-form-label">
                        Repair Type
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="repair_id" class="form-control" id="repair_id" required>
                            <option value="">Select Repair Type</option>
                            @foreach ($repairTypes as $repairType)
                                <option value="{{ $repairType->id }}"
                                    {{ $repairCategory->repair_id == $repairType->id ? 'selected' : '' }}>
                                    {{ $repairType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">Description</label>
                    <div class="col-sm-7">
                        <textarea name="description" required class="form-control" placeholder="Description" id="description" rows="5">{{ $repairCategory->description }}</textarea>
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">Name</label>
                    <div class="col-sm-7">
                        <input name="name" required class="form-control" type="text" placeholder="Name"
                            id="name" value="{{ $repairCategory->name }}" />
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
