<div class="row mb-4">
    <div class="col-12 col-lg-6 col-xl-3 mb-4 mb-xl-0">
        <div class="card bg-white overflow-hidden">
            <div class="card-header px-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-bold mb-0">Vehicles</h6>
                    </div>
                </div>
            </div>

            <div class="card-body px-3">
                <div class="d-flex flex-column gap-2">

                    <div>
                        <i class="fas fa-car-on text-success"></i>

                        <a class="text-success" href="vehicle">
                            Active
                            <span class="float-end text-success">
                                <strong>
                                    {{ count($activeVehicles) }}
                                </strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i class="fas fa-car-burst text-danger"></i>

                        <a class="text-danger" href="vehicle">
                            Inactive
                            <span class="float-end text-danger">
                                <strong>
                                    {{ count($inactiveVehicles) }}
                                </strong>
                            </span>
                        </a>
                    </div>

                    <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-xl-3 mb-4 mb-xl-0">
        <div class="card bg-white overflow-hidden">
            <div class="card-header px-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-bold mb-0">Trips This Month</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-3">
                <div class="d-flex flex-column gap-2">

                    <div>
                        <i class="fa-solid fa-calendar-days text-primary"></i>

                        <a class="text-primary" href="trips/scheduled">
                            Scheduled
                            <span class="float-end text-primary">
                                <strong>
                                    {{ count($scheduledTrips) }}
                                </strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i class="fas fa-check-circle text-info"></i>

                        <a class="text-info" href="trips/completed">
                            Completed
                            <span class="float-end text-info">
                                <strong>
                                    {{ count($completedTrips) }}
                                </strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i class="fa-solid fa-circle-xmark text-danger"></i>

                        <a class="text-danger" href="trips/cancelled">
                            Cancelled
                            <span class="float-end text-danger">
                                <strong>
                                    {{ count($cancelledTrips) }}
                                </strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i class="fas fa-money-bill-wave text-success"></i>

                        <a class="text-success" href="trips/billed">
                            Billed
                            <span class="float-end text-success">
                                <strong>
                                    {{ count($billedTrips) }}
                                </strong>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-xl-3 mb-4 mb-xl-0">
        <div class="card bg-white overflow-hidden">
            <div class="card-header px-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-bold mb-0">Reminders</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-3">
                <div class="d-flex flex-column gap-2">

                    <div>
                        <i
                            class="fas fa-shield-alt {{ count($expiredInsurances) == 0 ? 'text-success' : 'text-danger' }}"></i>

                        <a href="vehicle/insurance"
                            class="{{ count($expiredInsurances) == 0 ? 'text-success' : 'text-danger' }}">
                            Expired Insurances
                            <span class="float-end">
                                <strong>{{ count($expiredInsurances) }}</strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i
                            class="fas fa-stamp {{ count($expiredInspectionCertificates) == 0 ? 'text-success' : 'text-danger' }}"></i>

                        <a href="vehicle/inspection-certificate"
                            class="{{ count($expiredInspectionCertificates) == 0 ? 'text-success' : 'text-danger' }}">
                            Expired Insp Cert
                            <span class="float-end">
                                <strong>{{ count($expiredInspectionCertificates) }}</strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i class="fas fa-file {{ count($expiredLicenses) == 0 ? 'text-success' : 'text-danger' }}"></i>

                        <a href="driver/license"
                            class="{{ count($expiredLicenses) == 0 ? 'text-success' : 'text-danger' }}">
                            Expired Licenses
                            <span class="float-end">
                                <strong>{{ count($expiredLicenses) }}</strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i
                            class="fas fa-id-badge {{ count($expiredPSVBadges) == 0 ? 'text-success' : 'text-danger' }}"></i>

                        <a href="driver/psvbadge"
                            class="{{ count($expiredPSVBadges) == 0 ? 'text-success' : 'text-danger' }}">
                            Expired PSV Badges
                            <span class="float-end">
                                <strong>{{ count($expiredPSVBadges) }}</strong>
                            </span>
                        </a>
                    </div>

                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 col-xl-3">
        <div class="card bg-white overflow-hidden">
            <div class="card-header px-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-bold mb-0">Other activities</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-3">
                <div class="d-flex flex-column gap-2">
                    @php
                        $isLoss = $totalAmount > $totalIncomes;
                        $textClass = $isLoss ? 'text-danger' : 'text-success';
                    @endphp

                    <div>
                        <i class="fas fa-money-bill {{ $textClass }}"></i>
                        <a class="{{ $textClass }}" href="#">
                            Total Income
                            <span class="float-end {{ $textClass }}">
                                <strong>KES {{ $totalIncomes }}</strong>
                            </span>
                        </a>
                    </div>

                    <div>
                        <i class="fas fa-money-check {{ $textClass }}"></i>
                        <a class="{{ $textClass }}" href="#">
                            Total Expenses
                            <span class="float-end {{ $textClass }}">
                                <strong>KES {{ $totalAmount }}</strong>
                            </span>
                        </a>
                    </div>

                    @if ($isLoss)
                        <div class="alert alert-danger mt-2">
                            Kindly Check Your Accounts
                            <i class="far fa-frown"></i>
                        </div>
                    @else
                        <div class="alert alert-success mt-2">
                            Accounts Are Ok
                            <i class="far fa-smile"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



</div>
