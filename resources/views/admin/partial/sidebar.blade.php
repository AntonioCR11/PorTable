{{-- SIDEBAR --}}
<div class="col-2 bg-dark px-4 h-100 d-none d-sm-block fixed-top">
    {{-- LOGO --}}
    <div class="p-4 d-flex justify-content-center ">
        <img src="{{asset('images/logo/logo.png')}}" alt="" width="70px">
    </div>
    {{-- NAVIGATION --}}
    <div class="h-100">
        <a href="/admin/dashboard" style="text-decoration: none;color:white">
            <p class="btn_orange {{($currPage === 'dashboard') ? 'btn_orange_active' : ''}} w-100 p-2 d-flex" >
                <img class="me-2" src="{{asset('images/admin/dashboard.png')}}" alt="" width="25px">
                <span class="d-none d-md-block">Dashboard</span>
            </p>
        </a>

        <a href="/admin/customer" style="text-decoration: none;color:white">
            <p class="btn_orange {{($currPage === 'customer') ? 'btn_orange_active' : ''}} p-2 d-flex">
                <img class="me-2" src="{{asset('images/admin/user.png')}}" alt="" width="25px">
                <span class="d-none d-md-block">Customer</span>
            </p>
        </a>

        <a href="/admin/restaurant" style="text-decoration: none;color:white">
            <p class="btn_orange {{($currPage === 'restaurant') ? 'btn_orange_active' : ''}} p-2 d-flex">
                <img class="me-2" src="{{asset('images/admin/restaurant.png')}}" alt="" width="25px">
                <span class="d-none d-md-block" >Restaurant</span>
            </p>
        </a>

        <a href="/admin/settings" style="text-decoration: none;color:white">
            <p class="btn_orange {{($currPage === 'settings') ? 'btn_orange_active' : ''}} p-2 d-flex">
                <img class="me-2" src="{{asset('images/admin/setting.png')}}" alt="" width="25px">
                <span class="d-none d-md-block">Settings</span>
            </p>
        </a>

        <a href="/logout"  style="text-decoration: none;color:white;">
            <p class="btn_orange p-2 d-flex">
                <img class="me-2" src="{{asset('images/admin/logout.png')}}" alt="" width="25px">
                <span class="d-none d-md-block">Logout</span>
            </p>
        </a>
    </div>
</div>
<div class="col-2 d-none d-sm-block"></div>
