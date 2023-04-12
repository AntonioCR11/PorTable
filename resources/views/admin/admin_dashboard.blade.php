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
    <link rel="stylesheet" href="{{asset('build/css/admin_dashboard.css')}}">
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
                <div class="col d-flex align-items-center">
                    <div class="searchBar w-75">
                        <form action="/admin/dashboard/search" class="d-flex" role="search" method="POST">
                            @csrf
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword">
                            <button class="btn border-0" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                              </svg>
                            </button>
                        </form>
                    </div>
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
            <div class="row m-0 p-0 mt-3" >
                <div class="col">
                        <div class="overview_1 p-4 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center">
                                <img class="bg-light rounded-3 p-2 me-3" src="{{asset("storage/images/admin/sale.png")}}" alt="" width="60px">
                                <div class="">
                                    <p class="m-0">Total Sales</p>
                                    <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end w-100">
                                <h1 class="font-weight-bold">Rp. {{$totaltransactions[0]->sum}},00</h1>
                            </div>
                        </div>
                </div>
                <div class="col">
                        <div class="overview_2 p-4 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center">
                                <img class="bg-light rounded-3 p-2 me-3" src="{{asset("storage/images/admin/order.png")}}" alt="" width="60px">
                                <div class="">
                                    <p class="m-0">Total Orders</p>
                                    <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end w-100">
                                <h1 class="font-weight-bold">{{$countTotalOrder}}</h1>
                            </div>
                        </div>
                </div>
                <div class="col">
                        <div class="overview_3 p-4 mb-3 mb-lg-0">
                            <div class="d-flex align-items-center">
                                <img class="bg-light rounded-3 p-2 me-3" src="{{asset("storage/images/admin/growth.png")}}" alt="" width="60px">
                                <div class="">
                                    <p class="m-0">Audience Growth</p>
                                    <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end w-100">
                                <h1 class="font-weight-bold">{{$audienceGrowth->count()}}</h1>
                            </div>
                        </div>
                </div>
            </div>

            {{-- TOP SALES RESTAURANT TABLE, ACTIVITY --}}
            <div class="row m-0 p-0">
                <div class="col-sm-12 col-lg-8">
                    <h3 class="mt-3">Top Sales Restaurant</h3>
                    <table class="table table-striped mt-3">
                        <thead class="bg-dark text-light">
                            <th>No.</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Total Income</th>
                            <th>Total Order</th>
                        </thead>
                        <tbody>
                            @foreach ($topSales as $key=>$topSale)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$topSale->full_name}}</td>
                                    <td>{{$topSale->address}}</td>
                                    <td>Rp. {{$totalIncome[$key]->sum}},00</td>
                                    <td>{{$temp[$key]}} Orders</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-lg-4">
                        <h3 class="mt-3">Customer Activity</h3>
                        <div class="bg-dark p-4 rounded-3">
                            <select class="form-select w-50 mb-3" aria-label="Default select example">
                                <option value="1">Daily</option>
                                <option value="2">Weekly</option>
                                <option value="3">Monthly</option>
                            </select>

                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 75%;background-color:rgb(186,226, 4);" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 25%;background-color:rgb(186,226, 4);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 50%;background-color:rgb(186,226, 4);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 75%;background-color:rgb(186,226, 4);" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" aria-label="Basic example" style="width: 100%;background-color:rgb(186,226, 4);" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>
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
