<form action="{{ route('vehicle.maintenance.parts.edit', $part->id) }}" method="POST"
    class="needs-validation modal-content" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Edit Part</h4>
    </div>
    <div class="modal-body">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="form-group row my-2">
                    <label for="name" class="col-sm-5 col-form-label">
                        Name
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="name" class="form-control" type="text" placeholder="Name" id="name"
                            required value="{{ old('name', $part->name) }}" />
                    </div>
                </div>


                <div class="form-group row my-2">
                    <label for="category" class="col-sm-5 col-form-label">
                        Category
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <select name="category_id" class="form-control" id="category" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $part->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="model_number" class="col-sm-5 col-form-label">
                        Model No
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="model_number" class="form-control" type="text" placeholder="model_number"
                            id="Model No" required value="{{ $part->model_number }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="quantity" class="col-sm-5 col-form-label">
                        Quantity
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="quantity" class="form-control" type="number" placeholder="Quantity" id="quantity"
                            required value="{{ old('quantity', $part->quantity) }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="compatibility" class="col-sm-5 col-form-label">
                        Compatibility
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <textarea name="compatibility" class="form-control" placeholder="Compatibility" id="compatibility" rows="5">{{ old('compatibility', $part->compatibility) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="sku" class="col-sm-5 col-form-label">
                        SKU
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="sku" class="form-control" type="text" step="0.01" placeholder="SKU"
                            id="sku" required value="{{ $part->sku }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="brand" class="col-sm-5 col-form-label">
                        Brand
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="brand" class="form-control" type="text" step="0.01" placeholder="Brand"
                            id="brand" required value="{{ $part->brand }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="price" class="col-sm-5 col-form-label">
                        Price
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="price" class="form-control" type="number" step="0.01" placeholder="Price"
                            id="price" required value="{{ old('price', $part->price) }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="condition" class="col-sm-5 col-form-label">
                        Condition
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="condition" class="form-control" type="text" placeholder="Condition"
                            id="condition" value="{{ old('condition', $part->condition) }}" />
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="notes" class="col-sm-5 col-form-label">
                        Notes
                        <i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <textarea name="notes" class="form-control" placeholder="Notes" id="notes" rows="5">{{ old('notes', $part->notes) }}</textarea>
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
