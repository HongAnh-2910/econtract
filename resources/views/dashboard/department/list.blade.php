@extends('layouts.dashboard' ,['key' => 'dashboard_department', 'menu_type' => 'menu_sidebars'])
@section('extra_cdn')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.theme.default.min.css') }}">

    <script src="jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
@endsection
@section('content')
    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="title__contract mt-2">
            <div class="col-md-12 pb-2 py-3">
                <div class="col-md-9 pl-0 d-flex justify-content-md-start justify-content-center">
                    <div class="list__users--bg--button text-white rounded">
                        <div class="px-4" href="" data-bs-toggle="modal"
                             data-bs-target="#staticBackdrop">
                            Tạo phòng ban
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__status--contract">
            <div class="row d-flex align-items-center">
                <div class="col-md-6 list__department--ul d-md-block d-none">
                    <ul class="header__status--contract-list ul__department--item pl-3 d-flex  mb-0 list-unstyled flex-md-row">
                        <li class="header__list--item customer__li--border mr-3 mt-md-0 mt-2">
                            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}">
                                <span
                                    class="{{ (request()->input('status') != 'trash') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Tất cả</span>
                            </a>
                        </li>
                        <li class="header__list--item customer__li--border mt-md-0 mt-2">
                            <a href="{{ request()->fullUrlWithQuery(['status'=>'trash']) }}">
                                <span
                                    class="{{ request()->input('status') == 'trash' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Thùng rác</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{--                    resposive--}}
                <div class="owl-carousel owl-theme text-center d-md-none d-block">
                    <div class="item" data-merge="6">
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}">
                                <span
                                    class="{{ (request()->input('status') != 'trash') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Tất cả</span>
                        </a>
                    </div>
                    <div class="item" data-merge="6">
                        <a href="{{ request()->fullUrlWithQuery(['status'=>'trash']) }}">
                                <span
                                    class="{{ request()->input('status') == 'trash' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Thùng rác</span>
                        </a>
                    </div>
                </div>
                <script>
                    $('.owl-carousel').owlCarousel({
                        items:1,
                        loop:true,
                        margin:10,
                        merge:true,
                        startPosition : {{ $activeDepartment ?? 0 }},
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
                <div class="col-md-6 pr-4">
                    <div class="header__status--search mb-2">
                        <form>
                            <div class="input-group d-flex input__search--department justify-content-center justify-content-md-end p-md-2 p-0">
                                <div class="form-outline position-relative">
                                    <i class="fas fa-search position-absolute list__users--search--icon"></i>
                                    <input style="width: 237px" value="{{ request()->input('search') }}" type="search"
                                           name="search"
                                           id="form1"
                                           class="form-control form__search--input"
                                           placeholder="Tìm kiếm"/>
                                    <input type="hidden" name="status" value="{{request()->status ?? 'all'}}" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{--      end-header-status  --}}
    </div>
    <div class="table__contract container-fluid">
        <div class="col-md-12 px-0">
            <div class="table__contract--bg bg-white table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="position-relative table__contract--item-fz text-center">STT
                            <img class="position-absolute" src="{{ asset('images/hinh.png') }}"
                                 style="top: 0px; left: 0px">
                        </th>
                        <th scope="col" class="table__contract--item-fz text-dark text-center">Người tạo</th>
                        <th scope="col" class="table__contract--item-fz text-dark text-center">Tên phòng ban</th>
{{--                        <th scope="col" class="table__contract--item-fz text-dark text-center">Số lượng nhân viên</th>--}}
                        <th scope="col" class="text-center table__contract--item-fz text-dark">Ngày tạo</th>
                        <th scope="col" class="text-center table__contract--item-fz text-dark">Chức năng</th>
                    </tr>
                    </thead>
                    @if(count($listDepartmentLevel))
                        <tbody>
                        @foreach($listDepartmentLevel as $k=> $departmentLevel)
                            @include('dashboard.department.model_confirm')
                            @include('dashboard.department.model_permission')
                            @include('dashboard.department.model_confirm_facedelete')
                            <tr>
                                <th scope="row" class=" table__contract--item-color text-center">{{ $k+1 }}</th>
                                <td class="table__contract--item-color text-center">
                                    @if($departmentLevel->user->img_user)
                                        <div>
                                            <img
                                                src="{{ get_file_thumb('avatar/'.$departmentLevel->user->img_user) }}"
                                                class="rounded-circle document__body--avatar image__permission--round"/>
                                        </div>
                                    @else
                                        <div>
                                            <img
                                                src="{{ asset('images/admin.png') }}"
                                                class="rounded-circle document__body--avatar image__permission--round"/>
                                        </div>
                                    @endif
                                </td>
                                <td class=" table__contract--item-color header__status--fz text-center">{{ str_repeat('---  ',$departmentLevel->level).$departmentLevel->name }}</td>
                                <td class=" table__contract--item-color header__status--fz text-center">{{ $departmentLevel->created_at }}</td>
                                @if(request()->input('status') != 'trash')
                                    <td>
                                        <div class="dropdown text-center">
                                            <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                 aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                            </div>
                                            <div style="width: 60px" class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton">
                                                <button
                                                    data-toggle="modal" data-target="#editDepartment"
                                                    class="dropdown-item edit__department" type="submit"
                                                    data-id={{ $departmentLevel->id }}
                                                        data-toggle="tooltip"
                                                    style="font-size: 15px; outline: none"><i
                                                        class="fas fa-edit"></i> Sửa
                                                </button>
                                                <button
                                                    data-toggle="modal"
                                                    data-target="#modalDeleteConfirm_{{ $departmentLevel->id }}"
                                                    class="dropdown-item" type="submit"
                                                    data-toggle="tooltip"
                                                    style="font-size: 15px; outline: none"><i
                                                        class="fa fa-trash"></i> Xoá
                                                </button>
                                                <button
                                                    data-toggle="modal" data-target="#exampleModalPermission__{{ $departmentLevel->id }}"
                                                    class="dropdown-item" type="submit"
                                                    data-toggle="tooltip"
                                                    style="font-size: 15px; outline: none"><i
                                                        class="fas fa-user-tag"></i> Phân quyền
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                @elseif(request()->input('status') == 'trash')
                                    <td>
                                        <div class="dropdown text-center">
                                            <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                                 aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h list__users--color--cursor"></i>
                                            </div>
                                            <div style="width: 60px" class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton">
                                                <form method="POST"
                                                      action="{{ route('web.departments.restore' , $departmentLevel->id) }}">
                                                    @csrf
                                                    <button
                                                        class="dropdown-item edit__department" type="submit"
                                                        data-id={{ $departmentLevel->id }}
                                                            data-toggle="tooltip"
                                                        style="font-size: 15px; outline: none"><i
                                                            class="fas fa-window-restore"></i> Khôi phục
                                                    </button>
                                                </form>
                                                <button
                                                    data-toggle="modal"
                                                    data-target="#modalFaceDeleteConfirm_{{ $departmentLevel->id }}"
                                                    class="dropdown-item" type="submit"
                                                    data-toggle="tooltip"
                                                    style="font-size: 15px; outline: none"><i
                                                        class="fa fa-trash"></i> Xoá vĩnh viễn
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    @else
                        @if(request()->search)
                            <tr>
                                <td colspan="8">
                                    <h5 class="text-center">Phòng ban bạn tìm kiếm không tồn tại</h5>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="8">
                                    <h5 class="text-center">
                                        @if(request()->status == 'trash')
                                            Bạn chưa xóa phòng ban nào
                                        @else
                                            Danh sách phòng ban trống
                                        @endif
                                    </h5>
                                </td>
                            </tr>
                        @endif
                    @endif
                </table>
                {{-- end-table--}}
                <div class="paginate__contract my-2">

                </div>
            </div>
        </div>
    </div>
    {{--modal--}}
    <!-- Button trigger modal -->

    <!-- Modal -->
    @include('dashboard.department.add')
    @include('dashboard.department.edit')

    </div>
    <script>
        $(document).ready(function () {
            $('.edit__department').click(function () {
                let id = ($(this).attr('data-id'))
                let data = {id: id}
                $.ajax(
                    {
                        url: "{{ route('web.departments.edit') }}",
                        data: data,
                        method: 'GET',
                        dataType: 'html',
                        success: function (data) {
                            $('.model__box--html').html(data)
                        },
                    }
                )
            })
        })
    </script>
@endsection

