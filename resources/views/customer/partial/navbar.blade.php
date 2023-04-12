
        <ul class="nav py-3">
            <div class="row w-100">
                {{-- LOGO --}}
                <div class="col">
                    <h1 class="m-0" style="cursor: pointer;">
                        <span class="text-light bg-dark p-3">
                            ρσятαвℓє
                        </span>
                    </h1>
                </div>
                {{-- NAVIGATION --}}
                <div class="col d-none d-lg-flex justify-content-center align-items-center">
                    <li class="nav-item" style=" {{($currPage === 'home') ? 'border-bottom: 1px solid black' : ''}}">
                        <a class="nav-link text-dark navigation" href="{{route("customer_home")}}">Home</a>
                    </li>
                    <li class="nav-item" style=" {{($currPage === 'search') ? 'border-bottom: 1px solid black' : ''}}">
                        <a class="nav-link text-dark navigation" href="{{route("customer_search")}}">Search</a>
                    </li>
                    <li class="nav-item" style=" {{($currPage === 'favorite') ? 'border-bottom: 1px solid black' : ''}}">
                        <a class="nav-link text-dark navigation" href="{{route("customer_favorite")}}">Favorite</a>
                    </li>
                    <li class="nav-item" style=" {{($currPage === 'history') ? 'border-bottom: 1px solid black' : ''}}">
                        <a class="nav-link text-dark navigation" href="{{route("customer_history")}}">History</a>
                    </li>
                    <li class="nav-item" style=" {{($currPage === 'profile') ? 'border-bottom: 1px solid black' : ''}}">
                        <a class="nav-link text-dark navigation" href="{{route("customer_profile")}}">Profile</a>
                    </li>
                </div>
                {{-- PROFILE --}}
                <div class="col d-flex justify-content-end align-items-center">
                    {{-- NOTIFICATION --}}
                    <div class="navigation notification me-4" style="cursor: pointer; position: relative;">
                        <div class="floating text-light rounded-pill d-flex justify-content-center align-items-center" style="position: absolute;top:-10px;right:-10px; background-color: #ed3b27; width: 20px;height: 20px;">
                            @php
                                // GET TOTAL UNREAD MESSAGE
                                $unread_message = count(activeUser()->posts()->where("status","=","0")->get());
                            @endphp
                            {{$unread_message}}
                        </div>
                        <a href="{{route("customer_notification")}}">
                            <img src="{{asset("storage/images/admin/notification.png")}}" alt="" width="30px">
                        </a>
                    </div>

                    <div class="profile">
                        <li class="dropdown-center">
                            <img class="dropdown-toggle" role="button" data-bs-toggle="dropdown" src="{{ asset('storage/images/customer/'.activeUser()->full_name.'/pp.jpg') }}" alt="" width="45px" height="45px" style="border-radius: 50%">
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">Hello, {{activeUser()->username}}!</li>
                                <li class="dropdown-item">Balance : {{activeUser()->balance}}</li>
                                <li><hr class="dropdown-divider"></li>
                                {{-- <li><a class="dropdown-item" href="{{route('customer_profile')}}">Edit Profile</a></li>
                                <li><a class="dropdown-item" href="#">Top up Balance</a></li>
                                <li><hr class="dropdown-divider"></li> --}}
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    </div>

                    <div class="hamburger d-lg-none ms-3">
                        <li class="dropdown-center">
                            <img class="dropdown-toggle" role="button" data-bs-toggle="dropdown" src="{{ asset('storage/images/customer/more.png') }}" alt="" width="30px" height="30px">
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{route('customer_home')}}">Home</a></li>
                                <li><a class="dropdown-item" href="{{route('customer_search')}}">Search</a></li>
                                <li><a class="dropdown-item" href="{{route('customer_favorite')}}">Favorite</a></li>
                                <li><a class="dropdown-item" href="{{route('customer_history')}}">History</a></li>
                                <li><a class="dropdown-item" href="{{route('customer_profile')}}">Profile</a></li>
                            </ul>
                        </li>
                    </div>
                </div>
            </div>
        </ul>
