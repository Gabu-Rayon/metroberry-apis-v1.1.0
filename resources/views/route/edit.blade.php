<form action="/route/{{ $route->id }}/update" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit {{ $route->name }} Details</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">Name</label>
                    <div class="col-sm-7">
                        <input name="name" disabled class="form-control" type="text" placeholder="Name"
                            id="name" value="{{ $route->name }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="start_location" class="col-sm-5 col-form-label">Start Location</label>
                    <div class="col-sm-7">
                        <input name="start_location" required class="form-control" type="text"
                            placeholder="Start Location" id="start_location"
                            value="{{ $route->start_location->name ?? '' }}" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row my-2">
                    <label for="county" class="col-sm-5 col-form-label">County</label>
                    <div class="col-sm-7">
                        <input name="county" required class="form-control" type="text" placeholder="County"
                            id="county" value="{{ $route->county }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="end_location" class="col-sm-5 col-form-label">End Location</label>
                    <div class="col-sm-7">
                        <input name="end_location" required class="form-control" type="text"
                            placeholder="End Location" id="end_location"
                            value="{{ $route->end_location->name ?? '' }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div id="repeater" class="my-2">
                        <div class="repeater-heading">
                            <button class="btn btn-primary repeater-add-btn text-end" type="button">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                        <div class="items" data-group="test">
                            <!-- Existing item content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        let currentIndex = 1;

        $('.repeater-add-btn').click(function(e) {
            e.preventDefault();
            var newRow = '<div class="item-content col-md-6">' +
                '<div class="form-group row my-2">' +
                '<label for="location_name" class="col-sm-5 col-form-label">Name</label>' +
                '<div class="col-sm-7">' +
                '<input name="locations[' + currentIndex +
                '][name]" required class="form-control" type="text" placeholder="Name" />' +
                '</div>' +
                '</div>' +
                '<div class="form-group row my-2">' +
                '<label for="point_order" class="col-sm-5 col-form-label">Point Order</label>' +
                '<div class="col-sm-7">' +
                '<input name="locations[' + currentIndex +
                '][point_order]" required class="form-control" type="number" placeholder="Order" />' +
                '</div>' +
                '</div>' +
                '</div>';
            $('#repeater .items').append(newRow);
            currentIndex++;
        });
    });
</script>
