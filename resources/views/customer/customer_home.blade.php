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

        .banner{
            height: 60vh;
        }
        .banner_text .title{
            font-size: 3.5em;
        }
        .banner_text .subtitle{
        }
        @media (max-width: 1025px){
            .banner{
                height: 100%;
            }
            .banner_text .title{
                font-size: 3em;
            }
        }
        @media (max-width: 481px){
            .banner{
                height: 100%;
            }
            .banner_text .title{
                font-size: 2.5em;
            }
        }

    </style>
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section("header")
    @include('partial.flashMessage')
@endsection

@section('content')
    <div class="container">
        {{-- NAVBAR --}}
        @include('customer.partial.navbar')
        {{-- JUMBOTRON --}}
        <div class="jumbotron banner row m-0 w-100">
            <div class="col-md-12 col-lg-6 d-flex justify-content-end align-items-center d-lg-none ">
                <img src="{{asset('storage/images/customer/banner1.png')}}" width="100%" alt="">
            </div>
            <div class="col-md-12 col-lg-6 d-flex justify-content-end align-items-center" >
                <div class="left_content">

                    {{-- BANNER TEXT --}}
                    <div class="banner_text">
                        <p class="title text-end" style="font-family: helvetica_bold">A New Way</p>
                        <p class="title text-end" style="font-family: helvetica_bold;margin-top:-20px;">To Order a Table</p>
                        <p class="subtitle text-end" style="font-family: helvetica_regular;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum dignissimos nobis ad sequi aliquid impedit iusto officia ea enim? Cum eius dolore labore tempore assumenda, quia quas cupiditate? Officia, voluptatum.</p>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{route('customer_search')}}">
                            <div class="btn me-2" style="background-color: #ed3b27;color:white;">Explore Restaurant</div>
                        </a>
                        <a href="{{route('customer_favorite')}}">
                            <div class="btn" style="border:1px solid #ed3b27; color: #ed3b27;">Favorite</div>
                        </a>
                    </div>


                </div>
            </div>
            <div class="col-md-12 col-lg-6 d-flex justify-content-end align-items-center d-none d-lg-flex">
                <img src="{{asset('storage/images/customer/banner1.png')}}" width="100%" alt="">
            </div>
        </div>
        {{-- EASY ACCESS --}}
        <div class="easy-access mt-3 px-5 py-4 rounded-3 bg-dark">
            <h3 class="text-light" style="font-family: helvetica_bold">Book a Table</h3>

            <form class="mt-3" method="POST" action="/customer/checkAvailability">
                @csrf
                <div class="row m-0">
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="mb-3">
                            <input type="text" class="form-control p-3" id="restaurant_name" name="restaurant_name" placeholder="Restaurant Name">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="mb-3">
                            <input type="text" class="form-control p-3" id="restaurant_description" name="restaurant_desc" placeholder="Asian, Steak, etc...">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                        <div class="mb-3">
                            <input type="time" class="form-control p-3" id="reservation_time" name="reservation_time">
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-3">
                        <button type="submit" class="btn text-light w-100 p-3" style="background-color: #ed3b27">Check Availability</button>
                    </div>
                </div>
            </form>
        </div>
        {{-- PARALAX --}}
        <div class="paralax mt-5">
            <div class="row m-0">
                <div class="col-sm-12 col-md-6 col-lg-3 text-center rounded-4 p-4" >
                    <img src="{{asset('storage/images/customer/home/order.png')}}" alt="">
                    <h3>Order</h3>
                    <p class="my-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis repellendus aspernatur voluptatem ex ea minima.</p>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 text-center rounded-4 p-4">
                    <img src="{{asset('storage/images/customer/home/ticket.png')}}" alt="">
                    <h3>Ticket</h3>
                    <p class="my-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro, cumque nesciunt dolorem hic fugit officiis.</p>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 text-center rounded-4 p-4">
                    <img src="{{asset('storage/images/customer/home/meet.png')}}" alt="">
                    <h3>Confirm</h3>
                    <p class="my-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis repellendus aspernatur voluptatem ex ea minima.</p>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 text-center rounded-4 p-4">
                    <img src="{{asset('storage/images/customer/home/dine.png')}}" alt="">
                    <h3>Dine</h3>
                    <p class="my-2">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis repellendus aspernatur voluptatem ex ea minima.</p>
                </div>
            </div>
        </div>
        {{-- JUMBOTRON --}}
        <div class="jumbotron banner row m-0 w-100 mb-5">
            <div class="col-md-12 col-lg-6 d-flex justify-content-end align-items-center">
                <img src="{{asset('storage/images/customer/banner2.png')}}" width="100%" alt="">
            </div>
            <div class="col-md-12 col-lg-6 d-flex justify-content-end align-items-center" >
                <div class="right_content">

                    {{-- BANNER TEXT --}}
                    <div class="banner_text">
                        <p class="title text-start " style="font-family: helvetica_bold">Restaurant Owner?</p>
                        <p class="title text-start " style="font-family: helvetica_bold;margin-top:-20px;">Open Table now!</p>
                        <p class="subtitle text-start " style="font-family: helvetica_regular;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum dignissimos nobis ad sequi aliquid impedit iusto officia ea enim? Cum eius dolore labore tempore assumenda, quia quas cupiditate? Officia, voluptatum.</p>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-start mt-4">
                        <a href="/customer/register_restaurant" style="text-decoration: none">
                            <div class="btn me-2" style="background-color: #ed3b27;color:white;">Create Restaurant Account</div>
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="about_us bg-dark text-light">
        <div class="container">
            <div class="py-5">
                <div class="row m-0">
                    <div class="col">
                        <p class="m-0" style="font-size: 1.5em;font-family: helvetica_regular;">Contacts</p>
                        <p class="mt-3" style="color: rgb(200, 200, 200);">
                            Address : <br>
                            Jl. Ngagel Jaya Tengah No.73-77, Baratajaya, Kec. Gubeng, Kota SBY, Jawa Timur 60284
                            <br><br>
                            Phone : <br>
                            ISTTS - 082122907788 <br>
                            Albertus Marco - 0817305455 <br>
                            Andrew Anderson - 081298771483 <br>
                            Antonio Christopher - 085755115331 <br>
                            Ian William - 089674436016 <br>

                        </p>
                    </div>
                    <div class="col">
                        <p class="m-0" style="font-size: 1.5em;font-family: helvetica_regular;">Menu</p>
                        <div class="mt-3">
                            <p><span class="navigation">Home</span> </p>
                            <p><span class="navigation">Search</span> </p>
                            <p><span class="navigation">Favorite</span> </p>
                            <p><span class="navigation">History</span> </p>
                            <p><span class="navigation">Profile</span> </p>

                        </div>
                    </div>
                    <div class="col-6 d-none d-md-block">
                        <p class="m-0" style="font-size: 1.5em;font-family: helvetica_regular;">Reviews</p>
                        <form class="mt-3" action="">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control p-3" placeholder="Please kindly review our service :)">
                                <button type="submit" class="btn text-light p-3" style="background-color: #ed3b27">Submit Review</button>
                            </div>
                        </form>

                        <p class="my-1" style="color: rgb(200, 200, 200);">
                            If you want to know more about our developer. <a href="">Click me!</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="copyright text-center">
                <p class="m-0 py-3" style="color: rgb(200, 200, 200);">
                    &copy; 2022. Institut Sains dan Teknologi Terpadu Surabaya
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js_script')

    <script>
        $(document).ready(function(){
            console.log('Welcome Customer!');

        });
    </script>
@endsection
