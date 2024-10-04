@extends('layouts.app')

@section('title', 'Vehicle Parts')
@section('content')

    <body class="fixed sidebar-mini">
        @include('components.preloader')
        <div id="app">
            <div class="wrapper">
                @include('components.sidebar.sidebar')
                <div class="content-wrapper">
                    <div class="main-content">
                        @include('components.navbar')
                        <div class="body-content">
                            <div class="tile">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fs-17 fw-semi-bold mb-0">Vehicle Parts</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#vehiclePartModal">
                                                            <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                            Add Vehicle Part
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="driver-table">
                                                <thead>
                                                    <tr>
                                                        <th title="Name">Name</th>
                                                        <th title="Category">Category</th>
                                                        <th title="Brand">Brand</th>
                                                        <th title="Quantity">Quantity</th>
                                                        <th title="Price">Price</th>
                                                        <th title="Action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($parts as $part)
                                                        <tr>
                                                            <td>{{ $part->name }}</td>
                                                            <td>{{ $part->category->name }}</td>
                                                            <td>{{ $part->brand }}</td>
                                                            <td>{{ $part->quantity }}</td>
                                                            <td>KES {{ $part->price }}</td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('vehicle.maintenance.parts.edit', $part->id) }}')"
                                                                    class="btn btn-warning btn-sm">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                    onclick="axiosModal('{{ route('vehicle.maintenance.parts.delete', $part->id) }}')"
                                                                    class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:void(0);"
                                                                   onclick="axiosModal('{{ route('vehicle.maintenance.parts.add', $part->id) }}')"
                                                                   class="btn btn-info btn-sm" title="Increase Quantity">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    @include('components.footer')
                </div>
            </div>
        </div>

        <div class="modal fade" id="vehiclePartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('vehicle.maintenance.parts.create') }}" method="POST"
                    class="needs-validation modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Create Vehicle Part</h4>
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
                                        <input name="name" class="form-control" type="text" placeholder="Name"
                                            id="name" required value="{{ old('name') }}">
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
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                        <input name="model_number" class="form-control" type="text"
                                            placeholder="model_number" id="Model No" required
                                            value="{{ old('model_number') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="quantity" class="col-sm-5 col-form-label">
                                        Quantity
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="quantity" class="form-control" type="number" placeholder="Quantity"
                                            id="quantity" required value="{{ old('quantity') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="compatibility" class="col-sm-5 col-form-label">
                                        Compatibility
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="compatibility" class="form-control" placeholder="Compatibility" id="compatibility" rows="5">{{ old('compatibility') }}</textarea>
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
                                        <input name="sku" class="form-control" type="text"
                                            placeholder="SKU"id="sku" required value="{{ old('sku') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="brand" class="col-sm-5 col-form-label">
                                        Brand
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="brand" class="form-control" type="text" placeholder="Brand"
                                            id="brand" required value="{{ old('brand') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="price" class="col-sm-5 col-form-label">
                                        Price
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="price" class="form-control" type="number" step="0.01"
                                            placeholder="Price" id="price" required value="{{ old('price') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="condition" class="col-sm-5 col-form-label">
                                        Condition
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="condition" class="form-control" id="condition" required>
                                            <option value="">Select Condition</option>
                                            <option value="new">New</option>
                                            <option value="refurbished">Refurbished</option>
                                            <option value="used">Used</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row my-2">
                                    <label for="notes" class="col-sm-5 col-form-label">
                                        Notes
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <textarea name="notes" class="form-control" placeholder="Notes" id="notes" rows="5">{{ old('notes') }}</textarea>
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

            </div>
        </div>

    </body>

@endsection
