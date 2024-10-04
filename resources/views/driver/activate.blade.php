<form action="driver/{{ $driver->id }}/activateStore" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Activate {{ $driver->user->name }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">
                Are you sure you want to activate {{ $driver->user->name }}?
            </p>

            <p class="text-center">
                Make sure you have verified all of their details and documents
            </p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit">Activate</button>
    </div>
</form>

<script>
    const form = document.querySelector('#activate');
    console.log(form);
</script>
