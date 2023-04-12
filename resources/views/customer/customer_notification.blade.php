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
        .dev_notif{
            background-color: rgb(230,230,230);
        }
        .dev_notif:hover{
            background-color: rgb(200, 200, 200);
            cursor: pointer;
        }
        .read_status{
            position: absolute;
            top:0;
            left: 0;
            height: 100%;
            width: 15px;
            background-color: #ed3b27;
            border-top-left-radius: 25px;
            border-bottom-left-radius: 25px;
        }

        .userNotif_container{
            height: calc(100vh - 136px);
        }
        .userNotif_container::-webkit-scrollbar {
            display: none;
        }
        .devNotif_container{
            height: calc(100vh - 136px);
        }
        @media (max-width: 481px){
            .userNotif_container{
                height: 100%;
            }
            .devNotif_container{
                height: 100%;
            }
        }
    </style>
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
    <div class="container">
        {{-- NAVBAR --}}
        @include("customer.partial.navbar")
        {{-- CONTENT --}}
        <div class="content">
            <div class="row m-0">
                <div class="userNotif_container col-sm-12 col-lg-8 overflow-auto py-3">
                    <h3 class="m-0" style="font-family: helvetica_bold">User Notification</h3>
                    @foreach ($user_notifications as $user_notif)
                        <div class="bg-light rounded-4 p-4 my-4" style="position: relative">
                            {{-- STATUS --}}
                            @if ($user_notif->status == 0)
                                <div class="read_status"></div>
                            @else
                                <div class="read_status bg-secondary"></div>
                            @endif
                            {{-- NOTIF --}}
                            <div class="row h-100">
                                <div class="col-2 d-none d-lg-flex justify-content-center align-items-center">
                                    <img class="" src="{{asset('storage/images/admin/notification.png')}}" alt="" width="100px" height="100px">
                                </div>
                                <div class="col-sm-12 col-lg-10">
                                    <div class="row m-0">
                                        <div class="col-sm-12 col-lg-8 p-0">
                                            <h4>{{$user_notif->title}}</h4>
                                        </div>
                                        <div class="col-sm-12 col-lg-4 p-0 text-end">
                                            @php $day = date('l', strtotime($user_notif->created_at)); @endphp
                                            <p class="m-0 mb-2">{{$day}}, {{$user_notif->created_at}}</p>
                                        </div>
                                    </div>
                                    <p class="m-0">{{$user_notif->caption}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="devNotif_container col-sm-12 col-lg-4 py-3 border-start overflow-auto">
                    <h3 class="m-0" style="font-family: helvetica_bold">Developer message!</h3>
                    @foreach ($developer_notifications as $developer_notif)
                        <div class="dev_notif rounded-4 p-3 my-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Message : {{$developer_notif->caption}}">
                            <div class="message_container">
                                <div class="row m-0">
                                    <div class="col p-0" >
                                        <p class="m-0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                            @php $day = date('l', strtotime($developer_notif->created_at)); @endphp
                                            [ {{$day}}, {{substr($developer_notif->created_at,0,10)}} ] <br> {{$developer_notif->title}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection

@section("footer")
    {{-- FOOTER --}}
    <div class="about_us bg-dark text-light">
        <div class="container">
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
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
