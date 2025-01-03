<form action="{{ route('route.location.destroy', $routelocation->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('DELETE')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete {{ $routelocation->route->name }} ?</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">Are you sure you want to delete this route Location waypoint ?</p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Delete</button>
    </div>
</form>
