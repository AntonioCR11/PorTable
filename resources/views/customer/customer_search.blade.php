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
    {{-- <link rel="stylesheet" href="{{asset('build/css/customer_home.css')}}"> --}}
    <style>
        .navigation:hover{
            transform: scale(1.2);
            font-weight: 600;
            cursor: pointer;
        }
    </style>
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
    {{-- RESERVATION POP_UP --}}
    @include('customer.partial.reservation_popup')

    <div class="container" style="height: 100vh;">
        {{-- NAVBAR --}}
        @include('customer.partial.navbar')

        {{-- CONTENT --}}
        <div class="content pb-3 overflow-auto" style="height: calc(100vh - 98px)">
            {{-- SEARCH BAR --}}
            <div class="p-3 w-100">
                <form action="/customer/searchRestaurant" class="d-flex justify-content-center" role="search" method="POST">
                    @csrf
                    <input class="form-control w-50" type="text" placeholder="Search" aria-label="Search" name="keyword">
                    <button class="btn border-0 navigation" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                      </svg>
                    </button>
                </form>
            </div>
            {{-- CATALOG --}}
            <div class="catalog">
                <div class="row m-0">
                    {{-- FILTER --}}
                    <div class="col-sm-12 d-none d-sm-block col-lg-3 border-end">
                        <h3 style="font-family: helvetica_bold">Filter</h3>
                        <form action="/customer/filterRestaurant" style="font-family: helvetica_regular" method="POST">
                            @csrf
                            <input type="hidden" value="{{$keyword}}" name="keyword">
                            <div class="price mt-3">
                                <p class="m-0" style="font-family: helvetica_regular;color: rgb(111, 111, 111);">Price Range</p>
                                <div class="input-group">
                                    <input type="text" aria-label="First name" class="form-control" placeholder="From" name="start_price">
                                    <input type="text" aria-label="Last name" class="form-control" placeholder="To" name="end_price">
                                </div>
                            </div>
                            {{-- <div class="establishment mt-3">
                                <p class="m-0" style="font-family: helvetica_regular;color: rgb(111, 111, 111);">Establishment Type</p>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="0">Any</option>
                                    <option value="1">Restaurant</option>
                                    <option value="2">Bar/Pub</option>
                                    <option value="3">Cafee</option>
                                  </select>
                            </div> --}}

                            <div class="description mt-3">
                                <p class="m-0" style="font-family: helvetica_regular;color: rgb(111, 111, 111);">Description</p>
                                <input type="text" class="form-control" placeholder="Asian, Indonesian, Steak, Etc..." name="description">
                            </div>
                            <div class="location mt-3">
                                <p class="m-0" style="font-family: helvetica_regular;color: rgb(111, 111, 111);">Location</p>
                                <input type="text" class="form-control" placeholder="..." name="location">
                            </div>
                            <button type="submit" class="btn text-light w-100 mt-3" style="background-color: #ed3b27" >Filter!</button>
                        </form>
                    </div>
                    {{-- RESTAURANT LIST --}}
                    <div class="col">
                        <div class="row m-0">
                            @forelse ($restaurants as $restaurant)
                                {{-- TEMPLATE CARD --}}
                                <div class="col-sm-6 col-lg-4 mb-3" style="position: relative;">

                                        {{-- RESTAURANT EVENT --}}
                                        <div class="event_container w-100" style="position: absolute;top:30px;">
                                            @php
                                                // CHECK NEW STATUS
                                                $created_at = substr($restaurant->created_at,8,2);
                                                $date_now = date("d");
                                                $diffrence = $date_now - $created_at;
                                            @endphp

                                            @if ($diffrence < 7)
                                                <div class="event_label text-light w-25 px-2 rounded-end" style="background-color: #06c700;">New</div>
                                            @endif
                                            @if(in_array($restaurant->id, $bestSellerRestaurantId))
                                                <div class="event_label text-light w-50 px-2 rounded-end" style="background-color: #6C4AB6; ">Best Seller</div>
                                            @endif

                                        </div>
                                        {{-- CARD CONTENT --}}
                                        <div class="restaurant_card bg-light p-3" >
                                            <div class="image_container" style="height: 11rem">
                                                <a class="text-dark p-0"  style="text-decoration: none;" href="/customer/restaurant/{{$restaurant->full_name}}">
                                                    <img class="navigation" src="{{asset("storage/images/restaurant/$restaurant->full_name/restaurant_1.jpg")}}" alt="" width="100%" height="100%">
                                                </a>
                                            </div>

                                            {{-- RATING AND FAVORITE --}}
                                            <div class="row m-0">
                                                <div class="col-6 p-0 d-flex align-items-center">
                                                    @for ($i=0;$i<floor($restaurant->average_rating);$i++)
                                                        <img src="{{asset('storage/images/customer/search/star.png')}}" alt="" width="15%">
                                                    @endfor
                                                    <span class="ms-2">{{$restaurant->average_rating}}</span>
                                                </div>
                                                <div class="col-6 p-0 text-end">
                                                    @if(in_array($restaurant->id, $likelistId))
                                                        <a onclick="like_dislike({{$restaurant->id}},{{activeUser()->id}})">
                                                            <img id="dislike_{{$restaurant->id}}" class="navigation" src="{{asset('storage/images/customer/search/fav_filled.png')}}" alt="" width="15%">
                                                        </a>
                                                    @else
                                                        <a onclick="like_dislike({{$restaurant->id}},{{activeUser()->id}})">
                                                            <img id="like_{{$restaurant->id}}" class="navigation" src="{{asset('storage/images/customer/search/fav.png')}}" alt="" width="15%">
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- RESTAURANT INFO --}}
                                            <div class="restaurant_info overflow-auto mb-1" style="height: 4.5rem">
                                                <a class="text-dark p-0"  style="text-decoration: none;" href="/customer/restaurant/{{$restaurant->full_name}}">
                                                    <p class="m-0 mt-2" style="font-family: helvetica_regular">{{$restaurant->full_name}}</p>
                                                </a>
                                                <p class="m-0" style="font-family: helvetica_regular;font-size: 0.8em;color: rgb(111, 111, 111);">{{$restaurant->address}}</p>
                                                <p class="m-0" style="font-family: helvetica_regular;font-size: 0.8em;color: rgb(111, 111, 111);">Description : {{$restaurant->description}}</p>
                                            </div>


                                            {{-- PRICE AND RESERVE BUTTON --}}
                                            <div class="d-flex w-100">
                                                <div class="px-3 rounded-pill bg-dark" >
                                                    <p class="m-0 text-light h-100 d-flex align-items-center" style="font-family: helvetica_regular;font-size: 0.8em" >Open at {{$restaurant->start_time}}
                                                        @if ($restaurant->start_time < 12)
                                                            am
                                                        @else
                                                            pm
                                                        @endif
                                                    </p>
                                                </div>

                                                <a class="text-dark d-flex ms-auto" style="text-decoration: none">
                                                    <button class="btn btn-outline-warning" onclick="open_popup({{$restaurant->id}})">Reserve</button>
                                                </a>
                                            </div>

                                        </div>
                                </div>
                            @empty
                                <div class="d-flex w-100 justify-content-center">
                                    <p class="m-0">There is no restaurant registered!</p>
                                </div>
                            @endforelse
                        </div>

                        {{-- PAGINATION --}}
                        <div class="d-flex justify-content-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {{-- PREV --}}
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <li class="page-item"><a class="page-link bg-dark text-light" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
                                    {{-- NEXT --}}
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- <div class="about_us bg-dark text-light">
        <div class="container">
            <div class="copyright text-center">
                <p class="m-0 py-3" style="color: rgb(200, 200, 200);">
                    &copy; 2022. Institut Sains dan Teknologi Terpadu Surabaya
                </p>
            </div>
        </div>
    </div> --}}
