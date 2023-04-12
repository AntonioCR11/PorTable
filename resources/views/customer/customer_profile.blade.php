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

{{--
    MOHON DIBACA YA SOBAT - SOBAT !!!!
    user = Variabel buat ambil data user yang lagi log in
--}}

@extends('layouts.layout')

@section('pagename')
    Portable
@endsection
@php

@endphp
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('build/css/customer_home.css') }}">
    <style>
        .navigation:hover {
            transform: scale(1.2);
            font-weight: 600;
            cursor: pointer;
        }

        .content{
            height: calc(100vh - 80px);
        }
        @media (max-width: 1025px){
            .content{
                height: 100%;
            }
        }
        @media (max-width: 481px){

        }
    </style>
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
{{-- GET NUMBER VALUE --}}
@php
    $phone = '';
    $number = '1234567890';
    $arrNum = str_split($number);

    foreach (str_split($user['phone']) as $num) {
        if (Str::contains($num, $arrNum)) {
            // if(str_contains($num,$arrNum)){
            $phone .= $num;
            // dump(Str::contains($num, $arrNum));
        }
    }
    $arrName = explode(' ',$user['full_name']);
@endphp
@section('content')
    <div class="container">
        {{-- NAVBAR --}}
        @include('customer.partial.navbar')
        {{-- CONTENT --}}
        <div class="content py-4" style="">
            <div class="row m-0 h-100">
                {{-- LEFT CONTENT --}}
                <div class="col-sm-12 col-md-6 h-100 mb-4">

                    <form action="{{url('customer/editProfile')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="mb-3">
                            <p class="m-0" style="font-size: 2.5em;font-weight: bold;">Profile</p>
                            <p class="m-0">Update your profile photo and personal details here</p>
                        </div>

                        {{-- IMAGE --}}
                        <div class="row mb-3">
                            <div class="col-4 d-flex align-items-center">
                                <p class="m-0 ">Profile Picture</p>
                            </div>
                            <div class="col d-flex">
                                <div class="row m-0 w-100">
                                    <div class="col-sm-6 col-lg-4">
                                        <img class="dropdown-toggle" role="button" data-bs-toggle="dropdown" src="{{ asset('storage/images/customer/'.$user['full_name'].'/pp.jpg') }}" alt="" width="70px" height="70px" style="border-radius: 50%">
                                    </div>
                                    <div class="col-sm-12 col-lg-8 p-0">
                                        <label class="form-label">Upload user photo(file of jpg/png/jpeg): </label>
                                        <input type="file" name="foto" id="" class="form-control w-100">
                                        @error('foto')
                                            @include('partial.validationMessage')
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- NAME --}}
                        <div class="row mb-3">
                            <div class="col-4 d-flex align-items-center">
                                <p class="m-0">Username</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ $user['username'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 d-flex align-items-center">
                                <p class="m-0">First Name</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <input type="text" class="form-control" id="firstname" name="firstname"
                                    value="{{ $arrName[0] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 d-flex align-items-center">
                                <p class="m-0">Last Name</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <input type="text" class="form-control" id="lastname" name="lastname"
                                    value="{{ $arrName[1] }}">
                            </div>
                        </div>
                        {{-- PHONE ADDRESS --}}
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="m-0">Phone Number</p>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="{{ intval($phone) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 d-flex align-items-center">
                                <p class="m-0">Address</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ $user['address'] }}">
                            </div>
                        </div>
                        {{-- BIRTHDATE --}}
                        <div class="row mb-3">
                            <div class="col-4">
                                <p class="m-0">Date of Birth</p>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" id="date" name="birthdate"
                                    value="{{ $user['date_of_birth'] }}">
                            </div>
                        </div>
                        {{-- PASSWORD --}}
                        <div class="row mb-3">
                            <div class="col-4 d-flex align-items-center">
                                <p class="m-0">Password</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>

                        <button type="submit" class="submit btn p-2 text-light w-100" style="background-color: #ed3b27">
                            Update Profile
                        </button>
                    </form>

                </div>

                {{-- RIGHT CONTENT --}}
                <div class="col-sm-12 col-md-6 h-100 overflow-auto d-flex flex-column" >
                    <div class="mb-3">
                        <p class="m-0" style="font-size: 2em;font-weight: bold;">Upcoming Reservation</p>
                        <p class="m-0">This is the ticket of your closest date table reservation</p>
                    </div>
                    <div id="reservation_container" class="reservation_container d-flex">
                        @if ($activeReservation != null)
                            <div class="ticket">
                                {{-- TEMPLATE CARD --}}
                                <div class="mb-3 me-2 w-100" style="position: relative;">
                                    <a class="text-dark p-0"  style="text-decoration: none;" href="/customer/restaurant/{{$activeReservation->restaurant->full_name}}">
                                        {{-- RESTAURANT EVENT --}}
                                        <div class="number_container" style="position: absolute;top:30px;right:5%;">
                                            <div class="event_label text-light p-3 rounded-3 text-center navigation" style="background-color: #6C4AB6; ">{{$activeReservation->table->seats}}</div>
                                            <div class="cancel_container">
                                                {{-- CANCEL BTN --}}
                                                <a id="opencancel_{{$activeReservation->id}}" onclick="opencancel({{$activeReservation->id}})" >
                                                    <button class="btn event_label text-light p-1 rounded-3 text-center navigation" style="background-color: #ed3b27; ">Cancel</button>
                                                </a>
                                                {{-- CONFIRMATION --}}
                                                <div id="cancelconfirmation_{{$activeReservation->id}}" class="cancel_confirmation bg-light p-2 rounded-3 d-none">
                                                    <p class="m-0">Cancel?</p>
                                                    <a onclick="cancel_reservation({{$activeReservation->id}})" >
                                                        <button class="btn event_label text-light p-1 rounded-3 text-center navigation" style="background-color: #06c700; ">Yes</button>
                                                    </a>
                                                    <a onclick="closecancel({{$activeReservation->id}})" >
                                                        <button class="btn btn-dark m-0 event_label text-light p-1 rounded-3 text-center navigation">No</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- CARD CONTENT --}}
                                        <div class="restaurant_card bg-light p-3" >
                                            <div class="image_container" style="height: 15rem">
                                                @php
                                                    $activeReservation_restaurant = $activeReservation->restaurant->full_name;
                                                @endphp
                                                <img class="" src="{{asset("storage/images/restaurant/$activeReservation_restaurant/restaurant_1.jpg")}}" alt="" width="100%" height="100%">
                                            </div>

                                            {{-- RESTAURANT INFO --}}
                                            <div class="row m-0 mt-2 overflow-auto" style="height: 6rem">
                                                <div class="col-10">
                                                    <div class="restaurant_info" >
                                                        <p class="m-0" style="font-family: helvetica_bold;font-size: 1.5em">{{$activeReservation->restaurant->full_name}}</p>
                                                        <p class="m-0" style="font-family: helvetica_regular;font-size: 0.8em;color: rgb(111, 111, 111);">{{$activeReservation->restaurant->description}}</p>
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
                                                    <p class="m-0" style="font-family: helvetica_regular;">Order Price : Rp {{$activeReservation->restaurant->price}}</p>
                                                    <p class="m-0" style="font-family: helvetica_regular;">Reservation date : {{$activeReservation->reservation_date_time}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        @else
                            <div class="d-flex w-100 justify-content-start">
                                <p class="m-0">You don't have any transaction right now</p>
                            </div>
                        @endif
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
        $(document).ready(function() {
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
                url: "/customer/cancelClosestUpcomingTransaction",
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
