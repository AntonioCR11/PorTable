{{--
    LAYOUT YIELDS :

    A. HTML HEAD :
    1.  pagename : nama halaman ini (you dont say)
    2.  custom_css : jika butuh import custom css yang dibuat sendiri
    3.  dependencies : jika butuh import dependencies khusus page ini cth bootstrap, jquery

    B. HTML BODY :
    4.  header : untuk konten" header cth navbar, alert, error dsb
    5.  content : konten" utama halaman ini
    6.  footer

    C. OUTSIDE HTML BODY :
    7.  js_script

--}}

@extends('layouts.layout')

@section('pagename')
    Portable
@endsection

@section('custom_css')
    <link rel="stylesheet" href="{{asset('build/css/admin_customer.css')}}">
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
    <div class="row m-0" style="height: 100vh">
        {{-- SIDEBAR --}}
        @include('admin.partial.sidebar')

        {{-- CONTENT --}}
        <div class="col p-4" style="background-color:rgb(240, 240, 240)">
            {{-- SEARCHBAR, NOTIFICATION, PROFILE --}}
            <div class="row m-0 ">
                <div class="col">
                    <h3 class="m-0 p-0">Restaurant</h3>
                </div>

                <div class="col-2 d-flex justify-content-end align-items-center">
                    <div class="notification me-4">
                        <img src="{{asset("storage/images/admin/notification.png")}}" alt="" width="30px">
                    </div>
                    <div class="profile">
                        <img src="{{asset("storage/images/admin/profile.jpg")}}" alt="" width="45px" height="45px" style="border-radius: 50%">
                    </div>
                </div>

            </div>

            {{-- OVERVIEW --}}
            <div class="row m-0 p-0 mt-3">
                <div class="col-sm-12 col-lg-8">
                    <div class="row m-0 p-0">
                        <div class="col">
                            <div class="overview_1 p-4 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <img class="bg-light rounded-3 p-2 me-3" src="{{asset("storage/images/admin/order.png")}}" alt="" width="60px">
                                    <div class="">
                                        <p class="m-0">Total</p>
                                        <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end w-100">
                                    <h1 class="font-weight-bold">{{$countRestaurant}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="overview_2 p-4 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <img class="bg-light rounded-3 p-2 me-3" src="{{asset("storage/images/admin/order.png")}}" alt="" width="60px">
                                    <div class="">
                                        <p class="m-0">Online</p>
                                        <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end w-100">
                                    <h1 class="font-weight-bold">929</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="overview_3 p-4 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <img class="bg-light rounded-3 p-2 me-3" src="{{asset("storage/images/admin/order.png")}}" alt="" width="60px">
                                    <div class="">
                                        <p class="m-0">Offline</p>
                                        <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end w-100">
                                    <h1 class="font-weight-bold">1231</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end align-items-center">
                            <div class="searchBar w-100">
                                <form action="/admin/restaurant/search" class="d-flex" role="search" method="POST">
                                    @csrf
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword">
                                    <button class="btn border-0" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                    </button>
                                </form>
                            </div>

                        </div>

                        <div class="col-12 mt-2">
                            <div class="rounded-3 bg-dark text-light p-4 d-flex align-items-center">
                                <p class="m-0">Current Filter : <span>{{$keyword}}</span></p>
                                <div class="btn btn-outline-warning ms-auto"><a style="text-decoration:none; color:white;" href="{{url('/admin/customer')}}">Clear Filter</a></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- FILTER NAVTABS --}}
            <div class="mt-4 d-flex px-3 ">
                <div class="btn btn-dark me-2" >All</div>
                {{-- <span class="mx-3" style="border-right: 1px solid black;"></span> --}}

                <div class="btn btn-outline-dark me-2" >Online</div>
                {{-- <span class="mx-3" style="border-right: 1px solid black;"></span> --}}

                <div class="btn btn-outline-dark me-2">Offline </div>
                {{-- <span class="mx-3" style="border-right: 1px solid black;"></span> --}}

                <div class="btn btn-outline-dark me-2">Pending</div>
                {{-- <span class="mx-3" style="border-right: 1px solid black;"></span> --}}

            </div>
            {{-- CUSTOMER LIST --}}
            <div class="row m-0 p-0">
                <div class="col overflow-auto">
                    <table class="table table-striped mt-3 text-center">
                        <thead class="bg-dark text-light">
                            <th>No.</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Last Active</th>
                            <th>7D</th>
                            <th>30D</th>
                            <th>Today</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($allRestaurant as $key=>$restaurant)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$restaurant->full_name}}</td>
                                    <td>{{$restaurant->address}}</td>
                                    <td>27/11/2022</td>
                                    <td>Rp. {{$tempLastWeek[$key]}},00</td>
                                    <td>Rp. {{$tempLastMonth[$key]}},00</td>
                                    <td>Rp. {{$tempToday[$key]}},00</td>
                                    <td>
                                        @if ($restaurant->trashed())
                                            <a href="{{url("admin/restaurant/banRestaurant/$restaurant->id")}}" class="btn btn-success">Unban</a>
                                        @else
                                            <a href="{{url("admin/restaurant/banRestaurant/$restaurant->id")}}" class="btn btn-danger">Ban</a>
                                        @endif
                                        <div class="btn btn-success">
                                            Detail
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js_script')

    <script>
        $(document).ready(function(){
            console.log('Welcome Admin!');

        });
    </script>
@endsection
