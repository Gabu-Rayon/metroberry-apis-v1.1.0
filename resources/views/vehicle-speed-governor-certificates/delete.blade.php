<form action="{{ route('vehicle.speed.governor.delete', $certificate->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('DELETE')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete Speed Governor Certificate</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">Are you sure you want to delete this certificate?</p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Delete</button>
    </div>
</form>
