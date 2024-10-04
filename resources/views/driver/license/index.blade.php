@extends('layouts.app')

@section('title', 'Licenses')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">Licenses</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        @if (Auth::user()->can('export driver licenses'))
                                                            <a class="btn btn-success btn-sm"
                                                                href={{ route('driver.license.export') }} title="Export">
                                                                <i class="fa-solid fa-file-export"></i>
                                                                &nbsp;
                                                                Export
                                                            </a>
                                                        @endif
                                                        <span class="m-1"></span>
                                                        <!-- <a class="btn btn-success btn-sm"
                                                            href={{ route('driver.license.import') }} title="Import">
                                                            <i class="fa-solid fa-file-import"></i>
                                                            &nbsp;
                                                            Import
                                                        </a> -->
                                                        <!-- @if (Auth::user()->can('import driver licenses'))
                                                            <a class="btn btn-success btn-sm"
                                                                href={{ route('driver.license.import') }} title="Import">
                                                                <i class="fa-solid fa-file-import"></i>
                                                                &nbsp;
                                                                Import
                                                            </a>
                                                        @endif -->
                                                        <span class="m-1"></span>
                                                        @if (Auth::user()->can('create driver license'))
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#driverLicenseModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp;
                                                                Add Driver's License
                                                            </button>
                                                        @endif
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
                                                        <th title="Name">License No</th>
                                                        <th title="Address">Driver</th>
                                                        <th title="Email">Issue Date</th>
                                                        <th title="Phone">Expiry Date</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($licenses as $license)
                                                        <tr>
                                                            <td>{{ $license->driving_license_no }}</td>
                                                            <td>{{ $license->driver->user->name }}</td>
                                                            <td>{{ $license->driving_license_date_of_issue }}</td>
                                                            <td>{{ $license->driving_license_date_of_expiry }}</td>
                                                            <td>
                                                                @php
                                                                    $frontPage = $license->driving_license_avatar_front;
                                                                    $backPage = $license->driving_license_avatar_back;

                                                                    // First, check for missing documents.
                                                                    if (!$frontPage || !$backPage) {
                                                                        $badgeClass = 'badge bg-danger'; // Red badge indicates missing documents.
                                                                        $badgeText = 'Missing Documents';
                                                                    } else {
                                                                        // Proceed only if both front and back pages are available.
                                                                        $expiryDate = \Carbon\Carbon::parse(
                                                                            $license->driving_license_date_of_expiry,
                                                                        );
                                                                        $today = \Carbon\Carbon::today();
                                                                        $isExpired = $today->lt($expiryDate);

                                                                        $daysUntilExpiry = $isExpired
                                                                            ? 0
                                                                            : $today->diffInDays($expiryDate, false);

                                                                        // Determine badge color and text based on days until expiry and verification status.
                                                                        if ($daysUntilExpiry < 0) {
                                                                            $badgeClass = 'badge bg-danger';
                                                                            $badgeText = 'Expired';
                                                                        } elseif (
                                                                            $daysUntilExpiry <= 30 &&
                                                                            !$license->verified
                                                                        ) {
                                                                            $badgeClass = 'badge bg-warning text-dark'; // Yellow badge for pending verification.
                                                                            $badgeText = 'Pending Verification';
                                                                        } elseif (
                                                                            $daysUntilExpiry > 30 &&
                                                                            !$license->verified
                                                                        ) {
                                                                            $badgeClass = 'badge bg-warning text-dark'; // Yellow badge for pending verification.
                                                                            $badgeText = 'Pending Verification';
                                                                        } else {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Active';
                                                                        }
                                                                    }
                                                                @endphp
                                                                <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                                                            </td>
                                                            <td class="d-flex">
                                                                @if (Auth::user()->can('edit driver license'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('license/{{ $license->id }}/edit')"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (!$license->verified)
                                                                    @if (Auth::user()->can('verify driver license'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('{{ route('driver.license.verify', $license->id) }}')"
                                                                            title="Verify">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if (Auth::user()->can('revoke driver license'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('license/{{ $license->id }}/revoke')"
                                                                            title="Suspend">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (Auth::user()->can('delete driver license'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('license/{{ $license->id }}/delete')"
                                                                        title="Delete">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                @endif
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

        {{-- Create License Modal --}}

        <div class="modal fade" id="driverLicenseModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('driver.license.create') }}" method="POST" class="needs-validation modal-content"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add License</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">

                                <div class="form-group row my-2">
                                    <label for="driver" class="col-sm-5 col-form-label">
                                        Driver
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <select name="driver" id="driver" class="form-control" required>
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="issue_date" class="col-sm-5 col-form-label">
                                        Issue Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="issue_date" class="form-control" type="date"
                                            placeholder="Issue Date" id="issue_date" required
                                            value="{{ old('issue_date') }}" />
                                    </div>
                                </div>


                                <div class="form-group row my-2">
                                    <label for="front_page_id" class="col-sm-5 col-form-label">
                                        Front Page License Picture
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="front_page_id" class="form-control" type="file"
                                            placeholder="Front Page License Picture" id="front_page_id" required
                                            value="{{ old('front_page_id') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="license_no" class="col-sm-5 col-form-label">
                                        License No
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="license_no" class="form-control" type="text"
                                            placeholder="License No" id="license_no" required
                                            value="{{ old('license_no') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="expiry_date" class="col-sm-5 col-form-label">
                                        Expiry Date
                                        <i class="text-danger">*</i>
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="expiry_date" class="form-control" type="date"
                                            placeholder="Expiry Date" id="expiry_date" required
                                            value="{{ old('expiry_date') }}" />
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label for="back_page_id" class="col-sm-5 col-form-label">
                                        Back Page License Picture
                                    </label>
                                    <div class="col-sm-7">
                                        <input name="back_page_id" class="form-control" type="file"
                                            placeholder="Back Page License Picture" id="back_page_id" required
                                            value="{{ old('back_page_id') }}" />
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
