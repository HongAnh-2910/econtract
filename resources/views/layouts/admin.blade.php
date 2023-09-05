<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <title>Admintrator</title>
</head>

<body>
<div id="warpper" class="nav-fixed">
    <nav class="topnav shadow navbar-light bg-white d-flex">
        <div class="navbar-brand"><a href="?">ADMIN</a></div>
        <div class="nav-right ">
            <div class="btn-group mr-auto">
                <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="plus-icon fas fa-plus-circle"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="?view=add-post">Thêm bài viết</a>
                    <a class="dropdown-item" href="?view=add-product">Thêm sản phẩm</a>
                    <a class="dropdown-item" href="?view=list-order">Thêm đơn hàng</a>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Tài khoản</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Thoát') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- end nav  -->
    <div id="page-body" class="d-flex">
        <div id="sidebar" class="bg-white">
            <ul id="sidebar-menu">
                <li class="nav-link">
                    <a href="{{ route('dashboard') }}">
                        <div class="nav-link-icon d-inline-flex">
                            <i class="far fa-folder"></i>
                        </div>
                        Dashboard
                    </a>
                    <i class="arrow fas fa-angle-right"></i>
                </li>
                <li class="nav-link">
                    <a href="?view=list-user">
                        <div class="nav-link-icon d-inline-flex">
                            <i class="far fa-folder"></i>
                        </div>
                        Users
                    </a>
                    <i class="arrow fas fa-angle-right"></i>

                    <ul class="sub-menu">
                        <li><a href="{{ route('user.add') }}">Thêm mới</a></li>
                        <li><a href="{{ route('list_user') }}">Danh sách</a></li>
                        <li><a href="{{ route('user.edit', Auth::id()) }}">Quản lý tài khoản</a></li>
                        <li><a href="{{ route('user.change', Auth::id()) }}">Đổi mật khẩu</a></li>
                    </ul>
                </li>
                <li class="nav-link">
                    <a href="?view=list-user">
                        <div class="nav-link-icon d-inline-flex">
                            <i class="far fa-folder"></i>
                        </div>
                        Phòng ban
                    </a>
                    <i class="arrow fas fa-angle-right"></i>
                    <ul class="sub-menu">
                        <li><a href="{{ route('web.departments.add') }}">Thêm mới</a></li>
                        <li><a href="{{ route('web.departments.list') }}">Danh sách</a></li>
                    </ul>
                </li>
                <li class="nav-link">
                    <a href="?view=list-user">
                        <div class="nav-link-icon d-inline-flex">
                            <i class="far fa-folder"></i>
                        </div>
                        Khách hàng
                    </a>
                    <i class="arrow fas fa-angle-right"></i>
                    <ul class="sub-menu">
                        <li><a href="{{ route('web.customers.add') }}">Thêm mới</a></li>
                        <li><a href="{{ route('web.customers.list') }}">Danh sách</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div id="wp-content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('js/js.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>
