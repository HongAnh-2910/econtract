@extends('layouts.dashboard', ['key' => 'profile_list', 'menu_type' => 'menu_profile' , 'isShowError' => false])
@section('extra_cdn')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.theme.default.min.css') }}">

    <script src="jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
@endsection
@section('content')
    <div class="container-fluid overflow-hidden">
        @include('dashboard.profile.user_form')
        @if ((!empty($errors->all()) && old('name_add')) || old('email_add'))
        <script>
            $('#add_user').modal('show')
        </script>
        @endif
        <div class="title-account">
            <div class="col-md-12 py-3">
                <h4 class="mb-0">Quản lý thành viên</h4>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="list__users--bg bg-white">
            <div class="col-md-12 pt-2 mb-4">
                <div class="row">
                    <div class="col-md-9 d-flex justify-content-md-start justify-content-center">
                        <div data-toggle="modal" data-target="#add_user"
                            class="list__users--bg--button text-white rounded mt-md-0 mt-2 mb-md-0 mb-3">
                            Thêm mới thành viên
                        </div>
                    </div>
                    <div class="col-md-3">
                        <form>
                            <div
                                class="input-group d-flex justify-content-md-around justify-content-center justify-content-start">
                                <div class="form-outline position-relative">
                                    <i class="fas fa-search position-absolute list__users--search--icon"></i>
                                    <input value="{{ request()->input('search') }}" type="search" name="search" id="form1"
                                        class="form-control py-1 form__search--input" placeholder="Tìm kiếm" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- end and search --}}
            <form method="POST" action="{{ route('web.profile.checkboxAllUser') }}">
                @csrf
                @method('POST')
                <div class="box__width--user">
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                            </form>
                            <div class="hide__one--click d-md-block d-none">
                                <ul class="header__status--contract-list list__status--profile pl-3 d-flex justify-content-center justify-content-md-start mb-0 mb-4"
                                    style="list-style: none">
                                    <li class="pl-2">
                                        <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">
                                            <span
                                                class="header__status--fz table__contract--item-color {{ request()->input('status') != 'trash' ? 'list__users--status--color--active list__users--status--color--active1' : 'list__users--status--color' }} ">Tất
                                                cả ({{ $countAll }})</span>
                                        </a>
                                    </li>
                                    <li class="pl-4">
                                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}">
                                            <span
                                                class="header__status--fz table__contract--item-color {{ request()->input('status') == 'trash' ? 'list__users--status--color--active list__users--status--color--active1' : 'list__users--status--color' }} list__users--status--color">Đã
                                                xoá ({{ $countTrash }})</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            {{--                    resposive--}}
                            <div class="owl-carousel owl-theme text-center d-md-none d-block">
                                <div class="item" data-merge="6">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">
                                            <span
                                                class="header__status--fz table__contract--item-color {{ request()->input('status') != 'trash' ? 'list__users--status--color--active list__users--status--color--active1' : 'list__users--status--color' }} ">Tất
                                                cả ({{ $countAll }})</span>
                                    </a>
                                </div>
                                <div class="item" data-merge="6">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}">
                                            <span
                                                class="header__status--fz table__contract--item-color {{ request()->input('status') == 'trash' ? 'list__users--status--color--active list__users--status--color--active1' : 'list__users--status--color' }} list__users--status--color">Đã
                                                xoá ({{ $countTrash }})</span>
                                    </a>
                                </div>
                            </div>
                            <script>
                                $('.owl-carousel').owlCarousel({
                                    items:1,
                                    loop:true,
                                    margin:10,
                                    merge:true,
                                    startPosition: {{ $activeUser }},
                                    responsive:{
                                        678:{
                                            mergeFit:true
                                        },
                                        1000:{
                                            mergeFit:false
                                        }
                                    }
                                });
                            </script>
                            <input type="text" class="status__for" name="status" hidden />
                            @if (request()->input('status') != 'trash')
                                <div class="align-items-center pl-3 customer__button--deleteAll">
                                    <ul class="list-unstyled d-flex align-content-start">
                                        <li class="customer__li--border">
                                            <div>
                                                <div data-toggle="modal" data-target="#modalDeleteConfirm"
                                                    class="btn delete_all list__customers--status-color customer__status--list">
                                                    <i style="font-size: 25px" class="fas fa-trash"></i>
                                                    <span>Xoá</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <div class="box--status d-flex">
                                    <div class="align-items-center pl-3 customer__button--deleteAll">
                                        <ul class="list-unstyled d-flex align-content-start">
                                            <li class="customer__li--border">
                                                <div>
                                                    <button type="submit"
                                                        class="restore__all btn list__customers--status-color customer__status--list">
                                                        <i class="fas fa-window-restore"></i>
                                                        <span>Khôi phục</span>
                                                    </button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="align-items-center pl-3 customer__button--deleteAll">
                                        <ul class="list-unstyled d-flex align-content-start">
                                            <li class="customer__li--border">
                                                <div>
                                                    <div data-toggle="modal" data-target="#modalDeleteConfirm"
                                                        class="delete_force btn  list__customers--status-color customer__status--list">
                                                        <i style="font-size: 25px" class="fas fa-trash"></i>
                                                        <span>Xoá vĩnh viễn</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- end-status --}}
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-borderless border-bottom table-checkall">
                                <thead class="border-bottom">
                                    <tr class="text-center">
                                        <td>
                                            <div class="d-flex">
                                                <img src="{{ asset('images/hinh.png') }}">
                                            </div>
                                            <input id="check_all" type="checkbox" name="checkall">
                                        </td>
                                        <th class="text-dark">STT</th>
                                        <th class="text-dark">Họ và tên</th>
                                        <th class="text-dark">Email</th>
                                        <th class="text-dark">Phòng ban</th>
                                        <th class="text-dark">Ngày tạo</th>
                                        <th class="center text-dark">Chức năng</th>
                                    </tr>
                                </thead>
                                @if ($listUsers->count() > 0)
                                    <tbody>
                                        @foreach ($listUsers as $key => $user)
                                            {{-- model-delete --}}
                                            @include('dashboard.profile.user_form_update', ['id' =>
                                            "editUserModal_$user->id", 'user'=> $user])
                                            @include('dashboard.profile.modal_delete_id')
                                            @include('dashboard.profile.modal_deleteface_id')
                                            <input type="hidden" class="get_id--update--users" value="{{ $user->id }}">
                                            @if ((!empty($errors->all()) && old('name')) || old('email'))
                                            <script>
                                                let id = $('.get_id--update--users').val();
                                                let get_by_id = "#editUserModal_" + id;
                                                $(get_by_id).modal('show')
                                            </script>
                                        @endif
                                        {{-- end-model-dlete --}}
                                        <tr class="border-bottom text-center">
                                            @include('dashboard.profile.modal_delete')
                                            <td>
                                                @if (\Illuminate\Support\Facades\Auth::id() != $user->id)
                                                    <input type="checkbox" name="check_value[]" class="click__check--value"
                                                        value="{{ $user->id }}">
                                                @endif
                                            </td>
                                            <td class="text-dark">
                                                {{ $key + 1 }}
                                            </td>
                                            <td class="list__users--color--text">{{ $user->name }}</td>
                                            <td class="text-dark">
                                                <a type="button" class="btn ml-1" data-bs-toggle="modal"
                                                    data-bs-target="#showCustomer">
                                                    {{ $user->email }}
                                                </a>
                                            </td>
                                            <td class="text-dark">{{ $user->getDepartmentStringAttribute() }}</td>
                                            <td class="text-dark">{{ $user->created_at }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" id="dropdownMenuButton"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                                    </div>
                                                    @if (request()->input('status') == 'all' || empty(request()->input('status')))
                                                        <div style="width: 60px" class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#editUserModal_{{ $user->id }}"
                                                                style="font-size: 15px">
                                                                <i class="fas fa-edit"></i>
                                                                Sửa</a>
                                                            @if (Auth::id() != $user->id)
                                                                <div data-toggle="modal"
                                                                    data-target="#modalDeleteId_{{ $user->id }}"
                                                                    class="dropdown-item" type="submit"
                                                                    data-toggle="tooltip"
                                                                    style="font-size: 15px; outline: none"><i
                                                                        class="fa fa-trash"></i> Xoá
                                                                </div>
                                                            @Endif
                                                        </div>
                                                    @else
                                                        <div style="width: 60px" class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <form method="POST"
                                                                action="{{ route('web.profile.restore', $user->id) }}">
                                                                @csrf
                                                                <button class="dropdown-item"
                                                                    style="font-size: 15px ; outline: none">
                                                                    <i class="fas fa-window-restore"></i>
                                                                    Khôi phục
                                                                </button>
                                                            </form>
                                                            @if (Auth::id() != $user->id)
                                                                <div data-toggle="modal"
                                                                    data-target="#modalDeleteFace_{{ $user->id }}"
                                                                    class="dropdown-item" type="submit"
                                                                    data-toggle="tooltip"
                                                                    style="font-size: 15px; outline: none"><i
                                                                        class="fa fa-trash"></i> Xoá vĩnh viễn
                                                                </div>
                                                            @Endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                @endforeach
                                </tbody>
                            @else
                                @if (request()->input('status') == 'trash')
                                    <tr>
                                        <td colspan="8">
                                            <h5 class="text-center">Bạn chưa xoá thành viên nào</h5>
                                        </td>
                                    </tr>
                                @elseif(request()->input('search'))
                                    <tr>
                                        <td colspan="8">
                                            <h5 class="text-center">Thành viên bạn tìm kiếm không tồn tại</h5>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <h5 class="text-center">Không có thành viên trong danh sách</h5>
                                        </td>
                                    </tr>
                                @endif
                                @endif
                            </table>
                            {{-- paginate --}}
                            <div class="paginate__contract my-2">
                                <div class="row">
                                    <div class="col-md-12 py-3">
                                        {{ $listUsers->links('pagination') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.delete_all').click(function() {
                $('.status__for').val(1)
                $('.text__title span').text('Bạn có chắc  chắn muốn xoá thành viên ?')
            })
            $('.delete_force').click(function() {
                $('.status__for').val(3)
                $('.text__title span').text('Bạn có chắc chắn muốn xoá vĩnh viễn thành viên ?')
            })
            $('.restore__all').click(function() {
                $('.status__for').val(2)
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.customer__button--deleteAll').hide();
            $('.click__check--value').click(function() {
                if ($(this).is(":checked", true)) {
                    $('.customer__button--deleteAll').show();
                    $('.hide__one--click').hide();
                } else {
                    if ($('.click__check--value:checked').length == 0) {
                        $('.customer__button--deleteAll').hide();
                        $('.hide__one--click').show();
                    }
                }
            })
        })
        //    check all
        $(document).ready(function() {
            $('#check_all').click(function() {
                if ($(this).is(":checked", true)) {
                    $('.customer__button--deleteAll').show();
                    $('.hide__one--click').hide();
                } else {
                    if ($('#check_all:checked').length == 0) {
                        $('.customer__button--deleteAll').hide();
                        $('.hide__one--click').show();
                    }
                }
            })
        })
    </script>

    <script type="text/javascript">
        // select perrmission user when upload file
        $(document).ready(function() {
            $('.department__select').select2({
                placeholder: "Chọn phòng ban",
                allowClear: true,
            });
        });
    </script>
    {{-- validate --}}
@endsection
