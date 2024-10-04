<form action="psvbadge/{{ $psvbadge->id }}/revoke" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Suspend {{ $psvbadge->driver->user->name }}'s Badge</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to suspend {{ $psvbadge->driver->user->name }}'s Badge?
            </p>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Suspend</button>
    </div>
</form>
