@extends('layouts.dashboard', ['key' => 'human-resource_list', 'menu_type' => 'menu_sidebars', 'isShowError' =>
false])
@section('extra_cdn')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.theme.default.min.css') }}">

    <script src="jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    <style>
        .description__application p {
            margin-bottom: 0px;
        }

    </style>



    <div id="content" class="ml-md-3 mx-2 mt-2">
        <div class="card">
            <div class="application__cardHeader--items">
                <div class="card-header py-3 d-flex justify-content-between align-items-center ">
                    <div class="row w-100">
                        <div class="col-md-7 col-12 add_application--button">
                            <div class="list__users--bg--button rounded text-white mb-2 mb-md-0 ml-md-0 ml-3">
                                <button class="btn text-white py-0" data-toggle="modal"
                                    data-target="#humanResource__modal--create">
                                    Thêm nhân sự
                                </button>
                            </div>
                        </div>

                        @include('dashboard.humanResource.create')
                        @if (!empty($errors->all()) && old('date_start_add'))
                            <script>
                                $('#humanResource__modal--create').modal('show');
                            </script>
                        @endif

                        <!--      Search      -->
                        {{-- <div
                            class="col-md-5 col-12 d-flex justify-content-center justify-content-md-end align-items-center">
                            <div class="form-search form-inline">
                                <form class="d-flex" action="#">
                                    <input type="text" name="search"
                                        uri-data-search="{{ route('application.liveSearch') }}"
                                        class="form-control application__input--search" placeholder="Tìm kiếm...">
                                    <button type="submit" name="btn-search "
                                        class="btn btn-primary btn-search__application ml-2"><i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div> --}}
                    </div>
                    <script>
                        $(document).ready(function() {
                            $(".application__input--search").keyup(
                                function() {
                                    console.log('ok');
                                    var keyword = $(".application__input--search").val();
                                    var route = "{{ route('web.applications.liveSearch') }}";
                                    var uri = route + '/' + keyword;

                                    var data = {
                                        keyword: keyword
                                    }
                                    $.ajax({
                                        url: uri,
                                        type: "GET",
                                        data: data,
                                        success: function(response) {
                                            $("#live-search").html(response);
                                        }
                                    });
                                }
                            );
                        })
                    </script>
                </div>
                @if (request()->input('status') == 'deleted_at')
                    <div class="align-items-center mx-4 my-4 customer__button--deleteAll">
                        <ul class="list-unstyled d-flex align-content-start">
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button" class="btn list__customers--status-color customer__status--list"
                                        data-bs-target="#HRM__modal--forceDelete" data-bs-toggle="modal">
                                        <i class="fas fa-trash" title="Xóa vĩnh viễn"></i></button>
                                </div>
                            </li>
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button" class="btn list__customers--status-color customer__status--list"
                                        data-bs-target="#HRM__modal--restore" data-bs-toggle="modal" title="Khôi phục">
                                        <img src="{{ asset('images/restore.png') }}"></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="align-items-center mx-4 my-4 customer__button--deleteAll">
                        <ul class="list-unstyled d-flex align-content-start">
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button" class="btn list__customers--status-color customer__status--list"
                                        data-bs-target="#HRM__modal--multipleDelete" data-bs-toggle="modal">
                                        <i class="fas fa-trash" title="Xóa"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif

                @include('dashboard.humanResource.delete')
                @include('dashboard.humanResource.restore')
                @include('dashboard.humanResource.forceDelete')

                <div class="row align-items-center mx-4 change__action--ajax">
                    <div class="col-md-9 col-12 d-md-block d-none">
                        <div class="analytic my-3 active__ul--li">
                            <ul class="list-unstyled d-flex align-content-start list__status--application flex-wrap">
                                <li class="customer__li--border pr-3">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                                        class="text-secondary  mb-3 {{ request()->input('status') == 'all' || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Tất cả <span class="text-muted">({{ $countHRMs }})</span></a>
                                </li>
                                <li class="customer__li--border  pr-3">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'TTS']) }}"
                                        class="text-secondary {{ request()->input('status') == 'TTS' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        TTS <span class="text-muted">({{ $countFormTypeTTS }})
                                        </span></a>
                                </li>
                                <li class="customer__li--border  pr-3">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Thử việc']) }}"
                                        class="text-secondary  {{ request()->input('status') == 'Thử việc' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Thử việc <span class="text-muted">({{ $countFormTypeIntern }})</span></a>
                                </li>
                                <li class="customer__li--border  pr-3">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'HĐ 1 năm']) }}"
                                        class="text-secondary  {{ request()->input('status') == 'HĐ 1 năm' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        HĐ 1 năm <span
                                            class="text-muted">({{ $countFormTypeContractOneYears }})</span></a>
                                </li>
                                <li class="customer__li--border  pr-3">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'HĐ không thời hạn']) }}"
                                        class="text-secondary  {{ request()->input('status') == 'HĐ không thời hạn' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        HĐ không thời hạn <span
                                            class="text-muted">({{ $countFormTypeUnlimitedContract }})</span></a>
                                </li>
                            </ul>
                        </div>
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
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'TTS']) }}"
                               class="text-secondary {{ request()->input('status') == 'TTS' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                TTS <span class="text-muted">({{ $countFormTypeTTS }})
                                        </span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Thử việc']) }}"
                               class="text-secondary  {{ request()->input('status') == 'Thử việc' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Thử việc <span class="text-muted">({{ $countFormTypeIntern }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'HĐ 1 năm']) }}"
                               class="text-secondary  {{ request()->input('status') == 'HĐ 1 năm' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                HĐ 1 năm <span
                                    class="text-muted">({{ $countFormTypeContractOneYears }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'HĐ không thời hạn']) }}"
                               class="text-secondary  {{ request()->input('status') == 'HĐ không thời hạn' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                HĐ không thời hạn <span
                                    class="text-muted">({{ $countFormTypeUnlimitedContract }})</span></a>
                        </div>
                    </div>
                    <script>
                        $('.owl-carousel').owlCarousel({
                            items:1,
                            loop:true,
                            margin:10,
                            merge:true,
                            startPosition :{{ $statusActiveResponsive }},
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
                    <div class="col-md-3 px-0 col-12 d-flex justify-content-center justify-content-md-end">
                        <div class="dropdown">
                            <a href="{{ route('web.human-resources.statistical') }}" class="btn py-3 text-center"
                                type="button">
                                <i style="font-size:22px" class="far fa-newspaper"></i>
                                <div>Báo cáo</div>
                            </a>
                        </div>
                        <div class="dropdown">
                            <a href="{{ route('web.human-resources.exportExcel') }}" class="btn py-3 text-center"
                               type="button">
                                <img src="{{ asset('images/Export.png') }}" alt="export.png">
                                <div>Export</div>
                            </a>
                        </div>
                    </div>

                </div>

            </div>

            <div>
                <img src="{{ asset('images/hinh.png') }}">
            </div>
            <div class="card-body px-0 py-0">
                <!--     Check All Box     -->
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.customer__button--deleteAll').hide();
                        $('#check_box_application').on('click', function() {
                            if ($(this).is(":checked", true)) {
                                $('.checkbox').prop('checked', true)
                                $('.change__action--ajax').hide()
                                $('.customer__button--deleteAll').show()
                            } else {
                                $('.checkbox').prop('checked', false)
                                $('.change__action--ajax').show()
                                $('.customer__button--deleteAll').hide()
                            }
                        })
                        $('.checkbox').on('click', function() {
                            if ($(this).is(":checked", true)) {
                                $('.change__action--ajax').hide()
                                $('.customer__button--deleteAll').show()
                            } else {
                                $('.change__action--ajax').show()
                                $('.customer__button--deleteAll').hide()
                            }

                            if ($('.checkbox:checked').length === $('.checkbox').length) {
                                $('#check_box_application').prop('checked', true)
                            } else {
                                $('#check_box_application').prop('checked', false)
                            }
                        })

                        $('.checkbox').on('click', function() {
                            if ($('.checkbox:checked').length > 0) {
                                $('.change__action--ajax').hide()
                                $('.customer__button--deleteAll').show()
                            }
                        });
                    })
                </script>

                <!-- Table Application -->
                <div class="table-responsive">
                    <table id="dtHorizontalApplication" class="table table-borderless border-bottom table-sm"
                        cellspacing="0" width="100%">
                        <thead class="border-bottom">
                            <tr class="text-center">
                                <td>
                                    <input type="checkbox" id="check_box_application">
                                </td>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Họ và tên</th>
                                <th scope="col">SĐT</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ngày bắt đầu</th>
                                <th scope="col">Phòng ban</th>
                                <th scope="col">Hình thức</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody id="live-search">
                            @if (count($HRMs) == 0)
                                <tr>
                                    <td colspan="9" class="text-center">Không có dữ liệu...</td>
                                </tr>
                            @else
                                @foreach ($HRMs as $HRM)
                                    <tr class="border-bottom text-center" id="results">
                                        <td>
                                            <input class="checkbox" type="checkbox" data-id="{{ $HRM->id }}">
                                        </td>
                                        @if ($HRM->user)
                                            <td>
                                                <img src="{{ $HRM->user->img_user ? get_file_thumb('avatar/' . $HRM->user->img_user) : asset('images/admin.png') }}"
                                                    alt="avatar"
                                                    class="rounded-circle customer__table--img image__permission--round" />
                                            </td>
                                        @else
                                            <td>
                                                <img src="{{ asset('images/admin.png') }}" alt="avatar"
                                                    class="rounded-circle customer__table--img image__permission--round" />
                                            </td>
                                        @endif
                                        <td>
                                            <a type="button" data-uri="{{ route('web.human-resources.show', $HRM->id) }}"
                                                class="btn ml-1 customer__list--name" data-bs-toggle="modal"
                                                data-toggle="modal" data-bs-target="#HRM__modal--show_{{ $HRM->id }}">
                                                {{ $HRM->user->name }}
                                            </a>
                                        </td>

                                        @include('dashboard.humanResource.show' , ['id' => $HRM->id] ,
                                        ['HRM'=> $HRM])

                                        <td>{{ $HRM->phone_number }}</td>
                                        <td>{{ $HRM->user->email }}</td>
                                        <td>{{ date('d/m/Y', strtotime($HRM->date_start)) }}</td>
                                        @if ($HRM->department)
                                            <td>{{ $HRM->department->name }}</td>
                                        @else
                                            <td>Không thuộc phòng ban nào</td>
                                        @endif
                                        <td>{{ $HRM->form }}</td>
                                        <td>
                                            <a type="button" data-uri="{{ route('web.human-resources.show', $HRM->id) }}"
                                                class="btn ml-1 customer__list--name" data-bs-toggle="modal"
                                                data-toggle="modal" data-bs-target="#HRM__modal--edit_{{ $HRM->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        @include('dashboard.humanResource.edit', ['id' => $HRM->id],
                                        ['departments'=>$departments, 'HRM' => $HRM])

                                        <input type="hidden" id="hrm__edit--modal" value="{{ $HRM->id }}">
                                        @if (!empty($errors->all()) && old('date_start'))
                                            <script>
                                                var id = $('#hrm__edit--modal').val();
                                                var getModal = '#HRM__modal--edit_' + id;
                                                $(getModal).modal('show');
                                            </script>
                                        @endif
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
