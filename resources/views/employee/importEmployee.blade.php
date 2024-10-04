<form action="{{ route('employee.import.store') }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @METHOD('POST')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Import Employee CSV file</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="file" class="col-sm-5 col-form-label">
                        Select CSV File
                    </label>
                    <div class="col-sm-7">
                        <input name="file" class="form-control" type="file" placeholder="Import xlsx"
                            id="importFile" value="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Cancel
        </button>
        <button class="btn btn-success" type="submit">Upload</button>
    </div>
</form>
