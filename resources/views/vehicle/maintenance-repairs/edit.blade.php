<form action="{{ route('maintenance.repair.edit', $repair->id) }}" method="POST" class="needs-validation modal-content"
    enctype="multipart/form-data" id="editRepairForm">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Repair</h4>
    </div>
    <div class="modal-body">

        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="vehicle_id" class="col-sm-5 col-form-label">
                        Vehicle
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="vehicle_id" class="form-control" id="vehicle_id" required>
                            <option value="" disabled>Select a vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ $vehicle->id == $repair->vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->plate_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="part_id" class="col-sm-5 col-form-label">
                        Part
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="part_id" class="form-control" id="part_id" required>
                            <option value="" disabled>Select Part</option>
                            @foreach ($parts as $part)
                                <option value="{{ $part->id }}"
                                    {{ $part->id == $repair->part->id ? 'selected' : '' }}
                                    data-price="{{ $part->price }}">
                                    {{ $part->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="cost" class="col-sm-5 col-form-label">
                        Cost
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input type="number" name="cost" class="form-control" id="cost" step="0.01"
                            min="0" value="{{ $repair->repair_cost }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="amount" class="col-sm-5 col-form-label">
                        Amount (L)
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input type="number" name="amount" class="form-control" id="amount" step="0.01"
                            min="0" value="{{ $repair->amount }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="repair_date" class="col-sm-5 col-form-label">
                        Repair Date
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input type="date" name="repair_date" class="form-control" id="repair_date"
                            value="{{ $repair->repair_date }}" />
                    </div>
                </div>

            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="creator_id" class="col-sm-5 col-form-label">
                        Requested By
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="creator_id" class="form-control" id="creator_id" readonly>
                            <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="repair_type" class="col-sm-5 col-form-label">
                        Repair Type
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="repair_type" class="form-control" id="repair_type">
                            <option value="repair" {{ $repair->repair_type == 'repair' ? 'selected' : '' }}>Repair
                            </option>
                            <option value="replacement" {{ $repair->repair_type == 'replacement' ? 'selected' : '' }}>
                                Replacement</option>
                            <option value="refill" {{ $repair->repair_type == 'refill' ? 'selected' : '' }}>Refill
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">
                        Description
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <textarea name="description" class="form-control" id="description" rows="4">{{ $repair->repair_description ?? '-' }}</textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            Close
        </button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var repairTypeSelect = $('#repair_type');
        var partSelect = $('#part_id');
        var costInput = $('#cost');
        var amountInput = $('#amount');

        function calculateRefillCost() {
            if (repairTypeSelect.val() === 'refill') {
                var selectedPart = partSelect.find(':selected');
                var partPrice = parseFloat(selectedPart.data('price'));
                var amount = parseFloat(amountInput.val());
                var calculatedCost = partPrice * amount;
                costInput.val(calculatedCost.toFixed(2)); // Set calculated cost with 2 decimal places
                costInput.prop('readonly', true); // Make cost input read-only
            }
        }

        function toggleCostInput() {
            var selectedPart = partSelect.find(':selected');
            var partPrice = parseFloat(selectedPart.data('price'));

            if (repairTypeSelect.val() === 'replacement') {
                costInput.val(partPrice ? partPrice.toFixed(2) : '').prop('readonly', true);
                amountInput.val(1).prop('readonly', true); // Set amount to 1 and make it read-only
            } else if (repairTypeSelect.val() === 'repair') {
                costInput.val('').prop('readonly', false);
                amountInput.val(1).prop('readonly', true); // Set amount to 1 and make it read-only
            } else if (repairTypeSelect.val() === 'refill') {
                costInput.val('').prop('readonly', false);
                amountInput.val('').prop('readonly', false); // Make amount editable for refill
                calculateRefillCost(); // Calculate cost for refill
            } else {
                costInput.val('').prop('readonly', false);
                amountInput.val('').prop('readonly', false); // Reset amount for other types
            }
        }

        repairTypeSelect.change(toggleCostInput);
        partSelect.change(toggleCostInput);
        amountInput.change(calculateRefillCost); // Listen for changes in Amount field

        toggleCostInput(); // Initial call to set the state correctly on page load
    });
</script>
