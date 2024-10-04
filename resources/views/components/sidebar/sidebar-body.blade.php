<div class="sidebar-body">
    @include('components.sidebar.sidebar-nav')
    <div class="mt-auto p-3 sidebar-logout">
        <form method="POST" action="{{route('logout')}}" class="d-inline">
            @csrf
            <button type="submit" id="logout-btn">
                <span class="btn btn-dark w-100">
                    <img class="me-2" src="{{asset('admin-assets/img/logout.png?v=1')}}">
                    <span>Logout</span>
                </span>
            </button>
        </form>
    </div>
</div>