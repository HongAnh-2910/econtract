@extends('layouts.dashboard' ,['type' => 'dashboard_contract', 'menu_type' => 'menu_sidebars' , 'isShowError' => false])

@section('extra_cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection
@section('content')
    <div class="container-fluid pt-3 custom__container--fluid bg-white">
        <div class="container__bg--full" style="background-color: #E3E3E3">
            <form method="POST" action="{{ route('web.contracts.contractUpdate',$id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="contianer__bg--white bg-white pl-0">
                    <div class="create__contract--title">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <span class="create__contract--style">SỬA HỢP ĐỒNG KÝ DUYỆT</span>
                            </div>
                        </div>
                    </div>
                    {{--end-title-header--}}
                    <div class="create__contract--form pl-md-3 pl-2 pr-md-3 pr-2 pl-lg-2">
                        <div class="pb-2">
                            <div class="d-sm-flex flex-sm-wrap">
                                <div class="form-group mb-lg-3 col-md-12 px-0 px-sm-1">
                                    <label for="exampleInputEmail1"
                                           class="text-dark mb-1 pt-2 px-2">Mã
                                        Hợp
                                        đồng <span
                                                class="text-danger">*</span></label>
                                    <div class="px-0">
                                        <div class="px-0">
                                            <div class="pl-0">
                                                <input type="text" name="code_contract"
                                                       class="form-control p-2"
                                                       value="{{ $itemContract->code }}"
                                                       id="inputPassword" placeholder="01GTKT0/001">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                                    <label for="inputPassword" class="text-dark mb-1 px-2 pt-2">Số
                                        hóa
                                        đơn</label>
                                    <div class="pl-0 mb-2 mb-md-0">
                                        <input name="species_contract" type="text" class="form-control p-2" value="20"
                                               id="inputPassword" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1">
                                    <div class="">
                                        <div class="">

                                            <div class="">

                                                <div class="form-group mb-0">
                                                    <label for="data"
                                                           class="text-dark mb-1 px-2 pt-2">Ngày
                                                        hợp đồng</label>
                                                    <div class="pl-0 create__contract--form--exit">

                                                        <input type="date" name="date_contract"
                                                               value="{{ substr_replace($itemContract->created_at,"",-9)  }}"
                                                               class="form-control p-2"
                                                               id="data" placeholder="17/06/2020">
                                                        @error('date_contract')
                                                        <div class="text text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--ms-thue--}}
                                @if($itemContract->type == 'company')
                                    <div class="form-group col-sm-12 pl-0 pr-0 pr-sm-1 pl-sm-1 pr-md-1 pl-md-1">
                                        <label for="inputPassword" class="text-dark mb-1 px-2 pt-1 pt-md-2">Mã
                                            số
                                            thuế</label>
                                        <div class="position-relative">
                                            <div class="form-group mr-0 mb-0">
                                                <input data-uri="{{ route('web.contracts.getData') }}" type="text"
                                                       name="code_contract_stt"
                                                       value="{{ $itemContract->code_fax }}"
                                                       class="form-control p-2" id="get_data"
                                                       placeholder="Mã số thuế">
                                            </div>
                                            <div id="submitGetInfoCompany"
                                                 class="btn__get--information create__contract--form--btn create__contract--form--abs1 d-inline-block text-white position-absolute">
                                                Lấy thông tin
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{--customer--}}

                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                                    <label for="inputPassword" class="text-dark mb-1 px-2 pt-1 pt-md-2">Tên
                                        khách
                                        hàng</label>
                                    <div class="pl-0">

                                        <input type="text"
                                               value="{{ $itemContract->name_customer }}"
                                               class="form-control p-2 name_manager" name="name_manager"
                                               id="inputPassword" placeholder="Tên Giám đốc">
                                        @error('name_manager')
                                        <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1">
                                    <div class="">
                                        <div class="">
                                            <div class="">
                                                <div class="form-group mb-0">
                                                    <label for="data"
                                                           class="text-dark mb-1 px-2 pt-2">Email</label>
                                                    <div class="pl-0 create__contract--form--exit">

                                                        <input type="text" value=" {{ old('name_email') ?? $itemContract->email }}"
                                                               class="form-control p-2 name_email" name="name_email"
                                                               id="data" placeholder="Email">
                                                        @error('name_email')
                                                        <div class="text text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--name_cty--}}

                                @if($itemContract->type == 'company')
                                    <div class="form-group col-sm-12 px-0 px-sm-1 px-md-1">
                                        <label for="inputPassword" class="text-dark mb-1 px-2 pt-md-2 pt-1">Tên
                                            công
                                            ty</label>
                                        <div class="position-relative">
                                            <div class="form-group mb-0 mr-0">

                                                <input type="text" class="form-control p-2 name_cty"
                                                       value="{{ $itemContract->name_cty }}"
                                                       name="name_cty"
                                                       id="data"
                                                       placeholder="Tên công ty">
                                                @error('name_cty')
                                                <div class="text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{--dia chi--}}

                                <div class="form-group col-sm-12 px-0 px-sm-1 px-md-1">
                                    <label for="exampleInputEmail1"
                                           class="text-dark mb-1 px-2 pt-2">Địa
                                        chỉ<span
                                                class="text-danger pl-1">*</span></label>
                                    <div class="position-relative">
                                        <div class="form-group mb-0 mr-0">

                                            <input type="text" class="form-control p-2 addres_cty"
                                                   value="{{ $itemContract->address }}"
                                                   name="addres_cty"
                                                   id="data"
                                                   placeholder="Địa chỉ">
                                            @error('addres_cty')
                                            <div class="text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{--stk--}}

                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                                    <label for="inputPassword" class="text-dark mb-1 px-2 pt-2">Số
                                        tài
                                        khoản</label>
                                    <div class="pl-0 mb-2 mb-md-0">
                                        <input type="text" name="stk_contract"
                                               value="{{ $itemContract->name_account }}"
                                               class="form-control p-2"
                                               id="inputPassword" placeholder="Số tài khoản">
                                        @error('stk_contract')
                                        <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1">
                                    <div class="">
                                        <div class="">
                                            <div class="">
                                                <div class="form-group mb-0">
                                                    <label for="data"
                                                           class="text-dark px-2 mb-1 pt-2">Tại
                                                        ngân hàng</label>
                                                    <div class="pl-0 create__contract--form--exit">

                                                        <input autocomplete="off" type="text"
                                                               value="{{ $valueBanking->vn_name ?? '' }}"
                                                               class="form-control p-2" name="search"
                                                               id="data__banking">
                                                        @error('search')
                                                        <div class="text text-danger">{{ $message }}</div>
                                                        @enderror
                                                        @include('dashboard.contract.search_banking')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--hinh-thuc--}}

                                <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                                    <label for="inputPassword" class=" text-dark px-2 mb-1 pt-2">Hình thức thanh
                                        toán</label>
                                    <div class="">
                                        <div class="">
                                            <div class="pl-0 create__contract--form--exit position-relative">
                                                <select class="form-control p-2" id="exampleFormControlSelect1"
                                                        name="payments">
                                                    <option value="1">Tiền mặt/Chuyển khoản</option>
                                                </select>
                                                <i class="fas fa-chevron-down text-secondary position-absolute create__contract--abs"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--list-contract-content--}}

                <div class="box__contract--list--end bg-white">
                    <div class="header__card--contacts">
                        <div class="col-md-12 modal__contract--bg--header py-2 pl-3">
                            <span class="text-dark pl-2 pl-md-3 d-inline-block py-1 pl-lg-2">DANH SÁCH HỢP ĐỒNG</span>
                        </div>
                    </div>
                    {{--end-list-contract-header--}}
                    <div class="bg-white content__card--contacts pl-2 pr-2 pl-md-3 pr-md-3 pl-lg-2" style="overflow-y: hidden">
                        @error('files.*')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <div class="col-md-12 px-0">
                            <div class="button__contract--list--upload mt-4">
                                <div class="btn btn-primary btn__upload--contacts rounded btn__upload--contacts button-account-edit box-shadow-account"
                                     data-bs-target="#uploadFileModal" data-dismiss="modal">
                                    <label for="select_file" class="mb-0">Tải hợp đồng</label>
                                </div>
                                <input type="file" name="files[]" id="select_file" multiple hidden>
                                <div
                                        class="btn btn-primary rounded button-account-edit btn__upload--sample--contacts box-shadow-account"
                                        data-toggle="modal" data-target="#exampleModalLong">Tải hợp đồng mẫu
                                </div>
                                <div class="button__contract--list--support mt-4 mb-4">
                                    <span class="text-danger">*</span> Định dạng được hỗ trợ: .pdf
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 px-0">
                            <div class="box__child--list--contract pb-1">
                                @if($listFilesContract->count()>0)
                                    @foreach($listFilesContract as $file)
                                        <div
                                                class="modal__contract--list--contract px-2 mt-3 mb-3 border rounded d-flex justify-content-between">
                                            <input type="hidden" name="files_exist[]" value="{{$file->id}}" />
                                            <div class="modal__contract--list--item d-flex">
                                                <div class="modal__contract--list--icon d-flex align-items-center pr-2">
                                                    <img width="27" height="25"
                                                         src="{{ get_extension_thumb($file->type) }}">
                                                </div>
                                                <div class="show__upload--contacts">
                                                    <span class="modal__contract--list-title">{{ $file->name }}</span>
                                                    <span
                                                            class="d-block modal__contract--list-size">{{ $file->size }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div
                                                    class="dropdown d-flex align-items-center px-2 list__users--color--cursor">
                                                <div class="dropdown-toggle" id="dropdownMenuButton"
                                                     data-toggle="dropdown"
                                                     aria-haspopup="true" aria-expanded="false">
                                                </div>
                                                <div class="remove__file--button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                {{--files--}}
                                @if($itemContract->files->count() > 0)
                                    @foreach($itemContract->files as $file)
                                        <div
                                                class="modal__contract--list--contract px-2 mt-3 mb-3 border rounded d-flex justify-content-between">
                                            <input id="id_contract2" type="text" class="file__contract--id" name="id_contract[]" value="{{ $file->id }}" hidden>
                                            <input id="id_contract2" type="text" name="name_contracts[]" value="{{ $file->name }}" hidden>
                                            <div class="modal__contract--list--item d-flex">
                                                <div class="modal__contract--list--icon d-flex align-items-center pr-2">
                                                    <img width="27" height="25"
                                                         src="{{ get_extension_thumb($file->type) }}">
                                                </div>
                                                <div class="">
                                                    <span class="modal__contract--list-title">{{ $file->name }}</span>
                                                    <span
                                                            class="d-block modal__contract--list-size">{{ $file->size }}</span>
                                                </div>
                                            </div>

                                            <div class="dropdown d-flex align-items-center px-2 list__users--color--cursor">
                                                {{--                                                <div class="dropdown-toggle" id="dropdownMenuButton"--}}
                                                {{--                                                     data-toggle="dropdown"--}}
                                                {{--                                                     aria-haspopup="true" aria-expanded="false">--}}
                                                {{--                                                    <i style="font-size: 20px" class="fas fa-ellipsis-v"></i>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div style="width: 60px" class="dropdown-menu"--}}
                                                {{--                                                     aria-labelledby="dropdownMenuButton">--}}
                                                {{--                                                    <form method="POST">--}}
                                                {{--                                                        <button class="dropdown-item"--}}
                                                {{--                                                                style="font-size: 15px ; outline: none">--}}
                                                {{--                                                            <i class="fas fa-window-restore"></i>--}}
                                                {{--                                                            Tác vụ 1--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    </form>--}}
                                                {{--                                                    <button--}}
                                                {{--                                                        data-toggle="modal" data-target="#exampleModal1"--}}
                                                {{--                                                        class="dropdown-item" type="submit"--}}
                                                {{--                                                        data-toggle="tooltip"--}}
                                                {{--                                                        style="font-size: 15px; outline: none"><i--}}
                                                {{--                                                            class="fa fa-trash"></i> Tác vụ 2--}}
                                                {{--                                                    </button>--}}
                                                {{--                                                </div>--}}
                                                <div class="remove__file--button" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    {{--                end-list-contract-header1--}}

                    <div class="header__card--contacts">
                        <div class="col-md-12 modal__contract--bg--header py-2 pl-3">
                            <span class="text-dark pl-2 pl-md-3 d-inline-block py-1 pl-lg-2">DANH SÁCH NGƯỜI NHẬN</span>
                        </div>
                    </div>

                    {{--end-title-customer-active--}}

                    <div class="bg-white pt-3 pb-4">
                        <div class="box__box--box-update">
                            @if($listRecipients->count() > 0)
                                @foreach($listRecipients as $recipient)
                                    <div class="contract__box--face d-sm-flex pl-2 pr-2 flex-sm-wrap d-flex-none mb-4 pl-sm-1 pr-sm-0 pr-md-3 pl-md-3 px-lg-2">
                                        <div class=" col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2 col-lg-5 col-xl-4 pr-lg-1">
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark mb-1 pt-2 pl-2 text-nowrap" for="exampleInputEmail1">Tên
                                                    cá
                                                    nhân,
                                                    công ty,
                                                    doanh nghiệp <span class="text-danger">*</span></label>
                                                <input type="text" name="business_name[]"
                                                       class="form-control p-2 rounded-0"
                                                       id="exampleInputEmail1"

                                                       value="{{ $recipient->name }}"
                                                       aria-describedby="emailHelp">
                                                @error('business_name.*')
                                                <div class="text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1 col-sm-6 col-lg-2 pl-lg-1 px-xl-2">
                                            <div class="input-group d-md-flex justify-content-md-center d-flex-none form-group">
                                                <div class="form-outline position-relative w-100">
                                                    <label class="form-label font-weight-bold text-dark mb-1 pl-2 pt-2" for="form1">Trình
                                                        tự kí
                                                        <span class="text-danger mb-1">*</span>
                                                    </label>
                                                    <i class="fas fa-chevron-down position-absolute contract__list--icon--down"></i>
                                                    <select
                                                            disabled
                                                            name="status_signing[]"
                                                            class="form-control rounded-0 p-2 w-100 contract__list--select--wh"
                                                            id="exampleFormControlSelect1">
                                                        @foreach($listStatusReceiver  as $k => $v)
                                                            @if($recipient->signing_sequence == $v)
                                                                <option selected value="{{ $v }}">{{ $v }}
                                                            @else
                                                                <option value="{{ $v }}">{{ $v }}
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" form-group mt-md-0 col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2 pr-lg-1 col-lg-2 px-xl-2">
                                            <div class="input-group d-md-flex justify-content-center d-flex-none form-group">
                                                <div class="form-outline w-100">
                                                    <label class="form-label font-weight-bold text-dark mb-1 pt-2 pl-2" for="form1">
                                                        Số điện thoại
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="phone_contract[]" type="search" id="form1" value="{{ $recipient->phone }}"
                                                           class="form-control rounded-0 p-2" placeholder=" " />
                                                    @error('phone_contract.*')
                                                    <div class="text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-md-0 form-group col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1 pl-lg-1 col-lg-3 col-xl-3 px-xl-2">
                                            <div class="input-group d-md-flex justify-content-center d-flex-none">
                                                <div class="form-outline w-100">
                                                    <label class="form-label font-weight-bold text-dark mb-1 pl-2 pt-2" for="form1">
                                                        Địa chỉ email
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="email_contract[]" type="search" id="form1"
                                                           value="{{ $recipient->email }}" class="form-control rounded-0 p-2"
                                                           placeholder="" />
                                                    @error('email_contract.*')
                                                    <div class="text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="box--html--add"></div>
                        </div>
                        {{--                        <div class="col-md-12 px-2 px-md-3 px-lg-2 mx-md-1 mx-lg-0">--}}
                        {{--                            <div class="btn btn-primary mx-lg-1 rounded button-account-edit py-2 box-shadow-account mb-3 button-account-edit1"--}}
                        {{--                                 data-dismiss="modal" style="background-color: #5442BC ; font-size: 15px">--}}
                        {{--                                <i class="fas fa-user-friends pr-1"></i>--}}
                        {{--                                Thêm người nhận--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="col-md-12 mt-3 px-2 px-lg-2 px-md-3">
                            <div class="contract__list--alert px-0 px-md-1">
                                <p style="font-size: 15px ">Khi email được chuyển đến tất cả người nhận và các tài liệu
                                    được
                                    ký, mỗi người sẽ nhận
                                    được một bản sao hoàn thành</p>
                            </div>

                        </div>
                    </div>
                    {{-- edit follow--}}
                    <div class="header__card--contacts">
                        <div class="col-md-12 modal__contract--bg--header py-2 pl-3">
                            <span class="text-dark pl-2 pl-md-3 d-inline-block py-1 pl-lg-2">DANH SÁCH NGƯỜI THEO DÕI</span>
                        </div>
                    </div>
                    {{-- LIST FOLLOW--}}
                    <div class="bg-white pt-3 pb-4">
                        <div class="box__box--box">
                            @if($listFollowId->count() > 0)
                                @foreach($listFollowId as $listFollow)
                                    <div class="contract__box--face d-sm-flex pl-2 pr-2 flex-sm-wrap d-flex-none mb-4 pl-sm-1 pr-sm-0 pr-md-3 pl-md-3 px-lg-2">
                                        <div class=" col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2 col-lg-5 col-xl-4 pr-lg-1">
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark mb-1 pt-2 pl-2 text-nowrap" for="exampleInputEmail1">Tên
                                                    cá
                                                    nhân,
                                                    công ty,
                                                    doanh nghiệp <span class="text-danger">*</span></label>
                                                <input type="text" name="business_name_follow[][]"
                                                       class="form-control p-2 rounded-0"
                                                       id="exampleInputEmail1"
                                                       disabled
                                                       value="{{ $listFollow->business_name_follow }}"
                                                       aria-describedby="emailHelp">
                                                @error('business_name_follow.*')
                                                <div class="text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class=" form-group mt-md-0 col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2 pr-lg-1 col-lg-2 px-xl-2">
                                            <div class="input-group d-md-flex justify-content-center d-flex-none form-group">
                                                <div class="form-outline w-100">
                                                    <label class="form-label font-weight-bold text-dark mb-1 pt-2 pl-2" for="form1">
                                                        Số điện thoại
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="phone_contract_follow[]" type="search" id="form1" value="{{ $listFollow->phone_follow }}"
                                                           class="form-control rounded-0 p-2" disabled placeholder=" " />
                                                    @error('phone_contract_follow.*')
                                                    <div class="text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-md-0 form-group col-sm-6 pr-0 pl-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1 pl-lg-1 col-lg-3 col-xl-3 px-xl-2">
                                            <div class="input-group d-md-flex justify-content-center d-flex-none">
                                                <div class="form-outline w-100">
                                                    <label class="form-label font-weight-bold text-dark mb-1 pl-2 pt-2" for="form1">
                                                        Địa chỉ email
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input name="email_contract_follow[]" type="search" id="form1" disabled
                                                           value="{{ $listFollow->email_follow }}" class="form-control rounded-0 p-2"
                                                           placeholder="" />
                                                    @error('email_contract_follow.*')
                                                    <div class="text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="box--html--add"></div>
                        </div>
                        <div class="col-md-12 mt-3 px-2 px-lg-2 px-md-3">

                            <div
                                    class="contract__list--button--status d-flex justify-content-md-end justify-content-center  pr-md-1 pr-lg-2 pr-xl-3 pr-0">
                                <a href="{{$itemContract->type == config('statuses.type_personal') ? route('web.contracts.index') : route('web.contracts.indexCompany')}}"
                                   class="btn__back--list btn rounded button-account-edit ml-md-2 box-shadow-account ml-0"
                                   data-dismiss="modal">Hủy bỏ
                                </a>
                                <button
                                        class="btn btn-primary rounded btn__submit--contract button-account-edit ml-3 box-shadow-account"
                                        data-dismiss="modal" style="background-color: #5442BC">Tiếp theo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Upload file modal -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg"
             role="document">
            <form method="POST" action="{{ route('web.files.store') }}" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="exampleModalCenterTitle">
                            Tải lên hợp dồng
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="dropzone mt-5 mx-2" id="file-dropzone"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Đóng</span>
                        </button>
                        <button id="uploadFileButton" type="submit" class="btn btn-primary ml-1">
                            Lưu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--    modal--}}
    <div class="modal fade text-left w-100 pr-0" id="exampleModalLong" tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel20" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal__sample--contacts"
             role="document">
            <div class="modal-content" style="border-radius: 25px;height: 538px">
                <div class="container-fluid container__upload--contacts" style="overflow-y: scroll">
                    <div class="">
                        <div class="col-md-12 mt-4 px-0 px-md-2">
                            <div class="content__upload--search--contract d-md-flex justify-content-md-between">
                                <div class="px-2 px-md-0 py-md-2">
                                    <input autocomplete="off" name="search" type="text"
                                           class="form-control onchange__search" id="exampleInputPassword1"
                                           placeholder="Tìm kiếm">
                                </div>
                                <div class="header__upload--contract d-md-flex d-none py-md-2">
                                    <button
                                            class="btn btn-primary rounded button__click--add--contract button-account-edit px-5 box-shadow-account"
                                            data-dismiss="modal"
                                            style="background-color: #5442BC">Thêm vào
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{--end-header-upload--}}
                        <div class="d-md-flex">
                            <div class="col-md-3 px-2">
                                <div class="col-md-12 border-right mt-md-0 mt-3">
                                </div>
                                <div class="content__upload--file--contract border-right col-md-12 pl-0">
                                    <ul class="list-unstyled mb-0 pb-md-4 pb-3s list__file--parent">
                                        @if($folderParent->children->count() > 0)
                                            @foreach($folderParent->children as $parent)
                                                <li class="text-md-center text-lg-left align-self-lg-start d-flex py-4 flex-md-column align-items-md-center flex-lg-row border-bottom content__upload--file--item">
                                                    <input type="hidden"
                                                           data-uri="{{ route('web.contracts.contractFile',$parent->id) }}"
                                                           data-id="{{ $parent->id }}"
                                                           id="content__upload--file--id">
                                                    <div class="content__upload--file--icon">
                                                        <img height="33"
                                                             src="{{ asset('images/svg/group_folder.svg') }}">
                                                    </div>
                                                    <div class="content__upload--file--title pl-md-0 pl-3 pl-lg-3 text-lg-left pt-md-2 pt-lg-0">
                                                        <div class="content__upload--title--top">
                                                            {{ $parent->name }}
                                                        </div>
                                                        <span class="content__upload--title--kb">800 KB</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                        {{-- files--}}
                                        @if($folderParent->files->count() > 0)
                                            @foreach($folderParent->files as $file)
                                                <li class="align-items-md-center align-items-lg-start text-md-center text-lg-left d-flex py-4 border-bottom flex-lg-row flex-md-column overflow-hidden content__upload--file--item active__parent--files">
                                                    <div class="content__upload--file--icon">
                                                        <input type="hidden"
                                                               data-uri="{{ route('web.contracts.contractFile',$file->id) }}"
                                                               data-id="{{ $file->id }}"
                                                               id="content__upload--file--id">
                                                        <img height="33"
                                                             src="{{ get_extension_thumb($file->type) }}"
                                                             title="{{ $file->name }}">
                                                    </div>
                                                    <div class="pt-md-2 pt-lg-0 content__upload--file--title pl-3 pl-md-0 pl-lg-3 text-lg-left">
                                                        <div class="content__upload--title--top">

                                                            {{ $file->name }}

                                                        </div>
                                                        <span class="content__upload--title--kb">800 KB</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    {{-- files--}}
                                </div>
                            </div>
                            <div class="col-md-9 px-2">
                                <div class="content__upload--file-exp">
                                    <div class="">
                                        <div class="col-md-12 text-center d-md-block d-none mt-3 mb-4">
                                            Thông tin
                                        </div>
                                        <div class="header__upload--contract d-flex justify-content-center d-md-none mb-4 mt-1">
                                            <button
                                                    class="btn btn-primary rounded button__click--add--contract button-account-edit px-5 box-shadow-account"
                                                    data-dismiss="modal"
                                                    style="background-color: #5442BC">Thêm vào
                                            </button>
                                        </div>
                                        <div class="">
                                            <div class="col-md-12 px-0">
                                                <div class="content__upload--exp--info d-flex justify-content-between">
                                                    <div class="content__upload--exp--table">
                                                        Thông tin
                                                    </div>
                                                    <div class="content__upload--exp--table">
                                                        Tên file
                                                    </div>
                                                    <div class="content__upload--exp--table">
                                                        Kích thước
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--  end-header-table--}}
                                        <div class="">
                                            <div class="col-md-12 html_file px-0">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>

          $('.button-account-edit1').click(function () {
            // var a = $('.box__box--box').html();
            // $('.box--html--add').html(a);
            $('.box__box--box-update').append(
              `@include('dashboard.contract.form_sgin_update_users', ['isShowDeleteButton' => true])`
            );
            checkErrorSDT();
            checkEmailValidation();
          });

          $(document).ready(function () {
            $('#select_file').on('change', function () {
              let files = $('#select_file').prop('files');
              console.log(files);
              let names = $.map(files, function ( value ) {
                return value.name;
              });
              let size = $.map(files, function ( value ) {
                return value.size;
              });
              let type = $.map(files, function ( value ) {
                return value.name.split('.').pop();
              });
              let data = { names: names, size: size, type: type };
              $.ajax(
                {
                  url: "{{ route('web.contracts.listUploadFiles') }}",
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  },
                  data: data,
                  method: 'POST',
                  dataType: 'html',
                  success: function ( data ) {
                    if (data) {
                      $('.box__child--list--contract').append(data);
                    }
                  },
                }
              );
            });
          });
        </script>
        <script>
          $(document).ready(function () {
            let business_name = {!! json_encode(old('business_name')) !!};
            let status_signing = {!! json_encode(old('status_signing')) !!};
            let phone_contract = {!! json_encode(old('phone_contract')) !!};
            let email_contract = {!! json_encode(old('email_contract')) !!};
            let data = {
              business_name: business_name, status_signing: status_signing,
              phone_contract: phone_contract, email_contract: email_contract
            };
            $.ajax(
              {
                url: "{{ route('web.contracts.listReceivers') }}",
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: data,
                method: 'POST',
                dataType: 'html',
                success: function ( data ) {
                  if (data) {
                    $('.box__box--box').html(data);
                  }
                },
              }
            );

          });
        </script>
        {{--submit_save_contract_file--error--}}
        <script>
          $(document).ready(function () {
            let val = {!! json_encode(old('id_contract') ?? null) !!}
              let;
            data = { val: val };
            $.ajax(
              {
                url: "{{ route('web.contracts.show') }}",
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: data,
                method: 'POST',
                dataType: 'html',
                success: function ( data ) {
                  $('.box__child--list--contract').append(data);
                },
              }
            );
          });
        </script>
        {{--  active_class_folder  --}}
        <script>
          $(document).ready(function () {
            $('.button__click--add--contract').click(function () {
              let val = [];
              let fileIds = [];
              $(':checkbox:checked').each(function ( i ) {
                val[i] = $(this).val();
              });

              $('.file__contract--id').each(function ( i ) {
                fileIds[i] = $(this).val();
              });
              let data = { val: val, fileIds: fileIds };
              $.ajax(
                {
                  url: "{{ route('web.contracts.show') }}",
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  },
                  data: data,
                  method: 'POST',
                  dataType: 'html',
                  success: function ( data ) {
                    console.log(data);
                    $('.box__child--list--contract').append(data);
                  },
                }
              );
            });
          });
        </script>
        {{-- search_banking--}}
        <script>
          $(document).ready(function () {
            $('.blade__search--banking').css('display', 'none');
            $('#data__banking').keyup(function () {
              let keywork = $(this).val();
              let data = { keywork: keywork };
              if (keywork != '') {
                $('.blade__search--banking').css('display', 'block');
                $.ajax(
                  {
                    url: "{{ route('web.contracts.searchBanking') }}",
                    data: data,
                    headers: {
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: 'POST',
                    dataType: 'html',
                    success: function ( data ) {
                      $('.blade__search--banking').html(data);
                    },
                  }
                );
              } else {
                $('.blade__search--banking').css('display', 'none');
              }
            });
          });
        </script>
        {{--        add_cuost--}}
        <script>
          $(document).ready(function () {
            $('.button-account-edit1').click(function () {
              // var a = $('.box__box--box').html();
              // $('.box--html--add').html(a);
              $('.box__box--box').append('<div class="contract__box--face px-2 px-lg-0 d-md-flex d-flex-none"><div class="col-md-4 fl"><div class="form-group"><label class="font-weight-normal text-dark" for="exampleInputEmail1">Tên cá nhân, công ty, doanh nghiệp <span class="text-danger">*</span></label><input type="text" name="business_name[]" class="form-control p-2 rounded-0" id="exampleInputEmail1"aria-describedby="emailHelp"></div></div><div class="col-md-8"><div class="row box__input--contract"><div class="col-md-4 col-12"><div class="input-group d-md-flex justify-content-md-center d-flex-none"><div class="form-outline position-relative w-100"><label class="form-label font-weight-normal text-dark" for="form1">Trình tự kí<span class="text-danger mb-1">*</span></label><i class="fas fa-chevron-down position-absolute contract__list--icon--down"></i><select name="status_signing[]"class="form-control rounded-0 p-2 w-100 contract__list--select--wh"id="exampleFormControlSelect1"><option value="0">1</option><option value="1">2</option><option value="2">3</option><option value="3">4</option><option value="4">5</option></select></div></div></div><div class="col-md-4 col-12 mt-md-0 mt-3"><div class="input-group d-md-flex justify-content-center d-flex-none"><div class="form-outline w-100"><label class="form-label font-weight-normal text-dark" for="form1">Số điện thoại<span class="text-danger">*</span></label> <input name="phone_contract[]" type="search" id="form1" class="form-control rounded-0 p-2"placeholder=" "/></div></div></div><div class="col-md-4 col-12 mt-md-0 mt-3"><div class="input-group d-md-flex justify-content-center d-flex-none"><div class="form-outline w-100"><label class="form-label font-weight-normal text-dark" for="form1">Địa chỉ email <span class="text-danger">*</span></label><input name="email_contract[]" type="search" id="form1" class="form-control rounded-0 p-2"placeholder=""/></div></div></div></div></div></div><div class="box--html--add"></div>');

            });
          });
        </script>
        {{--search-ajax--}}
        <script>
          $(document).ready(function () {
            let select = document.querySelector('.onchange__search');
            select.oninput = function ( e ) {
              let search = e.target.value;
              data = { search: search };
              $.ajax(
                {
                  url: "{{ route('web.contracts.searchAjax') }}",
                  data: data,
                  method: 'GET',
                  dataType: 'html',
                  success: function ( data ) {
                    $('ul.list__file--parent').html(data);
                  },
                }
              );
            };
          });
        </script>
        {{--file_ajax--}}
        <script>
          $(document).ready(function () {
            $('li.content__upload--file--item').click(function () {
              $('li.content__upload--file--item').removeClass('content__exp--yes--active');
              $(this).addClass('content__exp--yes--active');
              let id = $(this).find('#content__upload--file--id').attr('data-id');
              let uri = $(this).find('#content__upload--file--id').attr('data-uri');
              data = { id: id };
              $.ajax(
                {
                  url: uri,
                  data: data,
                  method: 'GET',
                  dataType: 'html',
                  success: function ( data ) {
                    $('.html_file').html(data);
                  },
                }
              );
            });
          });
        </script>
        {{--api-cty--}}
        <script>
          $(document).ready(function () {
            $('#submitGetInfoCompany').on('click', function () {
              let uri = $('input#get_data').attr('data-uri');
              let taxCode = $('input#get_data').val();
              $.ajax(
                {
                  url: uri,
                  data: {
                    tax_code: taxCode
                  },
                  method: 'GET',
                  dataType: 'json',
                  success: function ( data ) {
                    console.log(data);
                    $('.name_manager').val(data.ceo_name);
                    $('.name_cty').val(data.company_name);
                    $('.name_email').val(data.email);
                    $('.addres_cty').val(data.address);
                  },
                }
              );
            });
          });
        </script>
        {{--upload-file--}}
        <script>
          $(document).ready(function () {
            $('li.content__upload--file--item:last-child').removeClass('border-bottom');
          });
        </script>

        <script>
          $(document).ready(function () {
            $('.remove__file--button').on('click', function () {
              // lay ten file muon xoa
              const containerFileView = $(this).closest('.modal__contract--list--contract');
              const fileName = containerFileView.find('.modal__contract--list-title').text();

              // lay FileList tu file input va convert sang array
              const fileInput = $('#select_file');
              let files = fileInput.prop('files');
              let fileArray = Array.from(files);
              // xoa file trong FileList neu file do trung ten vs file muon xoa
              fileArray.map(( item, index ) => {
                if (item.name === fileName) {
                  fileArray.splice(index, 1);
                }
              });

              // set cac file con lai vao filename
              const dt = new DataTransfer();

              fileArray.map(fileItem => {
                dt.items.add(fileItem);

              });
              fileInput.prop('files', dt.files);

              // xoa view chua file do di
              containerFileView.remove();
            });
          });
        </script>

@endsection
