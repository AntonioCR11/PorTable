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
    PorTable
@endsection

@section('custom_css')
    <link rel="stylesheet" href="{{asset('build/css/index.css')}}">
    <style>
        .login_bg{
            background-image: linear-gradient(#9796F0 , #FBC7D4);
        }
        .register_bg{
            background-image: linear-gradient(#F09819 , #EDDE5D);
        }
        .mobile_mode{
            height: 100vh;
            overflow: hidden;
        }
    </style>
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
    {{-- FLASH MESSAGE --}}
    @include("partial.flashMessage")

    {{-- DESKTOP MODE : WIDTH >= 768px --}}
    <div class="desktop_mode login_bg" id="desktop_mode">
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="row m-0 w-75">
                {{-- JUMBOTRON  --}}
                {{-- COLOR : 6C4AB6 8D72E1 8D9EFF B9E0FF 7743DB --}}
                <div class="col-6 border-leftside d-flex align-items-center" style="background-color: #7743DB;" id="left_form">
                    <img class="" src="{{asset('storage/images/login/banner1.png')}}" alt="" width="100%" id="jumbotron">
                </div>
                {{-- FORM --}}
                <div class="col-6 p-5 border-rightside d-flex align-items-center" style="background-color: white;" id="right_form">

                    {{-- LOGIN FORM --}}
                    <div id="login_form_holder" class="login_form_holder w-100">
                        <div class="title">PorTable</div>
                        <p style="font-size: 1.1em">Order Table & Enjoy With Friend and Family, because food tasted better when you eat with them</p>

                        <form action="/checkLogin" method="POST">
                            @csrf
                            <div class="group">
                                <input class="w-100" type="text" name="username" value="{{old('username')}}"><span class="highlight"></span><span class="bar"></span>
                                <label>Username</label>
                                @error('username')
                                    @include('partial.validationMessage')
                                @enderror
                            </div>
                            <div class="group">
                                <input class="w-100" type="password" name="password" ><span class="highlight"></span><span class="bar"></span>
                                <label>Password</label>
                                @error('password')
                                    @include('partial.validationMessage')
                                @enderror
                            </div>
                            <input type="submit" class="submit btn p-2 text-light" value="Sign in" style="background-color: #6C4AB6" id="submit">
                        </form>
                        <p class="my-4" style="">By clicking the sign in button, you are agree to the Privacy and Policy, for more information you can read about our policy <a href="">here</a>.</p>

                        {{-- LOGIN REGISTER TOGGLER --}}
                        <div class="d-flex justify-content-end w-100">
                            <p class="m-0" id="indexToggleSubtitle">New member?</p> <span style="width: 10px"></span> <p class="indexToggle" style="cursor: pointer;color:#0d9efe;text-decoration: underline" id="indexToggle">Create account!</p>
                        </div>
                    </div>

                    {{-- REGISTER FORM --}}
                    <div id="register_form_holder" class="register_form_holder w-100 d-none">
                        <div class="title">Welcome to Portable!</div>
                        <p class="mb-4" style="font-size: 1.1em">Join us now, feel the convenience of ordering table!</p>

                        <form action="/checkRegister" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-6 group">
                                    <input class="w-100" type="text" name="firstname" value="{{old('firstname')}}" id="firstname"><span class="highlight"></span><span class="bar"></span>
                                    <label>Firstname</label>
                                </div>
                                <div class="col-6 group">
                                    <input class="w-100" type="text" name="lastname" value="{{old('lastname')}}" id="lastname"><span class="highlight"></span><span class="bar"></span>
                                    <label>Lastname</label>
                                </div>

                                <div class="col-6 group">
                                    <input class="w-100" type="text" name="username" value="{{old('username')}}" id="username"><span class="highlight"></span><span class="bar"></span>
                                    <label>Username</label>
                                </div>

                                <div class="col-6 group">
                                    <input class="w-100" type="text" name="phone" value="{{old('phone')}}" id="phone"><span class="highlight"></span><span class="bar"></span>
                                    <label>Phone</label>
                                </div>
                                <div class="col-6 group">
                                    <input class="w-100" type="text" name="email" value="{{old('email')}}" id="email"><span class="highlight"></span><span class="bar"></span>
                                    <label>Email</label>
                                </div>
                                <div class="col-6 group">
                                    <input class="w-100" type="text" name="confirmemail" value="{{old('confirmemail')}}" id="confirmemail"><span class="highlight"></span><span class="bar"></span>
                                    <label>Confirm Email</label>
                                </div>
                                <div class="col-6 group">
                                    <input class="w-100" type="password" name="password" id="password"><span class="highlight"></span><span class="bar"></span>
                                    <label>Password</label>
                                </div>
                                <div class="col-6 group">
                                    <input class="w-100" type="password" name="password_confirmation" id="confirm"><span class="highlight"></span><span class="bar"></span>
                                    <label>Confrim Password</label>
                                </div>
                            </div>
                            <p class="" style="">* You need to fill all the field above to create a new PorTable account, so please take your time.</p>

                            <input type="submit" class="submit btn p-2 text-light" value="Register" style="background-color: #FEB139" id="register_desktop">
                        </form>

                        {{-- LOGIN REGISTER TOGGLER --}}
                        <div class="d-flex justify-content-end w-100 mt-3">
                            <p class="m-0" id="indexToggleSubtitle">Already Have Account?</p> <span style="width: 10px"></span> <p class="indexToggle" style="cursor: pointer;color:#0d9efe;text-decoration: underline" id="indexToggle">Sign in!</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MOBILE MODE XS SIZE : WIDTH <768px --}}
    <div class="mobile_mode login_bg d-none" id="mobile_mode">
        <div class="container d-flex flex-column justify-content-center overflow-auto" style="height: 100vh;width:100%;">
            {{-- IMAGE --}}
            <div class="d-flex justify-content-center w-100" style="height: 50%">
                <img class="" src="{{asset('storage/images/login/banner1.png')}}" alt="" height="100%" id="jumbotron_mobile">
            </div>
            {{-- FORM --}}
            <div class="px-4" style="height: 50%">
                {{-- LOGIN FORM --}}
                <div id="login_form_holder_mobile" class="login_form_holder w-100 text-center">
                        {{-- TITLE SUBTITLE --}}
                        <div class="title text-light">PorTable</div>
                        <p class="text-light mb-5" style="font-size: 1.1em">Order Table & Enjoy with your Friend and Family, because food tasted better when you eat with them in a good mood</p>
                        {{-- FORM --}}
                        <form action="/checkLogin" method="POST" class="mb-4">
                            @csrf
                            <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="username" placeholder="Insert your username">
                            <input class="w-100 bg-light rounded-3 mb-3 px-3" type="password" name="password" placeholder="Insert your password">
                            <input type="submit" class="submit btn p-2 text-light" value="Sign in" style="background-color: #6C4AB6" id="submit">
                        </form>
                        {{-- LOGIN REGISTER TOGGLER --}}
                        <div class="d-flex justify-content-end w-100">
                            <p class="m-0" id="indexToggleSubtitle">New member?</p>
                            <span style="width: 10px"></span>
                            <p class="indexToggle" style="cursor: pointer;color:#0d9efe;text-decoration: underline" id="indexToggle">Create account!</p>
                        </div>
                </div>
                {{-- REGISTER FORM --}}
                <div id="register_form_holder_mobile" class="register_form_holder w-100 text-center d-none">
                    {{-- TITLE SUBTITLE --}}
                    <div class="text-light mb-3" style="font-size:2em;font-weight:bold;font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Welcome to PorTable!</div>
                    {{-- FORM --}}
                    <form action="/checkRegister" method="POST" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="firstname" placeholder="Firstname">
                            </div>
                            <div class="col">
                                <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="lastname" placeholder="Lastname">
                            </div>
                        </div>
                        <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="username" placeholder="Username">
                        <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="number" placeholder="Phone">
                        <div class="row">
                            <div class="col">
                                <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="password" placeholder="Password">
                            </div>
                            <div class="col">
                                <input class="w-100 bg-light rounded-3 mb-3 px-3" type="text" name="password_confirmation" placeholder="Password Confirm">
                            </div>
                        </div>
                        <input type="submit" class="submit btn p-2 text-light" value="Register" style="background-color: #FEB139" id="submit">
                    </form>
                    {{-- LOGIN REGISTER TOGGLER --}}
                    <div class="d-flex justify-content-end w-100 mt-4">
                        <p class="m-0" id="indexToggleSubtitle">Already Have Account?</p> <span style="width: 10px"></span> <p class="indexToggle" style="cursor: pointer;color:#0d9efe;text-decoration: underline" id="indexToggle">Register!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_script')

    <script>
        $(document).ready(function(){
            console.log('Welcome to PorTable!');
            // PorTable Title
            $(".title").css("font-size", 0);
            $(".title").animate({fontSize : '2.7em'},"slow");
            // Jumbotron image
            $("#jumbotron").css("display","none");
            $("#jumbotron").fadeIn(800);
            $("#jumbotron_mobile").css("display","none");
            $("#jumbotron_mobile").fadeIn(800);
            // Submit Button
            $(".submit").css("width",0);
            $(".submit").animate({ width: '+=100%' },"slow");

        });

        // Toggle Login <-> Register
        let page = "login";
        $(".indexToggle").on("click", function() {
            // Submit Button
            $(".submit").css("width",0);
            $(".submit").animate({ width: '+=100%' },"slow");

            let slide_direction;
            if(page == "login"){
                slide_direction = "left";
                if(x.matches){
                    // MOBILE MODE
                    $("#mobile_mode").removeClass("login_bg");
                    $("#mobile_mode").addClass("register_bg");

                    $("#login_form_holder_mobile").addClass("d-none");
                    $("#register_form_holder_mobile").removeClass("d-none");

                    $("#register_form_holder_mobile").css("display","none");
                    $("#register_form_holder_mobile").fadeIn(800);

                    // CHANGE JUMBOTRON IMAGE
                    toggleJumbotron("#jumbotron_mobile",slide_direction)
                }else{
                    // DESKTOP MODE
                    $("#left_form").animate({backgroundColor : "#FEB139"});
                    $("#desktop_mode").removeClass("login_bg");
                    $("#desktop_mode").addClass("register_bg");

                    $("#login_form_holder").addClass("d-none");
                    $("#register_form_holder").removeClass("d-none");

                    $("#register_form_holder").css("display","none");
                    $("#register_form_holder").fadeIn(800);

                    // CHANGE JUMBOTRON IMAGE
                    toggleJumbotron("#jumbotron",slide_direction)
                }
            }
            else{
                slide_direction = "right";
                if(x.matches){
                    // MOBILE MODE
                    $("#mobile_mode").removeClass("register_bg");
                    $("#mobile_mode").addClass("login_bg");

                    $("#login_form_holder_mobile").removeClass("d-none");
                    $("#register_form_holder_mobile").addClass("d-none");

                    $("#login_form_holder_mobile").css("display","none");
                    $("#login_form_holder_mobile").fadeIn(800);

                    // CHANGE JUMBOTRON IMAGE
                    toggleJumbotron("#jumbotron_mobile",slide_direction)
                }else{
                    $("#left_form").animate({backgroundColor : "#6C4AB6"});
                    $("#desktop_mode").removeClass("register_bg");
                    $("#desktop_mode").addClass("login_bg");

                    $("#login_form_holder").removeClass("d-none");
                    $("#register_form_holder").addClass("d-none");

                    $("#login_form_holder").css("display","none");
                    $("#login_form_holder").fadeIn(800);

                    // CHANGE JUMBOTRON IMAGE
                    toggleJumbotron("#jumbotron",slide_direction)
                }
            }

        });

        function toggleJumbotron(elementId,slide_direction){
            $(elementId).toggle("slide",{direction:slide_direction},function(){
                if(page == "login"){
                    page = "register";
                    $(elementId).attr("src","/storage/images/login/banner2.png");
                    $(elementId).toggle("slide");
                }else {
                    page = "login";
                    $(elementId).attr("src","/storage/images/login/banner1.png");
                    $(elementId).toggle("slide",{direction:slide_direction});
                }
            });
        }

        // CHANGE MODE
        var x = window.matchMedia("(max-width: 768px)");
        responsive(x);
        x.addListener(responsive);
        function responsive(x) {
            if (x.matches) {
                $("#desktop_mode").addClass("d-none");
                $("#mobile_mode").removeClass("d-none");
            } else {
                $("#desktop_mode").removeClass("d-none");
                $("#mobile_mode").addClass("d-none");
            }
        }

        // let firstname = $("#firstname").val();
        // let lastname = $("#lastname").val();
        // let username = $("#username").val();
        // let phone = $("#phone").val();
        // let password = $("#password").val();
        // let confirm = $("#confirm").val();
        // document.addEventListener('keydown', (event) => { checkRegister(); }, false);
        // function checkRegister(){
        //     if(page == "register"){
        //         firstname = $("#firstname").val();
        //         lastname = $("#lastname").val();
        //         username = $("#username").val();
        //         phone = $("#phone").val();
        //         password = $("#password").val();
        //         confirm = $("#confirm").val();

        //         if(firstname!="" && lastname!=""
        //         && username != "" && phone!= ""
        //         && password != "" && confirm!= ""){
        //             $("#register_desktop").removeClass("disabled");
        //         }else{
        //             $("#register_desktop").addClass("disabled");
        //         }
        //     }
        // }

    </script>
@endsection
