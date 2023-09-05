@extends('layouts.dashboard' ,['key' => 'dashboard_contract', 'child_key' => $type == 'personal' ?
'dashboard_contract_local' : 'dashboard_contract_customer', 'menu_type' => 'menu_sidebars'])
@section('extra_cdn')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/owl.theme.default.min.css') }}">

    <script src="jquery.min.js"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
@endsection
@section('content')
    <div class="container-fluid custom__container--fluid" xmlns="http://www.w3.org/1999/html">
        <div class="title__contract mt-2 mb-3">
            <div class="header__create--contact">
                <div class="">
                    <div class="list__users--bg--button text-white rounded">
                        <a class="px-4" href="{{ route('web.contracts.create', ['type' => $type]) }}">
                            {{ $type == 'personal' ? 'Tạo hợp đồng cá nhân' : 'Tạo hợp đồng khách hàng' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__status--contract">
            <div class="d-flex flex-column flex-md-row justify-content-md-between">
                <div class="change__action--ajax d-md-block d-none">
                    <ul class="header__status--contract-list d-flex list-unstyled flex-sm-row flex-column flex-wrap">
                        {{-- <li class="header__list--item"> --}}
                        {{-- <span class="header__status--fz table__contract--item-color">Sắp xếp theo:</span> --}}
                        {{-- </li> --}}
                        {{-- list__customers--status--border--active --}}
                        @php
                            $currentRoute = $type == config('statuses.type_personal') ? route('web.contracts.index') : route('web.contracts.indexCompany');
                        @endphp
                        <li class="header__list--item customer__li--border">
                            <a href="{{ $currentRoute }}">
                                <span
                                    class="{{ !request()->input('status') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Tất
                                    cả ({{ array_sum($statusContracts) }})</span>
                            </a>
                        </li>
                        <li class="header__list--item customer__li--border">
                            <a href="{{ $currentRoute . '?status=new' }}">
                                <span
                                    class="{{ request()->input('status') == 'new' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Mới
                                    tạo ({{ $statusContracts['new'] ?? 0 }})</span>
                            </a>
                        </li>
                        <li class="header__list--item customer__li--border">
                            <a href="{{ $currentRoute . '?status=wait_approval' }}">
                                <span
                                    class="{{ request()->input('status') == 'wait_approval' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Chờ
                                    duyệt ({{ $statusContracts['wait_approval'] ?? 0 }})</span>
                            </a>
                        </li>
                        <li class="header__list--item customer__li--border">
                            <a href="{{ $currentRoute . '?status=close_approval' }}">
                                <span
                                    class="{{ request()->input('status') == 'close_approval' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Từ
                                    chối duyệt ({{ $statusContracts['close_approval'] ?? 0 }})</span>
                            </a>
                        </li>
                        <li class="header__list--item customer__li--border">
                            <a href="{{ $currentRoute . '?status=success' }}">
                                <span
                                    class="{{ request()->input('status') == 'success' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Hoàn
                                    thành ({{ $statusContracts['success'] ?? 0 }})</span>
                            </a>
                        </li>
                        <li class="header__list--item customer__li--border">
                            <a href="{{ $currentRoute . '?status=canceled' }}">
                                <span
                                    class="{{ request()->input('status') == 'canceled' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color customer__status--list">Chưa
                                    hoàn thành ({{ $statusContracts['canceled'] ?? 0 }})</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{--                    resposive--}}
                <div class="owl-carousel owl-theme text-center d-md-none d-block">
                    <div class="item" data-merge="6">
                        <a href="{{ $currentRoute }}">
                                <span
                                    class="{{ !request()->input('status') ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Tất
                                    cả ({{ array_sum($statusContracts) }})</span>
                        </a>
                    </div>
                    <div class="item" data-merge="6">
                        <a href="{{ $currentRoute . '?status=new' }}">
                                <span
                                    class="{{ request()->input('status') == 'new' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Mới
                                    tạo ({{ $statusContracts['new'] ?? 0 }})</span>
                        </a>
                    </div>
                    <div class="item" data-merge="6">
                        <a href="{{ $currentRoute . '?status=wait_approval' }}">
                                <span
                                    class="{{ request()->input('status') == 'wait_approval' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Chờ
                                    duyệt ({{ $statusContracts['wait_approval'] ?? 0 }})</span>
                        </a>
                    </div>
                    <div class="item" data-merge="6">
                        <a href="{{ $currentRoute . '?status=close_approval' }}">
                                <span
                                    class="{{ request()->input('status') == 'close_approval' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Từ
                                    chối duyệt ({{ $statusContracts['close_approval'] ?? 0 }})</span>
                        </a>
                    </div>
                    <div class="item" data-merge="6">
                        <a href="{{ $currentRoute . '?status=success' }}">
                                <span
                                    class="{{ request()->input('status') == 'success' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color">Hoàn
                                    thành ({{ $statusContracts['success'] ?? 0 }})</span>
                        </a>
                    </div>
                    <div class="item" data-merge="6">
                        <a href="{{ $currentRoute . '?status=canceled' }}">
                                <span
                                    class="{{ request()->input('status') == 'canceled' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }} header__status--fz table__contract--item-color list__customers--status-color customer__status--list">Chưa
                                    hoàn thành ({{ $statusContracts['canceled'] ?? 0 }})</span>
                        </a>
                    </div>
                </div>
                <script>
                    $('.owl-carousel').owlCarousel({
                        items:1,
                        loop:true,
                        margin:10,
                        merge:true,
                        startPosition : {{ $statusApplication }},
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
                    <div class="align-items-center customer__button--deleteAll">
                        <ul class="list-unstyled d-flex align-content-start">
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button"
                                            class="btn list__customers--status-color customer__status--list"
                                             data-toggle="modal" data-target="#exampleModalDelete">
                                        <i class="fas fa-trash" title="Xóa"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif

                @include('dashboard.contract.modalDelete')

                <div class="">
                    <div class="header__status--search">
                        <form method="GET">
                            <div class="input-group header__input--search">
                                <div class="form-outline position-relative">
                                    <i class="fas fa-search position-absolute list__users--search--icon"></i>
                                    <input style="width: 237px" value="{{ request()->input('search') }}" type="search"
                                           name="search" autocomplete="off" id="form1" class="form-control form__search--input"
                                           placeholder="Tìm kiếm" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- end-header-status --}}
    <div class="table__contract container-fluid">
        <div class="col-md-12 px-0">
            <div class="table__contract--bg bg-white table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="position-relative table__contract--item-fz">
                                <img class="position-absolute" src="{{ asset('images/hinh.png') }}"
                                    style="top: 0px; left: 0px">
                                <div class="form-check d-flex flex-row justify-content-center">
                                    <input class="form-check-input" data-status="{{request()->status}}" type="checkbox"  id="check_box_application">
                                </div>
                            </th>
                            <th scope="col" class="table__contract--item-fz text-dark">STT</th>
                            <th scope="col" class="table__contract--item-fz text-dark">Mã hợp đồng</th>
                            <th scope="col" class="table__contract--item-fz text-dark">Tên khách hàng</th>
                            <th scope="col" class="text-center text-dark">Tình trạng</th>
                            <th scope="col" class="text-center table__contract--item-fz text-dark">Chữ ký điện tử</th>
                            <th scope="col" class="table__contract--item-fz text-dark">Bản cứng</th>
                            <th scope="col" class="table__contract--item-fz text-dark">Gửi email</th>
                            <th scope="col" class="table__contract--item-fz text-dark">Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($listContract->count())
                            @foreach ($listContract as $contract)
                                <tr>
                                    <th scope="col" class="position-relative table__contract--item-fz text-center">
                                            <div class="form-check d-flex flex-row justify-content-center">
                                                @if(!$contract->is_mailed)
                                                <input class="form-check-input checkbox" data-status="{{request()->status}}"
                                                       name="checkContract[]"
                                                       type="checkbox" data-id={{$contract->id}}
                                                       id="formCheckAll">
                                                    @endif
                                            </div>
                                    </th>
                                    <th scope="row" class=" table__contract--item-color">{{ $stt++ }}</th>
                                    <td class="f table__contract--color">
                                        <button style="outline: none ; color: #4E39C0" type="button"
                                            class="border-0 bg-white pl-0 header__status--fz one__click--detail"
                                            data-id="{{ $contract->id }}" data-toggle="modal"
                                            data-target="#exampleModalLong">
                                            {{ $contract->code }}
                                        </button>
                                    </td>
                                    <td class=" table__contract--item-color header__status--fz">
                                        {{ $contract->name_customer }}</td>
                                    <td class=" table__contract--item-color " style="max-width: 120px">
                                        @if ($contract->status == 'wait_approval')
                                            <div
                                                class="table__contract--button rounded py-1 table__contract--button bg-warning text-white text-center">
                                                Chờ duyệt
                                            </div>
                                        @elseif($contract->status == 'close_approval')
                                            <div
                                                class="table__contract--button rounded py-1 table__contract--button bg-danger text-white text-center">
                                                Từ chối duyệt
                                            </div>
                                        @elseif($contract->status == 'success')
                                            <div
                                                class="table__contract--button rounded py-1 table__contract--button bg-success text-white text-center">
                                                Thành công
                                            </div>
                                        @elseif($contract->status == 'canceled')
                                            <div
                                                class="table__contract--button rounded py-1 table__contract--button bg-warning text-white text-center">
                                                Chưa hoàn thành
                                            </div>
                                        @endif
                                    </td>
                                    <td class="table__contract--item-color text-center">
                                        <a class="border-bottom border-2"
                                            href="{{ route('web.contracts.fastSignature', ['id' => $contract->id]) }}">Ký
                                            tên</a>
                                    </td>
                                    <td class=" pl-md-4 text-secondary cursor" style="font-size: 26px">
                                        @if (count($contract->file) || count($contract->files))
                                            {{-- <a href="{{ route('file.download', ['filename' => $contract->file[0]->name]) }}"> --}}
                                            {{-- <i class="far fa-arrow-alt-circle-down"></i> --}}
                                            {{-- </a> --}}
                                            <a
                                                href="{{ route('web.files.downloadZipFile', ['contractId' => $contract->id]) }}">
                                                <i class="far fa-arrow-alt-circle-down"></i>
                                            </a>
                                        @else
                                            <a href="#">
                                                <i class="far fa-arrow-alt-circle-down"></i>
                                            </a>
                                        @endif
                                    </td>

                                        @if (!$contract->is_mailed)
                                            @if ($contract->status == 'wait_approval')
                                            <td class=" text-secondary cursor" style="font-size: 26px">
                                                <form method="post" action="{{ route('web.contracts.publishContract') }}">
                                                    @csrf
                                                    <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                                                    <button class="btn sendmail-btn pl-md-2 pl-0" type="submit"
                                                            data-contract="{{ $contract->id }}">
                                                            <i class="far fa-envelope fa-2x"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            @else
                                                <td class="table__contract--item-color ">
                                                    <a class="pl-md-2 pl-0">Chưa hoàn tất.</a>
                                                </td>
                                            @endif
                                        @else
                                        <td class="table__contract--item-color ">
                                            <a class="pl-md-2 pl-0">Đã gửi.</a>
                                        </td>
                                    @endif
                                    <td class=" table__contract--item-color">
                                        {{ \Carbon\Carbon::parse($contract->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">
                                    <h5 class="text-center">Danh sách hợp đồng trống</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{-- end-table --}}
                <div class="paginate__contract my-2">
                    <div>
                        <div class="col-md-12 py-3">
                            {{ $listContract->links('pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal_show --}}
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
            <div class="modal-content" style="border-radius: 25px">
                <div class="container-fluid exampleModalLong--1" style="overflow-y: scroll">

                </div>
            </div>
        </div>

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


    <script>
        $(document).ready(function() {
            $(".paginate__contract--click").click(function() {
                $(".paginate__contract--click").removeClass('paginate__contract--active')
                $(this).addClass('paginate__contract--active')
                return false;
            })
        })
    </script>
    {{-- detail_contract --}}
    <script>
        $(document).ready(function() {
            $('.one__click--detail').click(function() {
                let id = $(this).attr('data-id');
                let data = {
                    id: id
                }
                $.ajax({
                    url: "{{ route('web.contracts.contractDetail') }}",
                    data: data,
                    method: 'GET',
                    dataType: 'html',
                    success: function(data) {
                        console.log(data)
                        $('#exampleModalLong .modal-content').html(data);
                    },
                })
            })
        })
    </script>
@endsection
