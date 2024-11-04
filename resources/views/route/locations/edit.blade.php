<form action="{{ route('route.location.waypoint.update', $routelocation->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit {{ $routelocation->name }} Waypoint Details</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row my-2">
                    <label for="route_location_waypoint_name" class="col-sm-5 col-form-label">
                        Route Location Waypoint (Name)
                    </label>
                    <div class="col-sm-7">
                        <input name="route_location_waypoint_name" required class="form-control" type="text"
                            placeholder="Start Location" id="route_location_waypoint_name"
                            value="{{ old('route_location_waypoint_name', $routelocation->name ?? '') }}" />
                        @if ($errors->has('route_location_waypoint_name'))
                            <small class="text-danger">{{ $errors->first('route_location_waypoint_name') }}</small>
                        @endif
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
