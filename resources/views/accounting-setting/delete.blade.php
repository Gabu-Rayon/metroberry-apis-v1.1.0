<form action="{{ route('metro.berry.account.setting.destroy', $setting->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('DELETE')
    <div class="card-header text-center my-3 p-2 border-bottom">
        <h4>Delete {{ $setting->holder_name }} Bank Account</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <p class="text-center">Are you sure you want to delete {{ $setting->holder_name }}'s Bank Account ?</p>
            <br>
            <p class="text-center text-danger">This action can not be undone. Do you want to continue?</p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-danger" type="submit">Delete</button>
    </div>
</form>