@endsection

@section('js_script')
    <script>
        $(document).ready(function(){
            console.log('Welcome Customer!');
        });
        function open_popup(id){
            $(".popup_container").removeClass("d-none",function(){
                let restaurant_id = id;
                generatePopUpDetail(restaurant_id,Date.now());
            });
        }
        function close_popup(){
            // CLOSE POP UP
            $(".popup_container").addClass("d-none");
            $(".blank").animate({height : '90vh'});
        }
        function generatePopUpDetail(restaurant_id,reservation_date){
            let map_generated = false;
            let form_generated = false;

            // TODAY DATE
            var today = new Date();
            var currentDate = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate();

            // MAP AJAX
            $.ajax({
                type: "get",
                url: "/customer/generateMap",
                data: {
                    'restaurant_id': restaurant_id,
                    'reservation_date': currentDate
                },
                success: function(response) {
                    // GENERATE MAP
                    $("#map_container").html(response);
                    map_generated = true;
                },
            });
            // FORM AJAX
            $.ajax({
                type: "get",
                url: "/customer/generateForm",
                data: {
                    'restaurant_id': restaurant_id
                },
                success: function(response) {
                    // GENERATE TIME
                    $("#form_container").html(response);
                    form_generated = true;
                },
            });
            // REQUEST TIMEOUT
            let ctr = 0;
            let timer = setInterval(() => {
                if(map_generated && form_generated){
                    // OPEN POP UP
                    $(".popup").css("height","90vh");
                    $(".blank").animate({height : '0vh'},"slow");
                    clearInterval(timer);
                }else if(ctr == 5){
                    alert("Server error!");
                    clearInterval(timer);
                }
                ctr++;
            }, 1000);
        }

        // SELECT AVAILABLE TABLE and AVAILABLE TIME
        let last_selected_table = -1;
        let last_selected_time = -1;
        function tableClicked(tableId){
            if(last_selected_table > -1){ $("#table_"+last_selected_table).css("backgroundColor","#6C4AB6"); }
            $("#table_"+tableId).css("backgroundColor","#FEB139");
            $("#selected_table").val(tableId);
            last_selected_table = tableId;
        }
        function timeClicked(time){
            if(last_selected_time > -1){
                // BG
                $("#time_"+last_selected_time).removeClass("btn-dark");
                $("#time_"+last_selected_time).addClass("btn-outline-dark");
            }
            $("#time_"+time).removeClass("btn-outline-dark");
            $("#time_"+time).addClass("btn-dark");

            $("#selected_time").val(time);
            last_selected_time = time;
        }
        function like_dislike(restaurant_id,user_id){
            $.ajax({
                type: "get",
                url: "/customer/like_dislike",
                data: {
                    'user_id': user_id,
                    'restaurant_id': restaurant_id
                },
                success: function(response) {
                    // TOGGLE FAV BUTTON
                    if(response == "1"){
                        $("#like_"+restaurant_id).prop("src","{{asset('storage/images/customer/search/fav_filled.png')}}");
                        $("#like_"+restaurant_id).prop("id","dislike_"+restaurant_id);
                    }else{
                        $("#dislike_"+restaurant_id).prop("src","{{asset('storage/images/customer/search/fav.png')}}");
                        $("#dislike_"+restaurant_id).prop("id","like_"+restaurant_id);
                    }
                },
            });
        }
        function changeReservationDate(restaurant_id,reservation_date){
            // GENERATE MAP BASED ON DATE VALUE AJAX
            $.ajax({
                type: "get",
                url: "/customer/generateMap",
                data: {
                    'restaurant_id': restaurant_id,
                    'reservation_date': reservation_date
                },
                success: function(response) {
                    // GENERATE MAP
                    $("#map_container").html(response);
                    map_generated = true;
                },
            });
        }
    </script>
@endsection
