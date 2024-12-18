<form action="{{ route('vehicle.speed.governor.deactivate', $certificate->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Deactivate {{ $certificate->vehicle->plate_number }}'s Speed Governor?</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to deactivate {{ $certificate->vehicle->make }} {{ $certificate->vehicle->model }},
                {{ $certificate->vehicle->plate_number }}'s Speed Governor?
            </p>
            <p class="text-center">
                Make sure you have verified all of the details and documents
            </p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Deactivate</button>
    </div>
</form>
