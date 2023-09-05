<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Onesign</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('images/Logo_OneSign.png') }}">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">

    <link rel="stylesheet" href="{{ asset('vendor/assets_mazer/css/bootstrap.css')}}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/assets_mazer/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/assets_mazer/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/assets_mazer/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/assets_mazer/css/app.css') }}">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
            integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
            crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
            integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
            crossorigin="anonymous"></script>

    <script src="{{ asset('vendor/assets_mazer/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendor/assets_mazer/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/assets_mazer/vendors/apexcharts/apexcharts.js') }}"></script>
{{--    <script src="{{ asset('assets_mazer/js/pages/dashboard.js') }}"></script>--}}
    <script src="{{ asset('vendor/assets_mazer/js/main.js') }}"></script>
    <script src="{{ asset('js/js.js') }}"></script>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
            integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
            crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
            integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
            crossorigin="anonymous"></script>

    <!-- CKEditor -->
    <script type="text/javascript" src="{{ asset('vendor/editor/ckeditor/ckeditor.js') }}"></script>

    <!-- Another lib -->
    @yield('extra_cdn')

</head>

<body>
    <div class="dashboard__wrapper d-flex align-items-stretch">
        <!-- Sidebar  -->
        @php
            $paramsArray = [];
            if (isset($type)) {
                $paramsArray['type'] = $type;
            }
            if (isset($menu_type)) {
                $paramsArray['menu_type'] = $menu_type;
            }
            if (isset($id)) {
                $paramsArray['id'] = $id;
            }
        @endphp
        @include('layouts.sidebar', $paramsArray)
    <!-- Page Content  -->
        <div id="dashboard__content" class="pb-5 overflow-auto">
            <nav class="navbar navbar-expand-lg navbar-light bg-light mb-0">
                <div class="container-fluid px-0">
                    <div class="d-flex flex-row align-items-center">
                        <a type="button" id="dashboard__sidebar--collapse" class="">
                            <i class="fas fa-bars fa-lg dashboard__sidebar--iconMain"></i>
                        </a>
                    </div>
                    <div id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto d-flex flex-row align-items-center">
                            <li class="nav-item mr-2">
                                <div
                                    class="d-flex justify-content-center align-items-center rounded-circle dashboard__question--container">
                                    <i class="fa fa-question dashboard__sidebar--iconGray" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li class="nav-item ml-2 dashboard__avatar--container">
                                <div id="dashboard__avatar--link" class="d-flex flex-row align-items-center position-relative">
                                    <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar_link }}" alt="avatar"
                                         class="rounded-circle dashboard__sidebar--avatar image__permission--round"/>
                                    <a class="ml-2" id="dashboard__avatar--link">
                                        <i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div id="dashboard__avatar--container"
                                     class="dashboard__sidebar--modal px-3 py-3 d-flex flex-column">
                                    <div class="d-flex flex-row align-items-center justify-content-between mb-1">
                                        <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar_link }}" alt="avatar"
                                             class="rounded-circle mr-1 dashboard__modal--avatar image__permission--round"/>
                                        <div class="d-flex flex-column justify-content-center dashboard__modal--top">
                                            <span class="mb-1">Xin chào <b>{{ Auth::user()->name }}</b></span>
                                            <span
                                                class="mb-2">Bản dùng thử của bạn sẽ hết hạn sau <span>17 ngày</span></span>
                                            <a>Nâng cấp ngay</a>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column mt-4 dashboard__modal--bottom">
                                        <a href="{{ route('web.profile.index', \Illuminate\Support\Facades\Auth::id()) }}" class="mb-3">Quản lý tài khoản</a>
                                        <a class="mb-3">Thanh toán</a>
                                        <a class="mb-3">Hỗ trợ</a>
                                        <a href="{{ route('logout') }}" class="mt-2"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Đăng xuất
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-0">
                @if(!isset($isShowError))
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible">{{ $error }}</div>
                    @endforeach
                @endif


                @if (\Illuminate\Support\Facades\Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible">{!! session('error_message') !!}</div>
                @endif
                @if (\Illuminate\Support\Facades\Session::has('message'))
                    <div class="alert alert-success alert-dismissible">{!! session('message') !!}</div>
                @endif
                @yield('content')
            </main>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#dashboard__sidebar--collapse').on('click', function () {
                    var sidebar   = $('#dashboard__sidebar');
                    var component = sidebar.find('.dashboard__components');
                    sidebar.toggleClass('dashboard-sidebar-active');
                    $('#dashboard__content').toggleClass('dashboard-content-active');

                    if( sidebar.hasClass('dashboard-sidebar-active')) {
                        component.addClass('dashboard-collapse');
                    } else {
                        component.removeClass('dashboard-collapse');
                    }
                });

                $('#dashboard__avatar--link').on('click', function () {
                    $('#dashboard__avatar--container').toggleClass('dashboard__avatar--active');
                })
            });
        </script>
        <script>
            $(document).ready(function() {
                // show the alert
                $(".alert").fadeTo(5000, 500).slideUp(500, function(){
                    $(".alert").alert('close');
                });
            });
        </script>
    </div>

    <script src="{{ asset("vendor/assets_mazer/vendors/perfect-scrollbar/perfect-scrollbar.min.js")}}"></script>
    <script src="{{ asset('vendor/assets_mazer/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/assets_mazer/js/main.js')}}"></script>

</body>
</html>
