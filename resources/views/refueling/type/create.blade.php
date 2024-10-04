<form action="admin/refueling/type" method="POST" class="needs-validation modal-content" enctype="multipart/form-data"
    onsubmit="submitFormAxios(event)">
    <input type="hidden" name="_token" value="AQNLvAb467g0eZtkGATqrKcNNVohCNfvLiX4IjQc" autocomplete="off" />
    <div class="card-header my-3 p-2 border-bottom">
        <h4>fuel Type Lists</h4>
    </div>
    <div class="modal-body">
        <table class="table table-hover table-striped">
            <tr>
                <th>
                    <label for="name" class="">
                        Name <span class="text-danger">*</span>
                    </label>
                </th>
                <td>
                    <input type="text" class="form-control" name="name" id="name" value=""
                        placeholder="Name" required />
                </td>
            </tr>
            <tr>
                <th>
                    <label for="description" class=""> Description </label>
                </th>
                <td>
                    <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="is_active" class=""> Status </label>
                </th>
                <td>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>
