@extends('layouts.dashboard', ['key' => 'dashboard_application', 'menu_type' => 'menu_sidebars'])
@section('extra_cdn')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.theme.default.min.css') }}">

    <script src="jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
@endsection
@section('content')
    @if (session('message_application'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> {{ session('message_application') }}
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
        .owl-dots {
            margin-right: 19px;
        }

    </style>


    <div id="content" class="ml-md-3 mx-2 mt-2">
        <div class="card">
            <div class="application__cardHeader--items">
                <div class="card-header py-3 d-flex justify-content-between align-items-center ">
                    <div class="row w-100">
                        <div class="col-md-7 col-12 add_application--button">
                            {{-- <div class="list__users--bg--button rounded text-white mb-2 mb-md-0">
                                <a class="px-4" href="{{ route('application.create') }}">Thêm mới</a>
                            </div> --}}
                            <nav class="menu mb-2 mb-md-0">
                                <input type="checkbox" class="menu-open document__button--gradient" name="menu-open"
                                       id="menu-open"/>

                                <label class="menu-open-button d-flex align-items-center justify-content-center"
                                       for="menu-open" title="Thêm mới">
                                    <i class="fas fa-plus"></i>
                                </label>
                                <a href="{{ route('web.applications.create') }}"
                                   class="btn menu-item d-flex align-items-center justify-content-center"
                                   title="Đơn xin nghỉ">
                                    <i class="fas fa-file-alt"></i></a>
                                <a href="{{ route('web.applications.createProposal') }}"
                                   class="btn menu-item d-flex align-items-center justify-content-center"
                                   title="Đơn đề nghị">
                                    <i class="fas fa-id-badge"></i></a>
                            </nav>
                        </div>

                        <!--      Search      -->
                        <div
                            class="col-md-5 col-12 d-flex justify-content-center justify-content-md-end align-items-center">

                            <div class="form-search form-inline">
                                <form class="d-flex" action="#">
                                    <input type="hidden" class="status_input" value="{{ request()->input('status') }}">
                                    <input type="text" name="search"
                                           uri-data-search="{{ route('web.applications.liveSearch') }}"
                                           class="form-control application__input--search" placeholder="Tìm kiếm...">
                                    <button type="submit" name="btn-search "
                                            class="btn btn-primary btn-search__application ml-2"><i
                                            class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $(".application__input--search").keyup(
                                function () {
                                    var keyword = $(".application__input--search").val();
                                    var route = "{{ route('web.applications.liveSearch') }}";
                                    let status = $('.status_input').val() ? $('.status_input').val() : '';
                                    var uri = route + '?status=' + status;
                                    var data = {
                                        keyword: keyword
                                    }
                                    $.ajax({
                                        url: uri,
                                        type: "GET",
                                        data: data,
                                        success: function (response) {
                                            $("#live-search").html(response);
                                        }
                                    });
                                }
                            );
                        })
                    </script>
                </div>
                @if (request()->input('status') == 'deleted')
                    <div class="align-items-center mx-4 my-4 customer__button--deleteAll">
                        <ul class="list-unstyled d-flex align-content-start">
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button"
                                            class="btn list__customers--status-color customer__status--list"
                                            data-bs-target="#application__modal--forceDelete" data-bs-toggle="modal">
                                        <i class="fas fa-trash" title="Xóa vĩnh viễn"></i></button>
                                </div>
                            </li>
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button"
                                            class="btn list__customers--status-color customer__status--list"
                                            data-bs-target="#application__modal--restore" data-bs-toggle="modal"
                                            title="Khôi phục">
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
                                    <button type="button"
                                            class="btn list__customers--status-color customer__status--list"
                                            data-bs-target="#application__modal--multipleDelete" data-bs-toggle="modal">
                                        <i class="fas fa-trash" title="Xóa"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif

                @include('dashboard.application.delete')
                @include('dashboard.application.restore')
                @include('dashboard.application.forceDelete')

                <div class="row align-items-center mx-4 change__action--ajax">
                    <div class="col-md-9 col-12 d-md-block d-none">
                        <div class="analytic my-3 active__ul--li">
                            <ul class="list-unstyled d-flex align-content-start list__status--application flex-wrap">
                                <li class="customer__li--border pr-5">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                                       class="text-secondary  mb-3 {{ request()->input('status') == 'all' || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Tất cả <span class="text-muted">({{ $countApplications }})</span></a>
                                </li>
                                <li class="customer__li--border  pr-5">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Chờ duyệt']) }}"
                                       class="text-secondary {{ request()->input('status') == 'Chờ duyệt' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Chờ duyệt <span class="text-muted">({{ $customerStatusIsWaiting }})
                                        </span></a>
                                </li>
                                <li class="customer__li--border  pr-5">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Đã duyệt']) }}"
                                       class="text-secondary  {{ request()->input('status') == 'Đã duyệt' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Đã duyệt <span
                                            class="text-muted">({{ $customerStatusIsApproved }})</span></a>
                                </li>
                                <li class="customer__li--border  pr-5">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Không duyệt']) }}"
                                       class="text-secondary  {{ request()->input('status') == 'Không duyệt' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Không duyệt <span
                                            class="text-muted">({{ $customerStatusIsCancel }})</span></a>
                                </li>
                                <li class="customer__li--border  pr-5">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'deleted']) }}"
                                       class="text-secondary  {{ request()->input('status') == 'deleted' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Đã xóa <span class="text-muted">({{ $countSoftDelete }})</span></a>
                                </li>
                                <li class="customer__li--border customer__media--application pr-5 mt-0">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Đơn xin nghỉ']) }}"
                                       class="text-secondary  {{ request()->input('status') == 'Đơn xin nghỉ' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Đơn xin nghỉ <span
                                            class="text-muted">({{ $customerApplicationType }})</span></a>
                                </li>
                                <li class="customer__li--border customer__media--proposal pr-5 mt-0">
                                    <a href="{{ request()->fullUrlWithQuery(['status' => 'Đơn đề nghị']) }}"
                                       class="text-secondary  {{ request()->input('status') == 'Đơn đề nghị' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                        Đơn đề nghị <span
                                            class="text-muted">({{ $customerApplicationTypeProposal }})</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="owl-carousel owl-theme text-center d-md-none d-block">
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                               class="text-secondary  mb-3 {{ request()->input('status') == 'all' || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Tất cả <span class="text-muted">({{ $countApplications }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Chờ duyệt']) }}"
                               class="text-secondary {{ request()->input('status') == 'Chờ duyệt' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Chờ duyệt <span class="text-muted">({{ $customerStatusIsWaiting }})
                                        </span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Đã duyệt']) }}"
                               class="text-secondary  {{ request()->input('status') == 'Đã duyệt' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Đã duyệt <span
                                    class="text-muted">({{ $customerStatusIsApproved }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Không duyệt']) }}"
                               class="text-secondary  {{ request()->input('status') == 'Không duyệt' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Không duyệt <span
                                    class="text-muted">({{ $customerStatusIsCancel }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'deleted']) }}"
                               class="text-secondary  {{ request()->input('status') == 'deleted' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Đã xóa <span class="text-muted">({{ $countSoftDelete }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Đơn xin nghỉ']) }}"
                               class="text-secondary  {{ request()->input('status') == 'Đơn xin nghỉ' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Đơn xin nghỉ <span
                                    class="text-muted">({{ $customerApplicationType }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Đơn đề nghị']) }}"
                               class="text-secondary  {{ request()->input('status') == 'Đơn đề nghị' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Đơn đề nghị <span
                                    class="text-muted">({{ $customerApplicationTypeProposal }})</span></a>
                        </div>
                    </div>
                    <script>
                        $('.owl-carousel').owlCarousel({
                            items:4,
                            loop:true,
                            margin:10,
                            merge:true,
                            startPosition: {{ $statusApplication }},
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
                            <button class="btn py-3 text-center dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('images/Export.png') }}" alt="export.png">
                                <div>Export</div>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                   href="{{ route('web.applications.exportApplicationForThoughtExcel') }}">Đơn xin nghỉ</a>
                                <a class="dropdown-item"
                                   href="{{ route('web.applications.exportApplicationForProposalExcel') }}">Đơn đề nghị</a>
                            </div>
                        </div>
                        <a class="m-3 text-center" href="{{ route('web.profile.index') }}">
                            <img src="{{ asset('images/setting.png') }}" alt="import.png">
                            <div>Cài đặt</div>
                        </a>
                    </div>

                    {{-- @include('dashboard.application.importFile') --}}

                </div>
            </div>
            @if (session()->has('failures'))
                <div class='col-12 alert'>
                    <table class="table table-danger">
                        <tr>
                            <th>Số Hàng</th>
                            <th>Lỗi</th>
                            <th>Chỗ lỗi</th>
                        </tr>

                        @foreach (session()->get('failures') as $validation)
                            <tr>
                                <td>{{ $validation->row() }}</td>
                                <td>
                                    <ul>
                                        @foreach ($validation->errors() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    {{ $validation->values()[$validation->attribute()] }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            <div>
                <img src="{{ asset('images/hinh.png') }}">
            </div>
            <div class="card-body px-0 py-0">
                <!--     Check All Box     -->
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.customer__button--deleteAll').hide();
                        $('#check_box_application').on('click', function () {
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
                        $('.checkbox').on('click', function () {
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

                        $('.checkbox').on('click', function () {
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
                            <th scope="col">Mã đơn từ</th>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Lý do</th>
                            <th scope="col">Phòng Ban</th>
                            <th scope="col">Vị trí</th>
                            <th scope="col">Đính kèm</th>
                            @if(request()->status == 'Đơn đề nghị')
                                <th scope="col">Số tiền</th>
                            @else
                                <th scope="col">Số ngày</th>
                            @endif
                            <th scope="col">Ngày Tạo</th>
                            {{-- <th scope="col">Mô tả</th> --}}
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="live-search">
                        @if (count($applications) == 0)
                            @if(request()->status != "all" && request()->status != "Đơn xin nghỉ" && request()->status != "Đơn đề nghị" && request()->status != null)
                                <tr>
                                    <td colspan="9" class="text-center">Không có dữ liệu...</td>
                                </tr>
                            @elseif($considerApplication->count() > 0
                                && request()->status == null || request()->status != config('statuses.wait')
                                && request()->status != config('statuses.approved')
                                && request()->status != config('statuses.not')
                                && request()->status != config('statuses.delete')
                            )
                                @include('dashboard.application.listApplicationConsiderW' , compact('considerApplication' , 'countRecommend' , 'countRest'))
                            @else
                            @endif
                        @else
                            @foreach ($applications as $application)
                                <tr class="border-bottom text-center" id="results">
                                    <td>
                                        <input class="checkbox" type="checkbox"
                                               data-id="{{ $application->id }}">
                                    </td>
                                    @if ($application->userApplication)
                                        <td>
                                            <img
                                                src="{{ $application->userApplication->img_user ? get_file_thumb('avatar/' . $application->userApplication->img_user) : asset('images/admin.png') }}"
                                                alt="avatar"
                                                class="rounded-circle customer__table--img image__permission--round"/>
                                        </td>
                                    @else
                                        <td>
                                            <img src="{{ asset('images/admin.png') }}" alt="avatar"
                                                 class="rounded-circle customer__table--img image__permission--round"/>
                                        </td>
                                    @endif
                                    <td>
                                        <a type="button" data-uri="{{ route('web.applications.show', $application->id) }}"
                                           id="showApplicationButton" class="btn ml-1 customer__list--name"
                                           data-bs-toggle="modal" data-toggle="modal"
                                           data-bs-target="#application__modal--show_{{ $application->id }}">
                                            {{ $application->code }}
                                        </a>
                                    </td>
                                    <td>{{ $application->name }}</td>
                                    @include('dashboard.application.show' , ['id' => $application->id] ,
                                    ['application'=> $application])
                                    @if ($application->status == 'Chờ duyệt')
                                        @if (Auth::id() == $application->user_id)
                                            <td>
                                                <button type="button" id="application__button--showModalChangeStatus"
                                                        class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#application__modal--changeStatus"
                                                        class="dropdown-item"
                                                        data-uri="{{ route('web.applications.show', $application->id) }}">
                                                    {{ $application->status }}
                                                </button>
                                            </td>
                                        @else
                                            <td class="text-warning">
                                                {{ $application->status }}
                                            </td>
                                        @endif
                                    @elseif ($application->status == 'Đã duyệt')
                                        <td>
                                            <button style="outline: none ; border: none" class="bg-success text-white px-3 py-2 rounded" disabled>
                                                {{ $application->status }}
                                            </button>
                                        </td>
                                    @elseif ($application->status == 'Không duyệt')
                                        <td class="text-danger">
                                            {{ $application->status }}
                                        </td>
                                    @endif
                                    <td>{{ $application->reason }}</td>
                                    <td>
                                        @if (!empty($application->user->departments))
                                            @foreach ($application->user->departments as $department)
                                                {{ $department->name }}
                                            @endforeach
                                        @else
                                            Chưa có phòng ban
                                        @endif
                                    </td>
                                    <td>{{ $application->position }}</td>
                                    <td>
                                        @if($application->files == '1')
                                            <a
                                                href="{{ route('web.files.downloadApplicationFile', ['applicationId' => $application->id]) }}">
                                                <i class="far fa-arrow-alt-circle-down"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                    @if(request()->status == 'Đơn đề nghị')
                                        {{number_format($application->price_proposal , 0 ,'' , '.')."đ"}}
                                    @else
                                        @php
                                            $informationDays = $application->dateTimeOfApplications;
                                            $countDay = 0;
                                            foreach ($informationDays as $informationDay) {
                                                if ($informationDay->information_day_2 == $informationDay->information_day_4 && $informationDay->information_day_1 ==  $informationDay->information_day_3)
                                                    {
                                                        $countDay+=0.5;
                                                    }else
                                                    {
                                                       $to_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_2);
                                                       $from_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $informationDay->information_day_4);
                                                       $countDay += ($to_date->diffInDays($from_date) + 1);
                                                    }
                                            }
                                            echo $countDay . ' Ngày';
                                        @endphp
                                    @endif
                                    <td>{{$application->created_at}}</td>
                                    {{-- <td class="description__application application__description--text">{!! $application->description !!}</td> --}}
                                    @if ($application->application_type == 'Đơn đề nghị')
                                        <td><a class="m-3" type="button"
                                               href="{{ route('web.applications.editProposal', $application->id) }}"><i
                                                    class="fas fa-edit"></i></a></td>
                                    @else
                                        <td><a class="m-3" type="button"
                                               href="{{ route('web.applications.edit', $application->id) }}"><i
                                                    class="fas fa-edit"></i></a></td>
                                    @endif

                                </tr>
                            @endforeach
                            @if($considerApplication->count() > 0
                            && request()->status != config('statuses.wait')
                            && request()->status != config('statuses.approved')
                            && request()->status != config('statuses.not')
                            && request()->status != config('statuses.delete'))
                                @include('dashboard.application.listApplicationConsiderW' , compact('considerApplication' , 'countRecommend' , 'countRest'))
                            @endif
                            @include('dashboard.application.changeStatus')
                        </tbody>
                    </table>
                    {{ $applications->appends(['status' => request()->status])->links('pagination') }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('table td #application__button--showModalChangeStatus').click(function () {
                var uri = $(this).attr('data-uri');
                $.ajax({
                    url: uri,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#application__changeStatus--id').val(data.id);
                    },
                })
            })
        })
    </script>


@endsection
