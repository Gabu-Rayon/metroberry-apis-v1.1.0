<form action="{{ route('vehicle.insurance.suspend',$insurance->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4> Vehicle {{ $insurance->vehicle->model }},  {{ $insurance->vehicle->plate_number }},Insurance  No{{ $insurance->insurance_policy_no }}</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                 Are you sure you want to Suspend This Vehicle {{ $insurance->vehicle->model }},  {{ $insurance->vehicle->plate_number }} Insurance  No{{ $insurance->insurance_policy_no }} ?
            </p>r

            <p class="text-center">
                Make sure you have verified all of the details and documents
            </p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Deactivate</button>
    </div>
</form>
