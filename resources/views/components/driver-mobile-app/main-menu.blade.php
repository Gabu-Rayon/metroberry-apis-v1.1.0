<!--Main Menu Start-->
<div class="main-menu hidden-soft">
    <div class="mini-profile-info">
        <div class="menu-close">
            <span class="float-right">
                <img src="{{ asset('mobile-app-assets/icons/close.svg') }}" alt="Close Icon" />
            </span>
        </div>
        <div class="profile-picture text-center">
            @if (Auth::user()->avatar)

                 <img id="profile-picture"
                                src="{{ Auth::user()->avatar ? asset('uploads/user-avatars/'.basename( Auth::user()->avatar)) : asset('mobile-app-assets/images/avatar.svg') }}?{{ time() }}"
                             
                                alt="Profile Picture" class="rounded-profile-picture" />
            @else
                <img src="{{ asset('mobile-app-assets/images/anonymous.jpeg') }}" alt="Profile Picture"
                    class="rounded-profile-picture" />
            @endif
        </div>
        <div class="profile-info">
            <div class="profile-name text-center">{{ Auth::user()->name }}</div>
            <div class="profile-email text-center">{{ Auth::user()->email }}</div>
        </div>
    </div>
    <div class="menu-items">
        <div class="all-menu-items">
            <a class="menu-item" href="{{ route('driver.dashboard') }}">
                <div>
                    <span class="menu-item-icon menu-dark">
                        <img src="{{ asset('mobile-app-assets/icons/home.svg') }}" alt="Home Icon" />
                    </span>
                    <span class="menu-item-icon menu-light">
                        <img src="{{ asset('mobile-app-assets/icons/home-light.svg') }}" alt="Home Lighter Icon" />
                    </span>
                    <span class="menu-item-title">Home</span>
                    <span class="menu-item-click fas fa-arrow-right"></span>
                </div>
            </a>
            <a class="menu-item" href="{{ route('driver.profile') }}">
                <span class="menu-item-icon menu-dark profile">
                    <img src="{{ asset('mobile-app-assets/icons/avatar-dark.svg') }}" alt="Avatar Darker Icon" />
                </span>
                <span class="menu-item-icon menu-light profile">
                    <img src="{{ asset('mobile-app-assets/icons/avatar.svg') }}" alt="Avatar Darker Icon" />
                </span>
                <span class="menu-item-title profile">Profile</span>
                <span class="menu-item-click fas fa-arrow-right"></span>
            </a>
            <a class="menu-item" href="#">
                <span class="menu-item-icon menu-dark">
                    <img src="{{ asset('mobile-app-assets/icons/my-wallet.svg') }}" alt="Wallet Icon" />
                </span>
                <span class="menu-item-icon menu-light">
                    <img src="{{ asset('') }}mobile-app-assets/icons/my-wallet-light.svg" alt="Wallet Icon" />
                </span>
                <span class="menu-item-title">My Wallet <small class="text-danger"><i>coming soon</i></small> </span>
                <span class="menu-item-click fas fa-arrow-right"></span>
            </a>
            <a class="menu-item" href="{{ route('driver.registration.page') }}">
                <span class="menu-item-icon menu-dark">
                    <img src="{{ asset('mobile-app-assets/icons/driver-registration-dark.svg') }}"
                        alt="Driver Registration Icon" />
                </span>
                <span class="menu-item-icon menu-light">
                    <img src="{{ asset('mobile-app-assets/icons/driver-registration.svg') }}"
                        alt="Driver Registration Icon" />
                </span>
                <span class="menu-item-title">Driver Registration</span>
                <span class="menu-item-click fas fa-check green-status"></span>
            </a>
            <a class="menu-item position-relative" href="#">
                <span class="menu-item-icon menu-dark">
                    <img src="{{ asset('mobile-app-assets/icons/notification.svg') }}" alt="Notification Icon" />
                </span>
                <span class="menu-item-icon menu-light">
                    <img src="{{ asset('mobile-app-assets/icons/notification-light.svg') }}" alt="Notification Icon" />
                </span>
                <span class="menu-item-title">Notifications <small class="text-danger"><i>coming soon</i></small></span>
                <span class="notification-num">3</span>
                <span class="menu-item-click fas fa-arrow-right"></span>
            </a>
            <a class="menu-item" href="{{ route('driver.vehicle.docs.registration') }}">
                <span class="menu-item-icon fas fa-car"></span>
                <span class="menu-item-title">Vehicle Registration</span>
                <span class="menu-item-click fas fa-check green-status"></span>
            </a>

            {{-- <a class="menu-item" href="{{ route('trips.hisotry.page') }}">
                <span class="menu-item-icon">
                    <i class="fa-solid fa-plane-departure">
                    </i>
                </span>
                <span class="menu-item-title"> Trips</span>
                <span class="menu-item-click fas fa-check green-status">
                </span>
            </a> --}}


            <a class="menu-item" href="{{ route('trips.history.page') }}">
                <span class="menu-item-icon menu-dark">
                    {{-- <img src="{{ asset('mobile-app-assets/icons/driver-registration-dark.svg') }}"
                        alt="Driver Trips History Icon" /> --}}
                    <i class="fa-solid fa-plane-departure">
                    </i>
                </span>
                <span class="menu-item-icon menu-light">
                    {{-- <img src="{{ asset('mobile-app-assets/icons/driver-registration.svg') }}"
                        alt="Driver Trips History Icon" /> --}}
                    <i class="fa-solid fa-plane-departure">
                    </i>
                </span>
                <span class="menu-item-title">Trips History</span>
                <span class="menu-item-click fas fa-check green-status"></span>
            </a>




            <a class="menu-item" href="#">
                <span class="menu-item-icon menu-dark support">
                    <img src="{{ asset('mobile-app-assets/icons/support.svg') }}" alt="Support Icon" />
                </span>
                <span class="menu-item-icon menu-light support">
                    <img src="{{ asset('mobile-app-assets/icons/support-light.svg') }}" alt="Support Lighter Icon" />
                </span>
                <span class="menu-item-title">Online Support <small class="text-danger"><i>coming soon</i></small>
                </span>
                <span class="menu-item-click fas fa-arrow-right"></span>
            </a>
            {{-- <a href="#" class="menu-item margin-top-auto">
                <span class="menu-item-icon menu-dark logout">
                    <img src="{{ asset('mobile-app-assets/icons/logout.svg') }}" alt="Logout Icon" />
                </span>
                <span class="menu-item-icon menu-light logout">
                    <img src="{{ asset('mobile-app-assets/icons/logout-light.svg') }}" alt="Logout Icon" />
                </span>
                <span class="menu-item-title logout">Log out</span>
                <span class="menu-item-click fas fa-arrow-right"></span>
            </a> --}}

            <form method="POST" action="{{ route('logout') }}" class="menu-item margin-top-auto">
                @csrf
                <span class="menu-item-icon menu-dark logout">
                    <img src="{{ asset('mobile-app-assets/icons/logout.svg') }} " alt="Logout Icon">
                </span>
                <span class="menu-item-icon menu-light logout">
                    <img src="{{ asset('mobile-app-assets/icons/logout-light.svg') }} " alt="Logout Icon">
                </span>

                <button><span type="submit" class="menu-item-title logout">Log out</span></button>
                <span class="menu-item-click fas fa-arrow-right"></span>
            </form>
        </div>
    </div>
</div>
<!--Main Menu End-->
