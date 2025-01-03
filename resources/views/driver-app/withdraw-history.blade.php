@extends('layouts.mobile-app')

@section('title', 'Withdraw History | Driver')
@section('content')
    <!--Loading Container Start-->
    <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
        <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
    </div>
    <!--Loading Container End-->

    <div class="row h-100">
        <div class="col-xs-12 col-sm-12 remaining-height">
            <!--Page Title & Icons Start-->
            <div class="header-icons-container text-center">
                <a href="wallet.html">
                    <span class="float-left">
                        <img src="{{ asset('driver-assets/icons/back.svg') }}" alt="Back Icon" />
                    </span>
                </a>
                <span class="title">Withdraw History</span>
                <a href="#">
                    <span class="float-right menu-open closed">
                        <img src="{{ asset('driver-assets/icons/menu.svg') }}" alt="Menu Hamburger Icon" />
                    </span>
                </a>
            </div>
            <!--Page Title & Icons Start-->
            <div class="rest-container">
                <!--Graph Container Start-->
                <div class="all-wide-container trip-history-driver-container">
                    <div class="balance-card-container">
                        <div class="font-13 font-roboto label-title all-container">
                            Total Withdrawal
                        </div>
                        <div class="font-28 all-container">33,346.50 USD</div>
                        <div class="w-100 graph-container">
                            <canvas id="canvas" class="h-100"></canvas>
                        </div>
                    </div>
                </div>
                <!--Graph Container End-->

                <!--Graph slider Container Start-->
                <div class="small-balance-container slider-container">
                    <!--Graph Container Start-->
                    <div class="balance-card-container-small">
                        <div class="font-13 font-roboto label-title">Credit Card</div>
                        <div class="font-20">3,977.00 USD</div>
                        <div class="w-100 graph-container">
                            <canvas id="canvas1" class="h-100"></canvas>
                        </div>
                    </div>
                    <!--Graph Container end-->

                    <!--Graph Container Start-->
                    <div class="balance-card-container-small primary-background">
                        <div class="font-13 font-roboto">PayPal</div>
                        <div class="font-20">2,190.50 USD</div>
                        <div class="w-100 graph-container">
                            <canvas id="canvas2" class="h-100"></canvas>
                        </div>
                    </div>
                    <!--Graph Container end-->

                    <!--Graph Container Start-->
                    <div class="balance-card-container-small">
                        <div class="font-13 font-roboto label-title">Wire Transfer</div>
                        <div class="font-20">3,977.00 USD</div>
                        <div class="w-100 graph-container">
                            <canvas id="canvas3" class="h-100"></canvas>
                        </div>
                    </div>
                    <!--Graph Container end-->
                </div>
                <!--Graph slider Container Start-->

                <div class="all-wide-container trip-history-driver-container">
                    <div class="all-transactions-container">
                        <div class="all-transaction-labels font-roboto">
                            Transactions
                            <span class="label-title view-all float-right">View All</span>
                        </div>

                        <!--All Withrdaw History Listing Container Start-->
                        <div class="all-sales-history-items">
                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/mastercard.svg') }}" alt="Mastercard Icon" />
                                </div>
                                <div class="width-100">
                                    <div>30/09/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #6205422</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$150.32</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/paypal.svg') }}" alt="Paypal Icon" />
                                </div>
                                <div class="width-100">
                                    <div>11/07/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #6832111</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$141.50</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/ic_bank.svg ') }}" alt="Bank Transfer Icon" />
                                </div>
                                <div class="width-100">
                                    <div>16/05/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #SDA8673DA</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$222.40</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/mastercard.svg') }}" alt="Mastercard Icon" />
                                </div>
                                <div class="width-100">
                                    <div>17/04/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #GH2342343</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$413.45</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/paypal.svg') }}" alt="Paypal Icon" />
                                </div>
                                <div class="width-100">
                                    <div>16/03/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #12313677ASREA</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$122.97</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/paypal.svg') }}" alt="Paypal Icon" />
                                </div>
                                <div class="width-100">
                                    <div>16/02/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #54353111</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$122.37</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/ic_bank.svg') }}" alt="Bank Transfer Icon" />
                                </div>
                                <div class="width-100">
                                    <div>11/02/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #876834523</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$1442.30</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->

                            <!--Withrdaw History Item Container Start-->
                            <div class="display-flex align-items-center sales-history-item">
                                <div class="all-wide-container">
                                    <img src="{{ asset('driver-assets/icons/ic_bank.svg') }}" alt="Bank Transfer Icon" />
                                </div>
                                <div class="width-100">
                                    <div>01/01/2018</div>
                                    <div class="order-num-container">
                                        <span class="label-title font-11 font-roboto">Order #23456KAJSD</span>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <div class="blue-price text-right">$3112.30</div>
                                </div>
                            </div>
                            <!--Withrdaw History Item Container End-->
                        </div>
                        <!--All Withrdaw History Listing Container End-->
                    </div>

                    <!--Load More Button Start-->
                    <div class="load-more">
                        <button type="button" class="btn btn-dark text-uppercase load-more">
                            Load More
                        </button>
                    </div>
                    <!--Load More Button End-->
                </div>
            </div>
        </div>

        <!--Main Menu Start-->
        <div class="main-menu hidden-soft">
            <div class="mini-profile-info">
                <div class="menu-close">
                    <span class="float-right">
                        <img src="{{ asset('driver-assets/icons/close.svg') }}" alt="Close Icon" />
                    </span>
                </div>
                <div class="profile-picture text-center">
                    <img src="{{ asset('driver-assets/images/profile-3.png') }}" alt="Profile Picture" />
                </div>
                <div class="profile-info">
                    <div class="profile-name text-center">Jonathan McBerly</div>
                    <div class="profile-email text-center">lorem@loremipsum.com</div>
                </div>
            </div>
            <div class="menu-items">
                <div class="all-menu-items">
                    <a class="menu-item" href="index.html">
                        <div>
                            <span class="menu-item-icon menu-dark">
                                <img src="{{ asset('driver-assets/icons/home.svg ') }}" alt="Home Icon" />
                            </span>
                            <span class="menu-item-icon menu-light">
                                <img src="{{ asset('driver-assets/icons/home-light.svg ') }}" alt="Home Lighter Icon" />
                            </span>
                            <span class="menu-item-title">Home</span>
                            <span class="menu-item-click fas fa-arrow-right"></span>
                        </div>
                    </a>
                    <a class="menu-item" href="profile.html">
                        <span class="menu-item-icon menu-dark profile">
                            <img src="{{ asset('driver-assets/icons/avatar-dark.svg ') }}" alt="Avatar Darker Icon" />
                        </span>
                        <span class="menu-item-icon menu-light profile">
                            <img src="{{ asset('driver-assets/icons/avatar.svg') }}" alt="Avatar Darker Icon" />
                        </span>
                        <span class="menu-item-title profile">Profile</span>
                        <span class="menu-item-click fas fa-arrow-right"></span>
                    </a>
                    <a class="menu-item" href="wallet.html">
                        <span class="menu-item-icon menu-dark">
                            <img src="driver-assets/icons/my-wallet.svg {{ asset('') }}" alt="Wallet Icon" />
                        </span>
                        <span class="menu-item-icon menu-light">
                            <img src="{{ asset('driver-assets/icons/my-wallet-light.svg') }}" alt="Wallet Icon" />
                        </span>
                        <span class="menu-item-title">My Wallet</span>
                        <span class="menu-item-click fas fa-arrow-right"></span>
                    </a>
                    <a class="menu-item" href="driver-registration.html">
                        <span class="menu-item-icon menu-dark">
                            <img src="{{ asset('driver-assets/icons/driver-registration-dark.svg ') }}"
                                alt="Driver Registration Icon" />
                        </span>
                        <span class="menu-item-icon menu-light">
                            <img src="{{ asset('driver-assets/icons/driver-registration.svg') }}"
                                alt="Driver Registration Icon" />
                        </span>
                        <span class="menu-item-title">Driver Registration</span>
                        <span class="menu-item-click fas fa-check green-status"></span>
                    </a>
                    <a class="menu-item position-relative" href="notifications.html">
                        <span class="menu-item-icon menu-dark">
                            <img src="{{ asset('driver-assets/icons/notification.svg ') }}" alt="Notification Icon" />
                        </span>
                        <span class="menu-item-icon menu-light">
                            <img src="{{ asset('driver-assets/icons/notification-light.svg') }}"
                                alt="Notification Icon" />
                        </span>
                        <span class="menu-item-title">Notifications</span>
                        <span class="notification-num">3</span>
                        <span class="menu-item-click fas fa-arrow-right"></span>
                    </a>
                    <a class="menu-item" href="add-new-car.html">
                        <span class="menu-item-icon fas fa-car"></span>
                        <span class="menu-item-title">Car Registration</span>
                        <span class="menu-item-click fas fa-check green-status"></span>
                    </a>
                    <a class="menu-item" href="support.html">
                        <span class="menu-item-icon menu-dark support">
                            <img src="{{ asset('driver-assets/icons/support.svg') }}" alt="Support Icon" />
                        </span>
                        <span class="menu-item-icon menu-light support">
                            <img src="{{ asset('driver-assets/icons/support-light.svg') }}" alt="Support Lighter Icon" />
                        </span>
                        <span class="menu-item-title">Online Support</span>
                        <span class="menu-item-click fas fa-arrow-right"></span>
                    </a>
                    <a href="loading-logo.html" class="menu-item margin-top-auto">
                        <span class="menu-item-icon menu-dark logout">
                            <img src="{{ asset('driver-assets/icons/logout.svg') }}" alt="Logout Icon" />
                        </span>
                        <span class="menu-item-icon menu-light logout">
                            <img src="{{ asset('driver-assets/icons/logout-light.svg') }}" alt="Logout Icon" />
                        </span>
                        <span class="menu-item-title logout">Log out</span>
                        <span class="menu-item-click fas fa-arrow-right"></span>
                    </a>
                </div>
            </div>
        </div>
        <!--Main Menu End-->
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
@endsection
