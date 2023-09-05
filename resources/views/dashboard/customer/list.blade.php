@extends('layouts.dashboard', ['key' => 'dashboard_customer', 'menu_type' => 'menu_sidebars' , 'isShowError' => false])
@section('extra_cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
        .owl-stage-outer {
            margin-left: 10px;
        }
    </style>
    <div id="content" class="ml-3 mt-2">
        <div class="card">
            <div class="card-header py-0 font-weight-bold bg-white">

                {{-- Add customer form modal --}}
                <div class="row">
                    <div class="col-md-7 col-12">
                        <nav class="menu mb-2 mb-md-0">
                            <input type="checkbox" class="menu-open document__button--gradient" name="menu-open"
                                id="menu-open" />

                            <label class="menu-open-button d-flex align-items-center justify-content-center" for="menu-open"
                                title="Thêm mới">
                                <i class="fas fa-plus"></i>
                            </label>
                            <button type="button" data-bs-target="#addPersonal" data-bs-toggle="modal"
                                class="btn menu-item d-flex align-items-center justify-content-center" title="Cá nhân"><i
                                    class="fas fa-user-alt"></i></button>
                            <button type="button" data-bs-target="#addEnterprise" data-bs-toggle="modal"
                                class="btn menu-item d-flex align-items-center justify-content-center" title="Tổ chức"><i
                                    class="fas fa-users"></i></button>
                        </nav>
                    </div>

                    @include('dashboard/customer/addPersonal')
                    @if (!empty($errors->all()) && empty(old('tax_code')))
                        <script>
                            $('#addPersonal').modal('show')
                        </script>
                    @endif

                    @include('dashboard/customer/addEnterprise')
                    @if (!empty($errors->all()) && old('tax_code'))
                        <script>
                            $('#addEnterprise').modal('show')
                        </script>
                    @endif
                    <!--      Search      -->
                    <div
                        class="col-md-5 col-12 d-flex justify-content-center mb-md-0 mb-2 justify-content-md-end align-items-center">
                        <div class="form-search form-inline">
                            <form class="d-flex" action="#">
                                <input type="text" name="search" uri-data-search="{{ route('web.customers.liveSearch') }}"
                                    class="form-control customer__input--search" placeholder="Tìm kiếm...">
                                <button type="submit" name="btn-search "
                                    class="btn btn-search__customer btn-primary ml-2"><i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $(".customer__input--search").keyup(
                            function() {

                                var keyword = $(".customer__input--search").val();
                                var route = "{{ route('web.customers.liveSearch') }}";
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
            <div class="card-body px-0 py-0">

                @if (request()->input('status') == 'deleted')
                    <div class="align-items-center mx-4 my-4 customer__button--deleteAll">
                        <ul class="list-unstyled d-flex align-content-start">
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button" class="btn list__customers--status-color customer__status--list"
                                        data-bs-target="#customer__modal--permanentlyDeletedMultipleCustomer"
                                        data-bs-toggle="modal">
                                        <i class="fas fa-trash" title="Xóa vĩnh viễn"></i></button>
                                </div>
                            </li>
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button" class="btn list__customers--status-color customer__status--list"
                                        data-bs-target="#customer__modal--multipleRestore" data-bs-toggle="modal"
                                        title="Khôi phục">
                                        <img src="{{ asset('images/restore.png') }}"></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                @else
                    <!--             Delete All            -->
                    <div class="align-items-center mx-4 my-4 customer__button--deleteAll">
                        <ul class="list-unstyled d-flex align-content-start">
                            <li class="customer__li--border">
                                <div style="font-size: 0.5rem;">
                                    <button type="button" class="btn list__customers--status-color customer__status--list"
                                        data-bs-target="#customer__modal--multipleDelete" data-bs-toggle="modal">
                                        <i class="fas fa-trash" title="Xóa"></i></button>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endif

                @include('dashboard.customer.multipleDelete')
                @include('dashboard.customer.multipleRestore')
                @include('dashboard.customer.permanentlyDeletedMultipleCustomer')

                <div class="row align-items-center mx-4 change__action--ajax">
                    <div class="col-md-8 col-xl-5 col-12 list__customer--respon d-md-block d-none">
                        <div class="analytic my-3 active__ul--li">
                            <ul class="list-unstyled d-flex align-content-start list__customer--ul">
                                <div class="row w-100">
                                    <div class="col-sm-3 col-12 px-0 pb-3 pb-md-0">
                                        <li class="customer__li--border">
                                            <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                                                class="text-secondary mr-3 {{ request()->input('status') == 'all' || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tất
                                                cả <span class="text-muted">({{ $countCustomer }})</span></a>
                                        </li>
                                    </div>
                                    <div class="col-sm-3 col-12 px-0 pb-3 pb-md-0 padding-bottom-customer">
                                        <li class="customer__li--border">
                                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Cá nhân']) }}"
                                                class="text-secondary mr-3 {{ request()->input('status') == 'Cá nhân' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Cá
                                                nhân <span class="text-muted">({{ $customerTypeIsPersonal }}) </span></a>
                                        </li>
                                    </div>
                                    <div class="col-sm-3 col-12 px-0 pb-3 pb-md-0">
                                        <li class="customer__li--border">
                                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Doanh nghiệp']) }}"
                                                class="text-secondary mr-3 {{ request()->input('status') == 'Doanh nghiệp' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tổ
                                                chức <span
                                                    class="text-muted">({{ $customerTypeIsEnterprise }})</span></a>
                                        </li>
                                    </div>
                                    <div class="col-sm-3 col-12 px-0 pb-0 pb-md-0">
                                        <li class="customer__li--border">
                                            <a href="{{ request()->fullUrlWithQuery(['status' => 'deleted']) }}"
                                                class="text-secondary mr-3 {{ request()->input('status') == 'deleted' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                                Đã xóa <span class="text-muted">({{ $countSoftDelete }})</span></a>
                                        </li>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
{{--                    resposive--}}
                    <div class="owl-carousel owl-theme text-center d-md-none d-block">
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                               class="text-secondary mr-3 {{ request()->input('status') == 'all' || request()->input('status') == null ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tất
                                cả <span class="text-muted">({{ $countCustomer }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Cá nhân']) }}"
                               class="text-secondary mr-3 {{ request()->input('status') == 'Cá nhân' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Cá
                                nhân <span class="text-muted">({{ $customerTypeIsPersonal }}) </span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'Doanh nghiệp']) }}"
                               class="text-secondary mr-3 {{ request()->input('status') == 'Doanh nghiệp' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">Tổ
                                chức <span
                                    class="text-muted">({{ $customerTypeIsEnterprise }})</span></a>
                        </div>
                        <div class="item" data-merge="6">
                            <a href="{{ request()->fullUrlWithQuery(['status' => 'deleted']) }}"
                               class="text-secondary mr-3 {{ request()->input('status') == 'deleted' ? 'list__customers--status--border--active list__customers--status--text--active' : 'list__customers--status-color customer__status--list' }}">
                                Đã xóa <span class="text-muted">({{ $countSoftDelete }})</span></a>
                        </div>
                    </div>
                    <script>
                        $('.owl-carousel').owlCarousel({
                            items:2,
                            loop:true,
                            margin:10,
                            merge:true,
                            startPosition:{{ $statusCustomer }},
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
                    <div class="col-md-4 col-xl-7 px-0 col-12 d-flex justify-content-center justify-content-md-end">
                        <a class="my-3 mx-2 text-center" href="{{ route('web.customers.exportExcel') }}">
                            <img src="{{ asset('images/Export.png') }}" alt="export.png">
                            <div>Export</div>
                        </a>
                        <a type="button" class="my-3 mx-2 text-center" data-bs-toggle="modal"
                            data-bs-target="#customer__modal--importFile" class="dropdown-item">
                            <img src="{{ asset('images/Import.png') }}" alt="import.png">
                            <div>Import</div>
                        </a>
                        <a class="my-3 mx-2 text-center" href="{{ route('web.profile.index') }}">
                            <img src="{{ asset('images/setting.png') }}" alt="import.png">
                            <div>Cài đặt</div>
                        </a>
                    </div>

                    @include('dashboard.customer.importFile')

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
                <!--     Check All Box     -->
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.customer__button--deleteAll').hide();
                        $('#check_box').on('click', function() {
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
                                $('#check_box').prop('checked', true)
                            } else {
                                $('#check_box').prop('checked', false)
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
                <div class="col-md-12 table-responsive" style="height:100vh">
                    <table id="dtHorizontalApplicationCustomer" class="table table-borderless border-bottom table-sm">
                        <thead class="border-bottom">
                            <tr class="text-center">
                                <td>
                                    <input type="checkbox" id="check_box">
                                </td>
                                <th scope="col">NV Phụ Trách</th>
                                <th scope="col">Mã KH</th>
                                <th scope="col">Tên Khách Hàng</th>
                                <th scope="col">Loại Khách Hàng</th>
                                <th scope="col">Điện Thoại</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ngày Tạo</th>
                                <th scope="col">Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody id="live-search">
                            @if (count($customers) == 0)
                                <tr>
                                    <td colspan="9" class="text-center">Không có dữ liệu...</td>
                                </tr>
                            @else
                                @foreach ($customers as $customer)
                                    <tr class="border-bottom text-center" id="results">
                                        <td>
                                            <input class="checkbox" type="checkbox" data-id="{{ $customer->id }}">
                                        </td>
                                        @if ($customer->user)
                                            <td>
                                                <img src="{{ $customer->user->img_user ? get_file_thumb('avatar/' . $customer->user->img_user) : asset('images/admin.png') }}"
                                                    alt="avatar"
                                                    class="rounded-circle customer__table--img image__permission--round" />
                                            </td>
                                        @else
                                            <td>
                                                <img src="{{ asset('images/admin.png') }}" alt="avatar"
                                                    class="rounded-circle customer__table--img image__permission--round" />
                                            </td>
                                        @endif
                                        </td>
                                        <td>{{ $customer->customer_code }}</td>
                                        <td>
                                            <a type="button" data-uri="{{ route('web.customers.show', $customer->id) }}"
                                                id="showCustomerButton" class="btn ml-1 customer__list--name"
                                                data-bs-toggle="modal" data-toggle="modal" data-bs-target="#showCustomer">
                                                {{ $customer->name }}
                                            </a>

                                        </td>
                                        @if ($customer->customer_type == 'Doanh nghiệp')
                                            <td>Doanh nghiệp</td>
                                        @elseif($customer->customer_type == 'Cá nhân')
                                            <td>Cá Nhân</td>
                                        @else
                                            <td class="customerType__null--td"></td>
                                        @endif
                                        <td>{{ $customer->phone_number }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ date('d/m/Y', strtotime($customer->created_at)) }}</td>
                                        @if (request()->input('status') == 'deleted')
                                            <td>
                                                <div class="customer__dropdown--list">
                                                    <i class="fas fa-ellipsis-h list__customers--color--cursor"
                                                        style="font-size: 1.5em"></i>
                                                    <div class="dropdown-content">
                                                        <a type="button" data-toggle="modal"
                                                            data-uri-restore="{{ route('web.customers.show', $customer->id) }}"
                                                            id='customer__button--showModal--restore'
                                                            data-target="#customer__modal--restore" class="dropdown-item">
                                                            <img src="{{ asset('images/restore_from_trash_black.png') }}"
                                                                alt="trash"> Khôi phục</a>
                                                        <a type="button" data-toggle="modal"
                                                            data-uri-permanentlyDeleted="{{ route('web.customers.show', $customer->id) }}"
                                                            id='customer__button--showModal--permanentlyDeleted'
                                                            data-target="#customer__modal--permanentlyDeleted"
                                                            class="dropdown-item">
                                                            <i class="fa fa-trash"></i> Xoá vĩnh viễn</a>
                                                    </div>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <div class="customer__dropdown--list">
                                                    <i class="fas fa-ellipsis-h list__customers--color--cursor"></i>
                                                    <div class="dropdown-content">
                                                        <a type="button" data-toggle="modal"
                                                            data-uri-delete="{{ route('web.customers.show', $customer->id) }}"
                                                            id='customer__button--showModal--softDelete'
                                                            data-target="#customer__modal--delete" class="dropdown-item"><i
                                                                class="fa fa-trash"></i> Xoá</a>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                @include('dashboard/customer/show')
                @include('dashboard/customer/edit')
                @include('dashboard/customer/delete')
                @include('dashboard/customer/restore')
                @include('dashboard/customer/permanentlyDeleted')
                @endif
            </div>
        </div>
    </div>
    <script>
        $('.hideModal').click(() => {
            $('#addEnterprise').addClass('d-none');
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('table td #showCustomerButton').click(function() {
                var uri = $(this).attr('data-uri');
                $.ajax({
                    url: uri,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#customer_code_show').text(data.customer_code);
                        $('#tax_code_show').text(data.tax_code);
                        $('#name_show').text(data.name);
                        $('#name_company_show').text(data.name_company);
                        $('#address_show').text(data.address);
                        $('#account_number_show').text(data.account_number);
                        $('#payments_show').text(data.payments);
                        $('#customer_type_show').text(data.customer_type);
                        $('#email_show').text(data.email);
                        $('#name_bank_show').text(data.name_bank);
                        $('#phone_number_show').text(data.phone_number);
                        $('#id').val(data.id);
                    },
                })
            })
        })
    </script>
    <!-- softDelete -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('table td #customer__button--showModal--softDelete').click(function() {
                var uri = $(this).attr('data-uri-delete');
                $.ajax({
                    url: uri,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#customer__id--softDelete').val(data.id);
                    },
                })
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('table td #customer__button--showModal--restore').click(function() {
                var uri = $(this).attr('data-uri-restore');
                $.ajax({
                    url: uri,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#customer__id--restore').val(data.id);
                    },
                })
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('table td #customer__button--showModal--permanentlyDeleted').click(function() {
                var uri = $(this).attr('data-uri-permanentlyDeleted');
                $.ajax({
                    url: uri,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#customer__id--permanentlyDeleted').val(data.id);
                    },
                })
            })
        })
    </script>

    {{ $customers->links('pagination') }}
@endsection
