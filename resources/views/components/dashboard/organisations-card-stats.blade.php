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
                                    {{ $scheduledTripsCount }}
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
                                    {{ $completedTripsCount }}
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
                                    {{ $cancelledTripsCount }}
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
                                    {{ $billedTripsCount }}
                                </strong>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-3">
        <div class="card bg-white overflow-hidden">
            <div class="card-header px-3 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-bold mb-0"> Other activities</h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-3">
                <div class="d-flex flex-column gap-2">

                    <div>
                        <i class="fas fa-money-check text-success"></i>

                        <a class="text-success" href="#">
                            Total Expenses
                            <span class="float-end text-success">
                                <strong>{{ $totalExpenses }}</strong>
                            </span>
                        </a>
                    </div>

                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>
