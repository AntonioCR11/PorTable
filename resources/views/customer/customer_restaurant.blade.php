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
        .info{
            background-image: linear-gradient( rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2));
            position: absolute;
            z-index:2;
            width: 100%;
            height: 100%;
        }
    </style>

    {{-- Make the google material symbols filled --}}
    <style>
        .material-symbols-outlined {
            font-variation-settings:
            'FILL' 1,
            'wght' 400,
            'GRAD' 0,
            'opsz' 48
        }
    </style>

@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
    {{-- RESERVATION POP_UP --}}
    @include('customer.partial.reservation_popup')

    <div class="container" style="heigh: 100vh;">
        {{-- NAVBAR --}}
        @include('customer.partial.navbar')

        {{-- CAROUSEL --}}
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false" style="height: 70vh;">
            <div class="info text-light">
                <h1 style="font-family: helvetica_bold; position: absolute;top: 5%;left: 5%;z-index:3;">
                    <a href="/customer/explore" style="text-decoration: none;">
                        <span class="btn btn-outline-light p-0">
                            <img src="{{asset("storage/images/customer/back.png")}}" width="30px" height="30px">
                        </span>
                    </a>
                    {{$restaurant->full_name}}
                </h1>

                {{-- NEXT PREV BUTTON --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            {{-- IMAGE --}}
            <div class="carousel-inner h-100">
              <div class="carousel-item active">
                <img src="{{asset("storage/images/restaurant/$restaurant->full_name/restaurant_1.jpg")}}" class="d-block w-100" alt="...">
              </div>

              <div class="carousel-item">
                <img src="{{asset("storage/images/restaurant/$restaurant->full_name/restaurant_2.jpg")}}" class="d-block w-100" alt="...">
              </div>

              <div class="carousel-item">
                <img src="{{asset("storage/images/restaurant/$restaurant->full_name/restaurant_3.jpg")}}" class="d-block w-100" alt="...">
              </div>
            </div>

        </div>
        {{-- TIME --}}
        <div class="easy_access bg-dark text-light px-5 d-flex align-items-center" style="height: calc(30vh - 80px)">
            <div class="row m-0 w-100">
                <div class="col-sm-12 col-lg-6">
                    <h3 class="text-light">Available time</h3>
                    <div class="time_available mt-3">
                        @for ($i = 0; $i<$restaurant->shifts;$i++)
                            <button class="btn btn-outline-light mb-1" >
                                {{$restaurant->start_time+$i.": 00"}}
                            </button>
                        @endfor
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <h3 class="text-light">Description</h3>
                    <p class="m-0" style="font-family: helvetica_regular;color: rgb(111, 111, 111);">{{$restaurant->address}}</p>
                    <p class="m-0" style="font-family: helvetica_regular;color: rgb(111, 111, 111);">{{$restaurant->phone}}</p>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <button class="btn btn-light h-100 w-100" onclick="open_popup({{$restaurant->id}})">Book table!</button>
                </div>
            </div>
        </div>

        {{-- Reviews --}}
        <div id="reviews" class="container-fluid bg-dark px-5 py-3">
            {{-- Restaurant Reviews --}}
            <h1 class="text-white mb-3">Reviews</h1>

            {{-- Authenticated Review --}}
            @if ($canReview)
                {{-- If user can review, show the review box --}}
                @if (isset($userReview))
                    <hr class="text-light">
                    <h3 class="text-white">Your Review</h3>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card-title">
                                <h5><span class="material-symbols-outlined me-2" style="vertical-align: text-bottom">account_circle</span>{{ $userReview->user->full_name }}</h5>
                            </div>
                            <div class="review-container">
                                <div class="rating-container">
                                    @for ($i = 0; $i < $userReview->rating; $i++)
                                        <span class="material-symbols-outlined text-warning" style="vertical-align: text-bottom">star_rate</span>
                                    @endfor
                                    <span>{{ date_format(date_create($userReview->updated_at), "d/m/Y") }}</span>
                                </div>
                                <div class="card-text">{{ $userReview->message }}</div>
                                <div class="d-flex justify-content-end"><button id="editReview" class="btn btn-dark" onclick="editReview(event)">Edit</button></div>
                            </div>
                            <div id="editForm" class="d-none">
                                <div class="rating-container">
                                    <form action="/customer/editReview/{{ $restaurant->id }}" method="POST">
                                        @csrf
                                        <div class="row mt-2">
                                            <div class="col-auto d-inline-flex align-items-center">
                                                <label for="rating" class="me-2">Rating:</label>
                                                <input type="number" name="rating" id="rating" class="form-control" value="{{ $userReview->rating }}" max="5" min="1" required>
                                            </div>
                                        </div>
                                        @error('rating')
                                            <div class="text-danger mb-2"><em>{{ $message }}</em></div>
                                        @enderror
                                        <div class="form-floating mt-2">
                                            <textarea class="form-control" placeholder="Leave a rating message" id="ratingMessage" name="message">{{ $userReview->message }}</textarea>
                                            <label for="ratingMessage">Message</label>
                                        </div>
                                        <input type="submit" value="Submit" class="btn btn-primary mt-2">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title"><h3>Write your review:</h3></div>
                        <div class="rating-container">
                            <form action="/customer/addReview/{{ $restaurant->id }}" method="POST">
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-auto d-inline-flex align-items-center">
                                        <label for="rating" class="me-2">Rating:</label>
                                        <input type="number" name="rating" id="rating" class="form-control" max="5" min="1" required>
                                    </div>
                                </div>
                                @error('rating')
                                    <div class="text-danger mb-2"><em>{{ $message }}</em></div>
                                @enderror
                                <div class="form-floating mt-2">
                                    <textarea class="form-control" placeholder="Leave a rating message" id="ratingMessage" name="message"></textarea>
                                    <label for="ratingMessage">Message</label>
                                </div>
                                <input type="submit" value="Submit" class="btn btn-primary mt-2">
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <hr class="text-light">
                <h3 class="text-white">Other Reviews:</h3>
            @endif

            @foreach ($restaurantReviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title">
                            <h5><span class="material-symbols-outlined me-2" style="vertical-align: text-bottom">account_circle</span>{{ $review->user->full_name }}</h5>
                        </div>
                        <div class="rating-container">
                            @for ($i = 0; $i < $review->rating; $i++)
                                <span class="material-symbols-outlined text-warning" style="vertical-align: text-bottom">star_rate</span>
                            @endfor
                            <span>{{ date_format(date_create($review->updated_at), "d/m/Y") }}</span>
                        </div>
                        <div class="card-text">{{ $review->message }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- FOOTER --}}
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
                generatePopUpDetail(restaurant_id);
            });
        }
        function close_popup(){
            // CLOSE POP UP
            $(".popup_container").addClass("d-none");
            $(".blank").animate({height : '90vh'});
        }
        function generatePopUpDetail(restaurant_id){
            let map_generated = false;
            let form_generated = false;

            // MAP AJAX
            $.ajax({
                type: "get",
                url: "/customer/generateMap",
                data: {
                    'restaurant_id': restaurant_id
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

        /**
         * Hide the static display of the authenticated user display and show a form to change the user review.
         *
         * @param {EventObject} event The event that is firing when editing the user review.
         */
        function editReview(event) {
            const reviewBody = event.target.parentNode.parentNode;
            const editForm = event.target.parentNode.parentNode.parentNode.querySelector("#editForm");
            reviewBody.innerHTML = "";
            editForm.classList.remove("d-none");
        }
    </script>
@endsection
