<form action="{{ route('maintenance.repair.redo-repair', $maintenanceRepair->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Redo Repair</h4>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Vehicle
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $maintenanceRepair->vehicle->plate_number }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Type
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $maintenanceRepair->repair_type }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="repair_date" class="col-sm-5 col-form-label">
                        Date
                    </label>
                    <div class="col-sm-7">
                        <input type="date" id="repair_date" name="repair_date" class="form-control"
                            value="{{ $maintenanceRepair->repair_date }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">
                        Description
                    </label>
                    <div class="col-sm-7">
                        <textarea id="description" name="description" class="form-control" rows="3">{{ $maintenanceRepair->repair_description }}</textarea>
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="creator_id" class="col-sm-5 col-form-label">
                        Requested By
                    </label>
                    <div class="col-sm-7">
                        <select id="creator_id" name="creator_id" class="form-control" readonly>
                            <option value="{{ $maintenanceRepair->creator->id }}" selected>
                                {{ $maintenanceRepair->creator->name }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Part
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $maintenanceRepair->part->name }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Cost
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $maintenanceRepair->repair_cost }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Amount
                    </div>
                    <div class="col-sm-7">
                        <div class="form-control">{{ $maintenanceRepair->amount }}</div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <div class="col-sm-5 col-form-label">
                        Status
                    </div>
                    <div class="col-sm-7">
                        @php
                            $statusClass = '';
                            if ($maintenanceRepair->repair_status === 'rejected') {
                                $statusClass = 'text-danger border border-danger';
                            } elseif ($maintenanceRepair->repair_status === 'billed') {
                                $statusClass = 'text-success border border-success';
                            }
                        @endphp

                        <div class="form-control {{ $statusClass }}">
                            {{ $maintenanceRepair->repair_status }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                Close
            </button>
            <button class="btn btn-success" type="submit">Redo</button>
        </div>
</form>
