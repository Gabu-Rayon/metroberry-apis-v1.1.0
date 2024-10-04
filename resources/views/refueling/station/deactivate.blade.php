<form action="{{ route('refueling.station.deactivate', $station->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Deactivate {{ $station->user->name }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to deactivate {{ $station->user->name }} Station?
            </p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-danger" type="submit">Dectivate</button>
    </div>
</form>

<script>
    const form = document.querySelector('#activate');
    console.log(form);
</script>
