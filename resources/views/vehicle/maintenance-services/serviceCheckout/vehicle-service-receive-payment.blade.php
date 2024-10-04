<form action="{{ route('billed.vehicle.service.receive.payment.store', $service->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Payment</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="payment_date" class="col-sm-5 col-form-label">Date <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="payment_date" class="form-control" type="date" placeholder="Payment Date"
                            id="payment_date" required value="{{ old('payment_date') }}">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="amount" class="col-sm-5 col-form-label">Amount <i class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="amount" autocomplete="off" required class="form-control" type="number"
                            placeholder="Amount" id="amount" value="{{ $remainingAmount }}">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="account_name" class="col-sm-5 col-form-label">Account</label>
                    <div class="col-sm-7">
                        <select class="form-control basic-single select2" name="account_id" id="account_id"
                            tabindex="-1" aria-hidden="true">
                            <option value="">Please Select Account</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->holder_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="description" class="col-sm-5 col-form-label">Description <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <textarea name="remark" class="form-control" placeholder="Enter Description" id="description" required>{{ old('remark') }}</textarea>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="reference" class="col-sm-5 col-form-label">Reference <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="reference" class="form-control" type="text" placeholder="Reference"
                            id="reference" required value="{{ old('reference') }}">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="payment_receipt" class="col-sm-5 col-form-label">Payment Receipt <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <input name="payment_receipt" class="form-control" type="file"
                            placeholder="Upload Payment Receipt" id="payment_receipt" required
                            value="{{ old('payment_receipt') }}">
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
