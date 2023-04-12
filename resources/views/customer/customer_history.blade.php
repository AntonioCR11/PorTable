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
    <div class="container">
        {{-- NAVBAR --}}
        @include('customer.partial.navbar')
        {{-- CONTENT --}}
        <div class="content py-4" style="height: calc(100vh - 80px)">
            <div class="row m-0">
                {{-- LEFT CONTENT --}}
                <div class="col-sm-12 col-md-7">
                    <div class="mb-3">
                        <p class="m-0" style="font-size: 2.5em;font-weight: bold;">History</p>
                        <p class="m-0">This is the transcipt/ ticket of all your reservation</p>
                    </div>

                    {{-- NOTIFICATION --}}
                    @foreach ($history as $transaction)
                        @php
                            $restaurant_name = $transaction->reservation->restaurant->full_name;
                        @endphp
                        <div class="bg-light rounded-4 p-4 my-4">
                            {{-- TEMPLATE CARD --}}
                            <div class="row h-100">
                                <div class="col-sm-12 col-lg-4 d-flex">
                                    <img class="" src="{{asset("storage/images/restaurant/$restaurant_name/restaurant_1.jpg")}}" alt="" width="100%">
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <div class="restaurant_info mb-2">
                                        <div class="row m-0">
                                            <div class="col p-0">
                                                <h4 class="m-0">{{$restaurant_name}}</h4>
                                            </div>
                                            <div class="col p-0 text-end">
                                                <p class="m-0">Reserve for : {{$transaction->reservation->reservation_date_time}}</p>
                                            </div>
                                        </div>
                                        <p class="m-0 text-secondary">{{$transaction->reservation->restaurant->description}}</p>
                                    </div>
                                    <div class="order_info">
                                        <p class="m-0">Table Number : {{$transaction->reservation->table->seats}}</p>
                                        <p class="m-0">Order Price : Rp. {{ number_format($transaction->payment_amount, 0, ",", ".") }}</p>

                                        @php
                                            // Check whether this customer has finished transaction when creating the reservation. If have, able to make a review.
                                            $pastSuccessfulResevation = DB::table('reservations')->where('user_id', '=', $transaction->user_id)->where('restaurant_id', '=', $transaction->reservation->restaurant_id)->where('payment_status', 1)->first();

                                            if (isset($pastSuccessfulResevation)) {
                                                // Check whether the customer has a review on this restaurant before or not...
                                                $pastReview = DB::table('reviews')->where('user_id', '=', $transaction->user_id)->where('restaurant_id', '=', $transaction->reservation->restaurant_id)->first();

                                                if (isset($pastReview)) {
                                                    @endphp
                                                    <a href="/customer/restaurant/{{$restaurant_name}}#reviews"><button class="btn text-light" style="background-color: #6C4AB6;">See Reviews</button></a>
                                                    @php
                                                }
                                            }
                                        @endphp
                                        {{-- <p class="m-0">Status : Pending</p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- RIGHT CONTENT --}}
                <div class="col-sm-12 col-md-5">
                    <div class="mb-3">
                        <p class="m-0" style="font-size: 2.5em;font-weight: bold;">Active Transaction</p>
                        <p class="m-0">This is the transcipt/ ticket of your last table reservation</p>
                    </div>
                    <div id="reservation_container" class="reservation_container d-flex" style="overflow-x: auto">
                        {{-- <div class="row m-0"> --}}
                            @forelse ($activeReservations as $reservation)
                                {{-- <div class="col-12"> --}}
                                    <div class="ticket">
                                        {{-- TEMPLATE CARD --}}
                                        <div class="mb-3 me-2 " style="position: relative;width: 400px">
                                            <a class="text-dark p-0"  style="text-decoration: none;" href="/customer/restaurant/{{$reservation->restaurant->full_name}}">
                                                {{-- RESTAURANT EVENT --}}
                                                <div class="number_container" style="position: absolute;top:30px;right:5%;">
                                                    <div class="event_label text-light p-3 rounded-3 text-center navigation" style="background-color: #6C4AB6; ">{{$reservation->table->seats}}</div>
                                                    <div class="cancel_container">
                                                        {{-- CANCEL BTN --}}
                                                        <a id="opencancel_{{$reservation->id}}" onclick="opencancel({{$reservation->id}})" >
                                                            <button class="btn event_label text-light p-1 rounded-3 text-center navigation" style="background-color: #ed3b27; ">Cancel</button>
                                                        </a>
                                                        {{-- CONFIRMATION --}}
                                                        <div id="cancelconfirmation_{{$reservation->id}}" class="cancel_confirmation bg-light p-2 rounded-3 d-none">
                                                            <p class="m-0">Cancel?</p>
                                                            <a onclick="cancel_reservation({{$reservation->id}})" >
                                                                <button class="btn event_label text-light p-1 rounded-3 text-center navigation" style="background-color: #06c700; ">Yes</button>
                                                            </a>
                                                            <a onclick="closecancel({{$reservation->id}})" >
                                                                <button class="btn btn-dark m-0 event_label text-light p-1 rounded-3 text-center navigation">No</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- CARD CONTENT --}}
                                                <div class="restaurant_card bg-light p-3" >
                                                    <div class="image_container" style="height: 15rem">
                                                        @php
                                                            $activeReservation_restaurant = $reservation->restaurant->full_name;
                                                        @endphp
                                                        <img class="" src="{{asset("storage/images/restaurant/$activeReservation_restaurant/restaurant_1.jpg")}}" alt="" width="100%" height="100%">
                                                    </div>

                                                    {{-- RESTAURANT INFO --}}
                                                    <div class="row m-0 mt-2 overflow-auto" style="height: 6rem">
                                                        <div class="col-10">
                                                            <div class="restaurant_info" >
                                                                <p class="m-0" style="font-family: helvetica_bold;font-size: 1.5em">{{$reservation->restaurant->full_name}}</p>
                                                                <p class="m-0" style="font-family: helvetica_regular;font-size: 0.8em;color: rgb(111, 111, 111);">{{$reservation->restaurant->description}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-2 d-flex justify-content-end align-items-center">
                                                            <p class="m-0">1</p>
                                                            <img  src="{{asset('storage/images/customer/person.png')}}" alt="" width="30px" height="30px">
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    {{-- TRANSACTION DETAIL --}}
                                                    <div class="code d-flex justify-content-end">
                                                        <div class="text-end">
                                                            {{-- <p class="m-0" style="font-family: helvetica_bold;font-size: 1.1em;">Transaction code : 1PKhfWqLiADhSb7</p> --}}
                                                            <p class="m-0" style="font-family: helvetica_regular;">Order Price : Rp {{$reservation->restaurant->price}}</p>
                                                            <p class="m-0" style="font-family: helvetica_regular;">
                                                                Reservation date : {{$reservation->reservation_date_time}}
                                                                @if (substr($reservation->reservation_date_time,11,2) < 12)
                                                                    am
                                                                @else
                                                                    pm
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                {{-- </div> --}}
                            @empty
                                <div class="d-flex w-100 justify-content-start">
                                    <p class="m-0">You don't have any transaction right now</p>
                                </div>
                            @endforelse

                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')

    <script>
        $(document).ready(function(){
            console.log('Welcome Customer!');

        });
        function opencancel(reservation_id){
            $("#opencancel_"+reservation_id).addClass("d-none");
            $("#cancelconfirmation_"+reservation_id).removeClass("d-none");
        }
        function closecancel(reservation_id){
            $("#cancelconfirmation_"+reservation_id).addClass("d-none");
            $("#opencancel_"+reservation_id).removeClass("d-none");
        }
        function cancel_reservation(reservation_id){
            // ACTIVE TRANSACTION AJAX
            $.ajax({
                type: "get",
                url: "/customer/cancelTransaction",
                data: {
                    'reservation_id': reservation_id
                },
                success: function(response) {
                    // GENERATE MAP
                    $("#reservation_container").html(response);
                },
            });
        }
    </script>
@endsection
