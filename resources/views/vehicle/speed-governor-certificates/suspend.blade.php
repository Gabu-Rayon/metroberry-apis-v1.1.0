<form action="{{ route('vehicle.inspection.certificate.suspend', $certificate->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Suspend {{ $certificate->vehicle->plate_number }}'s Inspection Certificate</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to suspend {{ $certificate->vehicle->make }} {{ $certificate->vehicle->model }},
                {{ $certificate->vehicle->plate_number }}'s Inspection Certificate?
            </p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Suspend</button>
    </div>
</form>
