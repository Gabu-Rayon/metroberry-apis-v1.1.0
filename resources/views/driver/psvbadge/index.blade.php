@extends('layouts.app')

@section('title', 'PSV Badges')
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
                                                <h6 class="fs-17 fw-semi-bold mb-0">PSV Badges</h6>
                                            </div>
                                            <div class="text-end">
                                                <div class="actions">
                                                    <div class="accordion-header d-flex justify-content-end align-items-center"
                                                        id="flush-headingOne">
                                                        @if (Auth::user()->can('export driver psvbadges'))
                                                            <a class="btn btn-success btn-sm"
                                                                href={{ route('driver.psvbadge.export') }} title="Export">
                                                                <i class="fa-solid fa-file-export"></i>
                                                                &nbsp;
                                                                Export
                                                            </a>
                                                        @endif
                                                        <span class="m-1"></span>
                                                        <!-- @if (Auth::user()->can('import driver psvbadges'))
                                                            <a class="btn btn-success btn-sm"
                                                                href={{ route('driver.psvbadge.import') }} title="Import">
                                                                <i class="fa-solid fa-file-import"></i>
                                                                &nbsp;
                                                                Import
                                                            </a>
                                                        @endif -->
                                                        <span class="m-1"></span>
                                                        @if (Auth::user()->can('create driver psvbadge'))
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#driverPSVBadgeModal">
                                                                <i class="fa-solid fa-user-plus"></i>&nbsp; Add Driver's PSV
                                                                Badge
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
                                                        <th title="Badge No">Badge No</th>
                                                        <th title="Driver">Driver</th>
                                                        <th title="Issue Date">Issue Date</th>
                                                        <th title="Expiry Date">Expiry Date</th>
                                                        <th title="Status">Status</th>
                                                        <th title="Action" width="80">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($psvbadges as $psvbadge)
                                                        <tr>
                                                            <td>{{ $psvbadge->psv_badge_no }}</td>
                                                            <td>{{ $psvbadge->driver->user->name }}</td>
                                                            <td>{{ $psvbadge->psv_badge_date_of_issue }}</td>
                                                            <td>{{ $psvbadge->psv_badge_date_of_expiry }}</td>
                                                            <td>
                                                                @php
                                                                    $avatar = $psvbadge->psv_badge_avatar;

                                                                    if (!$avatar) {
                                                                        $badgeClass = 'badge bg-danger';
                                                                        $badgeText = 'Missing Documents';
                                                                    } else {
                                                                        $expiryDate = \Carbon\Carbon::parse(
                                                                            $psvbadge->psv_badge_date_of_expiry,
                                                                        );
                                                                        $today = \Carbon\Carbon::today();
                                                                        $daysUntilExpiry = $today->diffInDays(
                                                                            $expiryDate,
                                                                            false,
                                                                        );
                                                                        $isExpired = $daysUntilExpiry < 0;

                                                                        Log::info(
                                                                            'Days until expiry: ' . $daysUntilExpiry,
                                                                        );

                                                                        if ($isExpired) {
                                                                            $badgeClass = 'badge bg-danger';
                                                                            $badgeText = 'Expired';
                                                                        } elseif (
                                                                            $daysUntilExpiry > 0 &&
                                                                            $daysUntilExpiry <= 30
                                                                        ) {
                                                                            if (!$psvbadge->verified) {
                                                                                $badgeClass =
                                                                                    'badge bg-warning text-dark';
                                                                                $badgeText = 'Pending Verification';
                                                                            } else {
                                                                                $badgeClass =
                                                                                    'badge bg-warning text-dark';
                                                                                $badgeText = 'Expires Soon';
                                                                            }
                                                                        } elseif (!$psvbadge->verified) {
                                                                            $badgeClass = 'badge bg-warning text-dark';
                                                                            $badgeText = 'Pending Verification';
                                                                        } else {
                                                                            $badgeClass = 'badge bg-success';
                                                                            $badgeText = 'Valid';
                                                                        }
                                                                    }
                                                                @endphp
                                                                <span class="{{ $badgeClass }}">{{ $badgeText }}</span>
                                                            </td>
                                                            <td class="d-flex">
                                                                @if (Auth::user()->can('edit driver psvbadge'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-primary"
                                                                        onclick="axiosModal('psvbadge/{{ $psvbadge->id }}/edit')"
                                                                        title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (!$psvbadge->verified)
                                                                    @if (Auth::user()->can('verify driver psvbadge'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-secondary"
                                                                            onclick="axiosModal('psvbadge/{{ $psvbadge->id }}/verify')"
                                                                            title="Verify">
                                                                            <i class="fas fa-toggle-off"></i>
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    @if (Auth::user()->can('revoke driver psvbadge'))
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-sm btn-success"
                                                                            onclick="axiosModal('psvbadge/{{ $psvbadge->id }}/revoke')"
                                                                            title="Suspend">
                                                                            <i class="fas fa-toggle-on"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                <span class='m-1'></span>
                                                                @if (Auth::user()->can('delete driver psvbadge'))
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-sm btn-danger"
                                                                        onclick="axiosModal('psvbadge/{{ $psvbadge->id }}/delete')"
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

        {{-- Driver's PSV Badge Modal --}}
        <div class="modal fade" id="driverPSVBadgeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="psvbadge" method="POST" class="needs-validation modal-content" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header my-3 p-2 border-bottom">
                        <h4>Add PSV Badge</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="driver" class="col-sm-5 col-form-label">Driver <i
                                            class="text-danger">*</i></label>
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
                                    <label for="issue_date" class="col-sm-5 col-form-label">Issue Date <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="issue_date" class="form-control" type="date"
                                            placeholder="Issue Date" id="issue_date" required
                                            value="{{ old('issue_date') }}" />
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="psv_badge_avatar" class="col-sm-5 col-form-label">PSV Badge Copy</label>
                                    <div class="col-sm-7">
                                        <input name="psv_badge_avatar" class="form-control" type="file"
                                            placeholder="Badge Picture" id="psv_badge_avatar"
                                            value="{{ old('psv_badge_avatar') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-group row my-2">
                                    <label for="psvbadge_no" class="col-sm-5 col-form-label">Badge No <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="psvbadge_no" class="form-control" type="text"
                                            placeholder="Badge No" id="psvbadge_no" required
                                            value="{{ old('psvbadge_no') }}" />
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label for="expiry_date" class="col-sm-5 col-form-label">Expiry Date <i
                                            class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input name="expiry_date" class="form-control" type="date"
                                            placeholder="Expiry Date" id="expiry_date" required
                                            value="{{ old('expiry_date') }}" />
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
            </div>
        </div>
    </body>
@endsection
