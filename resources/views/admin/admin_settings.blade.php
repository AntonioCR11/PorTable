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
                    <h3 class="m-0 p-0">Settings</h3>
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

            {{-- ADD DEVELOPER ANNOUNCEMENT --}}
            <div class="bg-light rounded-4 p-4 my-4" id="postContainer" >
                <div class="row h-100">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img class="" src="{{asset('storage/images/admin/post.png')}}" alt="" width="100px" height="100px">
                    </div>
                    <div class="col-10">
                        {{-- ADD POST --}}
                        <h2 class="mb-3">𝑪𝒓𝒆𝒂𝒕𝒆 𝒂 𝒑𝒐𝒔𝒕...</h2>
                        <form action="{{url('admin/settings/addPost')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Post Title" name="title">
                                        <label for="floatingInput">Post Title</label>
                                        {{-- ERROR --}}
                                        @error('title')
                                            @include('partial.validationMessage')
                                        @enderror
                                    </div>

                                    <div class="form-floating">
                                        <textarea class="form-control" name="caption" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px"></textarea>
                                        <label for="floatingTextarea2">Post Caption</label>
                                        {{-- ERROR --}}
                                        @error('caption')
                                            @include('partial.validationMessage')
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="h-100">
                                        <input type="submit" class="btn w-100 h-100 text-light" value="Post!" style="background-color: #FEB139">
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <h3>Announcement</h3>
            @foreach ($posts as $post)
            <div class="bg-light rounded-4 p-4 my-4">
                <div class="row h-100">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img class="" src="{{asset('storage/images/admin/post.png')}}" alt="" width="100px" height="100px">
                    </div>
                        <div class="col-8">
                            {{-- <h4>{{$post->post_title}}</h4>
                            <p>{{$post->post_caption}}</p> --}}
                            <h4>{{$post->title}}</h4>
                            <p class="m-0">{{$post->caption}}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-end align-items-center">
                            @if($post->trashed())
                                <a class="w-75" href={{url("admin/settings/deletePost/$post->id")}}>
                                    <button class="btn btn-success w-100">Restore Post</button>
                                </a>
                            @else
                                <a class="w-75" href={{url("admin/settings/deletePost/$post->id")}}>
                                    <button class="btn btn-danger w-100">Delete Post</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
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
