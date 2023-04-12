@extends('layouts.layout')

@section('custom_css')
    <style>
        .sidebar {
            width: 256px;
            box-shadow: 2px 0 12px 2px rgba(80, 80, 80, 0.5);
            height: 100vh;
        }

        .sidebar .sidebar-header {
            background-color: #06c700;
            color: white;
        }

        .sidebar .sidebar-menu {
            height: 90%;
        }

        .sidebar .sidebar-menu a {
            font-weight: 600;

            text-decoration: none;
            color: inherit;
        }

        a span {
            vertical-align: text-bottom
        }

        .sidebar .sidebar-menu li {
            padding: 12px;
            margin: 4px 0;
            /* border-radius: 8px; */
            list-style: none;
        }

        .sidebar .sidebar-menu li:hover {
            outline: 1px solid black
        }

        .sidebar .sidebar-menu .active {
            border-bottom: 2px solid black;
            font-weight: bold;
            /* color: white; */
        }

        .sidebar .sidebar-menu .danger {
            background-color: #ed3a27;
            color: white;
        }

        .sidebar .sidebar-menu .logout {
            border-radius: 6px;
        }
    </style>
    @yield('custom-css-extended')
@endsection

@section('content')
    <div class="h-100 sidebar position-fixed" id="sidebar">
        <div class="sidebar-header bg-dark text-center p-3" id="sidebar-header">
            @yield('sidebar-header')
        </div>
        <div class="sidebar-menu p-2" id="sidebar-menu">
            <div class="d-flex flex-column justify-content-between h-100">
                @yield('sidebar-menu')
            </div>
        </div>
    </div>
    <div class="main-content" id="main-content" style="margin-left: 256px;">
        @yield('main-content')
    </div>
@endsection
