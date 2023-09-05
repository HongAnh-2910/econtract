<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
</head>
<body class="auth__overflow--hidden" style="">
<div id="app">
    <main class="row">
        <div class="col-md-6 col-12 px-0 auth__background--color overflow-hidden position-relative">
            <div class="position-absolute auth__background--circle"></div>
            <div class="mt-4 ml-2 auth__logo--top">
                <div class="col-12">
                    <img src="{{asset('images/Logo_OneSign.png')}}">
                </div>
                <div class="col-12 d-flex justify-content-center mt-5">
                    <div class="col-8 text-uppercase text-white text-right auth__textWelcome--style">Chào mừng bạn đến với OneSIGN.vn</div>
                </div>
                <div class="col-12 d-flex justify-content-center mt-4">
                    <div class=" col-8 text-white text-right auth__text--fontfamily">Nền tảng quản lý, ký hợp đồng điện tử hàng đầu Việt Nam
                    </div>
                </div>
{{--                <div class="row mr-5 pr-5">--}}
{{--                    <div class="col-md-2 px-0">--}}
{{--                    </div>--}}
{{--                    <div class="col-md-10 px-0 d-none d-lg-block auth__listIcon--margin">--}}
{{--                        <ul class="text-center list-unstyled  d-flex justify-content-center">--}}
{{--                            <li>--}}
{{--                                <img src="images/Group1.png">--}}
{{--                                <div class="text-white mt-3">Tourkit </div>--}}
{{--                            </li>--}}
{{--                            <li class="auth__icon--two">--}}
{{--                                <img src="images/Group2.png">--}}
{{--                                <div class="text-white">Thiết kế/ Xây dựng--}}
{{--                                    Website chuyên nghiệp</div>--}}
{{--                            </li>--}}
{{--                            <li class="auth__icon--three">--}}
{{--                                <img src="images/Group3.png">--}}
{{--                                <div class="text-white">Phát triển phần mềm--}}
{{--                                    theo yêu cầu</div>--}}
{{--                            </li>--}}
{{--                            <li class="auth__icon--four">--}}
{{--                                <img src="images/Group4.png">--}}
{{--                                <div class="text-white">Các giải pháp quản--}}
{{--                                    trị doanh nghiệp</div>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            <div class="col-12 mb-4 ml-4 position-absolute auth__text--copyright">
                <div class="text-white auth__text--fontfamily">© 2021. Thiết kế và phát triển bởi DTATech</div>
            </div>
        </div>

        <div class="right-container col-md-6 col-12 px-0 d-flex justify-content-center align-items-center my-5">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>

