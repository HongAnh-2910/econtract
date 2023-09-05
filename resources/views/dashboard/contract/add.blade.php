@extends('layouts.dashboard' ,['type' => 'dashboard_contract', 'menu_type' => 'menu_sidebars' ])

@section('extra_cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid pt-2 custom__container--fluid bg-white">
        <div class="container__bg--full" style="background-color: #E3E3E3">
            <!-- Form -->
            <form class="needs-validation" id="addContractForm" method="POST" action="{{ route('web.contracts.store') }}"
                  enctype="multipart/form-data" novalidate>
                @csrf
                <div class="contianer__bg--white bg-white pl-0">
                    <div class="create__contract--title">
                        <div class="">
                            <div class=" text-center">
                                <span class="create__contract--style">TẠO HỢP ĐỒNG KÝ DUYỆT</span>
                            </div>
                        </div>
                    </div>
                    {{-- end-title-header --}}
                    <div class="create__contract--form pl-md-3 pl-2 pr-md-3 pr-2 pl-lg-2 row">
                        <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                            <label class="text-dark pl-2 pt-2 mb-1">Số
                                hóa
                                đơn</label>
                            <div class="px-0">
                                <input name="species_contract" type="text" class="form-control p-2" value="20" disabled>
                            </div>
                        </div>
                        <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1">
                            <div class="px-0">
                                <div class="">
                                    <div class=" px-0">
                                        <div class="form-group">
                                            <label class="text-dark pt-2 pl-2 mb-1">Ngày
                                                hợp đồng</label>
                                            <div class="px-0 create__contract--form--exit">
                                                @error('date_contract')
                                                <div class="text text-danger">{{ $message }}</div>
                                                @enderror
                                                <input type="date" name="date_contract"
                                                       value="{{ old('date_contract') ? old('date_contract') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                       class="form-control p-2" placeholder="17/06/2020">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Loại hợp đồng -->
                        <input type="hidden" name="type" value="{{ $type }}" />
                        {{-- ms-thue --}}

                        <div
                                class="form-group col-sm-12 pl-0 pr-0 pr-sm-1 pl-sm-1 pr-md-1 pl-md-1 {{ isset($type) && $type == 'personal' ? 'd-none' : '' }}">
                            <label class="text-dark pl-2 mb-1 pt-2">Mã
                                số
                                thuế</label>
                            <div class="px-0 position-relative">
                                <div class="form-group mr-0">
                                    <input data-uri="{{ route('web.contracts.getData') }}" type="text" name="code_contract_stt"
                                           value="{{ old('code_contract_stt') }}" class="form-control p-2" id="get_data"
                                           placeholder="Mã số thuế">
                                </div>
                                <div id="submitGetInfoCompany"
                                     class="create__contract--form--btn create__contract--form--abs1 d-inline-block text-white btn__get--information position-absolute">
                                    Lấy thông tin
                                </div>
                            </div>
                        </div>
                        {{-- customer --}}

                        <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                            <label class="text-dark pl-2 mb-1 pt-2">Tên
                                khách
                                hàng</label>
                            <div class="px-0 name_manager--list">
                                <input type="text" value="{{ old('name_manager') }}" class="form-control p-2 name_manager"
                                       name="name_manager" placeholder="Tên khách hàng" id="data__customer" required>
                                <div class="icon__row--banking position-absolute" style="bottom: 20px;right: 15px;">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="invalid-feedback pl-0">
                                    Tên khách hàng không được để trống
                                </div>
                                @include('dashboard.contract.search_customer')
                            </div>
                        </div>
                        <div class="form-group col-sm-6 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1">
                            <div class="px-0">
                                <div class="">
                                    <div class=" px-0">
                                        <div class="form-group">
                                            <label for="data" class="text-dark pl-2 mb-1 pt-2">Email</label>
                                            <div class="px-0 create__contract--form--exit creator__email--contract">
                                                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email"
                                                       value="{{ old('name_email') }}"
                                                       class="form-control p-2 name_email creator__email--check" name="name_email"
                                                       placeholder="Email" required>
                                                <div class="invalid-feedback pl-0">
                                                    Email không được để trống
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- name_cty --}}

                        <div class="form-group col-sm-12 px-0 px-sm-1 px-md-1 {{ isset($type) && $type == 'personal' ? 'd-none' : '' }}">
                            <label class="text-dark pl-2 mb-1 pl-0 pt-2">Tên
                                công
                                ty</label>
                            <div class="position-relative px-0">
                                <div class="form-group mr-0">
                                    <input type="text" class="form-control p-2 name_cty" value="{{ old('name_cty') }}" name="name_cty"
                                           placeholder="Tên công ty" />
                                    <div class="invalid-feedback px-0">
                                        Tên công ty không được để trống
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- dia chi --}}

                        <div class="form-group col-sm-12 px-0 px-sm-1 px-md-1">
                            <label for="exampleInputEmail1" class="text-dark pl-2 mb-1 pt-2">Địa
                                chỉ<span class="text-danger pl-1">*</span></label>
                            <div class="position-relative px-0">
                                <div class="form-group mr-0">
                                    <input type="text" class="form-control p-2 addres_cty" value="{{ old('addres_cty') }}"
                                           name="addres_cty" placeholder="Địa chỉ" required>
                                    <div class="invalid-feedback px-0">
                                        Địa chỉ không được để trống
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- stk --}}

                        <div class="form-group col-sm-4 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                            <label class="text-dark pl-2 mb-1 pt-2">Số
                                tài
                                khoản</label>
                            <div class="px-0">
                                <input type="text" name="stk_contract" value="{{ old('stk_contract') }}"
                                       class="form-control p-2 stk_contract" placeholder="Số tài khoản">
                                <div class="invalid-feedback pl-0">
                                    Số tài khoản không được để trống
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-2 pr-md-1">
                            <div class="px-0">
                                <div class="">
                                    <div class=" px-0">
                                        <div class="form-group ">
                                            <label for="data" class=" text-dark mb-1 pl-2 pt-2">Tại ngân
                                                hàng</label>
                                            <div class="px-0 show__list--banking--click create__contract--form--exit position-relative">
                                                <input autocomplete="off" type="text" value="{{ old('search') }}" class="form-control p-2"
                                                       name="search" id="data__banking">
                                                <div class="icon__row--banking position-absolute" style="bottom: 5px;right: 15px;">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="invalid-feedback pl-0">
                                                    Ngân hàng không được để trống
                                                </div>
                                                @include('dashboard.contract.search_banking')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- hinh-thuc --}}

                        <div class="form-group col-sm-4 pl-0 pr-0 pr-sm-1 pl-sm-1 pl-md-1 pr-md-2">
                            <label class=" text-dark mb-1 pl-2 pt-2">Hình thức thanh
                                toán</label>
                            <div class="px-0">
                                <div class="">
                                    <div class=" px-0 create__contract--form--exit
                position-relative">
                                        <select class="form-control p-2" name="payments" id="payments">
                                            <option value="1">Tiền mặt</option>
                                            <option value="2">Chuyển khoản</option>
                                        </select>
                                        <i class="fas fa-chevron-down text-secondary position-absolute create__contract--abs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="token_signFollow" value="{{ csrf_token() }}">
                {{-- list-contract-content --}}

                <div class="box__contract--list--end bg-white">
                    <div class="header__card--contacts">
                        <div class="col-md-12 modal__contract--bg--header py-2 pl-3">
                            <span class="text-dark pl-2 pl-md-3 d-inline-block py-1 pl-lg-2">DANH SÁCH HỢP ĐỒNG</span>
                        </div>
                    </div>
                    {{-- end-list-contract-header --}}
                    <div class=" bg-white content__card--contacts pl-2 pr-2 pl-md-3 pr-md-3 pl-lg-2">
                        <div class="col-md-12 px-0">
                            @error('files.*')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                            <div class="button__contract--list--upload mt-4">
                                <div class="btn btn-primary rounded btn__upload--contacts button-account-edit box-shadow-account"
                                     data-bs-target="#uploadFileModal" data-dismiss="modal">
                                    <label for="select_file" class="mb-0">Tải hợp đồng</label>
                                </div>
                                <input type="file" name="files[]" id="select_file" multiple hidden>
                                <div class="btn btn-primary rounded button-account-edit btn__upload--sample--contacts box-shadow-account"
                                     data-toggle="modal" data-target="#exampleModalLong">Tải hợp đồng mẫu
                                </div>
                                <div class="button__contract--list--support mt-4 mb-4">
                                    <span class="text-danger">*</span> Định dạng được hỗ trợ: .pdf
                                </div>
                            </div>
                            <div class="box__child--list--contract">
                            </div>
                        </div>
                    </div>

                    {{-- end-list-contract-header1 --}}

                    <div class="header__card--contacts">
                        <div class="col-md-12 modal__contract--bg--header py-2 pl-3">
                            <span class="text-dark pl-2 pl-md-3 d-inline-block py-1 pl-lg-2">DANH SÁCH NGƯỜI NHẬN</span>
                        </div>
                    </div>

                    {{-- end-title-customer-active --}}

                    <div class=" bg-white pt-3 pb-4">
                        <div class="box__box--box">
                            @include('dashboard.contract.form_signature_user', ['isShowDeleteButton' => false])
                            <div class="box--html--add"></div>
                        </div>
                        <div class="col-md-12 px-2 px-md-3 px-lg-2 mx-md-1 mx-lg-0">
                            <div class="btn btn-primary mx-lg-1 rounded button-account-edit py-2 box-shadow-account mb-3 button-account-edit1"
                                 data-dismiss="modal" style="background-color: #5442BC ; font-size: 15px">
                                <i class="fas fa-user-friends pr-1"></i>
                                Thêm người nhận
                            </div>
                            <div class="contract__list--alert mx-lg-1 mr-md-1">
                                <p style="font-size: 15px ">Khi email được chuyển đến tất cả người nhận và các tài liệu
                                    được
                                    ký, mỗi người sẽ nhận
                                    được một bản sao hoàn thành</p>
                            </div>
                        </div>
                    </div>

                    {{--list folow--}}
                    <div class="header__card--contacts">
                        <div class="col-md-12 modal__contract--bg--header py-2 pl-3">
                            <span class="text-dark pl-2 pl-md-3 d-inline-block py-1 pl-lg-2">DANH SÁCH NGƯỜI THEO DÕI</span>
                        </div>
                    </div>

                    {{--list_add_flow--}}
                    <div class=" bg-white pt-3 pb-4">
                        <div class="box__follow--signature">
                            @include('dashboard.contract.form_signature_flow', ['isShowDeleteButton' => false])
                            <div class="box--html--add"></div>
                        </div>
                        <div class="col-md-12 px-2 px-md-3 px-lg-2 mx-md-1 mx-lg-0">
                            <div class="btn btn-primary mx-lg-1 rounded button-account-edit py-2 box-shadow-account mb-3 button-account-flow"
                                 data-dismiss="modal" style="background-color: #5442BC ; font-size: 15px">
                                <i class="fas fa-user-friends pr-1"></i>
                                Thêm người theo dõi
                            </div>
                            <div class="contract__list--alert mx-lg-1 mr-md-1">
                                {{--                    <p style="font-size: 15px ">Khi email được chuyển đến tất cả người nhận và các tài liệu--}}
                                {{--                        được--}}
                                {{--                        ký, mỗi người sẽ nhận--}}
                                {{--                        được một bản sao hoàn thành</p>--}}
                            </div>
                            <div
                                    class="contract__list--button--status d-flex justify-content-md-end justify-content-center  pr-md-4 pr-0">
                                <a href="{{ $type == config('statuses.type_personal') ? route('web.contracts.index') : route('web.contracts.indexCompany') }}"
                                   class="btn__back--list btn rounded button-account-edit ml-md-2 box-shadow-account ml-0"
                                   data-dismiss="modal">Hủy bỏ
                                </a>
                                <button
                                        class="btn btn-primary btn__submit--contract rounded button-account-edit ml-3 box-shadow-account"
                                        data-dismiss="modal">Tiếp theo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Upload file modal -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable modal-lg"
             role="document">
            <form method="POST" action="{{ route('web.files.store') }}" class="modal-content" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="exampleModalCenterTitle">
                            Tải lên hợp dồng
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="dropzone mt-5 mx-2" id="file-dropzone"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
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
    {{-- modal --}}
    <div class="modal fade text-left w-100 pr-0" id="exampleModalLong" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel20" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal__sample--contacts" role="document">
            <div class="modal-content" style="border-radius: 25px;height: 538px">
                <div class="container-fluid container__upload--contacts" style="overflow-y: scroll">
                    <div class="">
                        <div class=" col-md-12 mt-4 px-0 px-md-2">
                            <div class="content__upload--search--contract d-md-flex justify-content-md-between">
                                <div class="px-2 px-md-0 py-md-2">
                                    <input autocomplete="off" name="search" type="text" class="form-control onchange__search"
                                           id="exampleInputPassword1" placeholder="Tìm kiếm">
                                </div>
                                <div class="header__upload--contract d-md-flex d-none py-md-2">
                                    <button
                                            class="btn btn-primary rounded button__click--add--contract button-account-edit px-5 box-shadow-account"
                                            data-dismiss="modal" style="background-color: #5442BC">Thêm vào
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- end-header-upload --}}
                        <div class="d-md-flex">
                            <div class="col-md-3 px-2">
                                <div class="col-md-12 border-right mt-md-0 mt-3">
                                </div>
                                <div class="content__upload--file--contract border-right col-md-12 pl-0">
                                    <ul class="list-unstyled mb-0 pb-md-4 pb-3s list__file--parent">
                                        @if ($folderParent->children->count() > 0)
                                            @foreach ($folderParent->children as $parent)
                                                <li
                                                        class="text-md-center text-lg-left align-self-lg-start d-flex py-4 flex-md-column align-items-md-center flex-lg-row border-bottom content__upload--file--item">
                                                    <input type="hidden" data-uri="{{ route('web.contracts.contractFile', $parent->id) }}"
                                                           data-id="{{ $parent->id }}" id="content__upload--file--id">
                                                    <div class="content__upload--file--icon">
                                                        <img height="33" src="{{ asset('images/svg/group_folder.svg') }}">
                                                    </div>
                                                    <div
                                                            class="content__upload--file--title pl-md-0 pl-3 pl-lg-3 text-lg-left pt-md-2 pt-lg-0">
                                                        <div class="content__upload--title--top">
                                                            {{ $parent->name }}
                                                        </div>
                                                        <span class="content__upload--title--kb">800 KB</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                        {{-- files --}}
                                        @if ($folderParent->files->count() > 0)
                                            @foreach ($folderParent->files as $file)
                                                <li
                                                        class="align-items-md-center align-items-lg-start text-md-center text-lg-left d-flex py-4 border-bottom flex-lg-row flex-md-column overflow-hidden content__upload--file--item active__parent--files">
                                                    <div class="content__upload--file--icon">
                                                        <input type="hidden"
                                                               data-uri="{{ route('web.contracts.contractFile', $file->id) }}"
                                                               data-id="{{ $file->id }}" id="content__upload--file--id">
                                                        <img height="33"
                                                             src="{{ get_extension_thumb($file->type) }}"
                                                             title="{{ $file->name }}">
                                                    </div>
                                                    <div
                                                            class="pt-md-2 pt-lg-0 content__upload--file--title pl-3 pl-md-0 pl-lg-3 text-lg-left">
                                                        <div class="content__upload--title--top">

                                                            {{ $file->name }}

                                                        </div>
                                                        <span class="content__upload--title--kb">800 KB</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    {{-- files --}}
                                </div>
                            </div>
                            <div class="col-md-9 px-2">
                                <div class="content__upload--file-exp">
                                    <div class="">
                                        <div class=" col-md-12 text-center
                                    d-md-block d-none mt-3 mb-4">
                                            Thông tin
                                        </div>
                                        <div class="header__upload--contract d-flex justify-content-center d-md-none mb-4 mt-1">
                                            <button
                                                    class="btn btn-primary rounded button__click--add--contract button-account-edit px-5 box-shadow-account"
                                                    data-dismiss="modal" style="background-color: #5442BC">Thêm vào
                                            </button>
                                        </div>
                                        <div class="">
                                            <div class=" col-md-12 px-0">
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
                                        {{-- end-header-table --}}
                                        <div class="">
                                            <div class=" col-md-12 html_file
                                px-0">

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
        <style>
          .active__d--block {
            display: block;
          }

          .active__d--none {
            display: none;
          }

        </style>
        <script>
          $(document).ready(function () {
            $('.blade__search--banking').css('display', 'none');
            $('.show__list--banking--click').click(function () {
              $('.blade__search--banking').css('display', 'block');
              $.ajax({
                url: "{{ route('web.contracts.getBanking') }}",
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'GET',
                dataType: 'html',
                success: function ( data ) {
                  $('.blade__search--banking').html(data);
                },
              });
            });
          });
        </script>
        <script>
          $(document).ready(function () {
            var type_customer = {!! json_encode($type) !!};
            $('.blade__search--customer').css('display', 'none');
            $('.name_manager--list').click(function () {
              $('.blade__search--customer').css('display', 'block');
              $.ajax({
                url: "{{ route('web.contracts.getCustomer') }}",
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                method: 'POST',
                data: {
                  'type': type_customer
                },
                dataType: 'html',
                success: function ( data ) {
                  $('.blade__search--customer').html(data);
                },
              });
            });
          });
        </script>
        {{-- validate --}}
        <script>
          (function () {
            'use strict';
            window.addEventListener('load', function () {
              // Fetch all the forms we want to apply custom Bootstrap validation styles to
              var forms = document.getElementsByClassName('needs-validation');
              // Loop over them and prevent submission
              var validation = Array.prototype.filter.call(forms, function ( form ) {
                form.addEventListener('submit', function ( event ) {
                  if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();

                    $('.phone__number--check').each(function () {
                      var filter = '/^[0-9-+]+$/';
                      if ($(this).val() && ($(this).val().length !== 10 || !$(
                        this).val().match(filter))) {
                        $(this).closest('.show__invalid--message').find(
                          '.invalid-feedback').text(
                          'Số điện thoại không đúng');
                      } else if (!$(this).val()) {
                        $(this).closest('.show__invalid--message').find(
                          '.invalid-feedback').text(
                          'Số điện thoại không được để trống');
                      }
                    });

                    $('.creator__email--check').each(function () {
                      if ($(this).val()) {
                        $(this).closest('.creator__email--contract').find(
                          '.invalid-feedback').text(
                          'Email không đúng định dạng');
                      } else {
                        $(this).closest('.creator__email--contract').find(
                          '.invalid-feedback').text(
                          'Email không được để trống');
                      }
                    });
                  }
                  form.classList.add('was-validated');
                }, false);
              });
            }, false);
          })();
        </script>
        <script>
          $(document).ready(function () {
            $('.creator__email--check').on('change', function () {
              if ($(this).val()) {
                $(this).closest('.creator__email--contract').find('.invalid-feedback').text(
                  'Email không đúng định dạng');
              } else {
                $(this).closest('.creator__email--contract').find('.invalid-feedback').text(
                  'Email không được để trống');
              }
            });

            $('#select_file').on('change', function () {
              let files = $('#select_file').prop('files');
              let names = $.map(files, function ( value ) {
                return value.name;
              });
              let size = $.map(files, function ( value ) {
                return value.size;
              });
              let type = $.map(files, function ( value ) {
                return value.name.split('.').pop();
              });
              let data = {
                names: names,
                size: size,
                type: type
              };
              $.ajax({
                url: "{{ route('web.contracts.listUploadFiles') }}",
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: data,
                method: 'POST',
                dataType: 'html',
                success: function ( data ) {
                  if (data) {
                    $('.box__child--list--contract').html(data);
                  }
                },
              });
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
              business_name: business_name,
              status_signing: status_signing,
              phone_contract: phone_contract,
              email_contract: email_contract
            };
            $.ajax({
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
            });

          });
        </script>
        <script>
          $(document).ready(function () {
            $('body').delegate('.dashboard__remove--button', 'click', function () {
              $(this).closest('.contract__box--face').remove();
            });
          });
        </script>
        {{-- submit_save_contract_file--error --}}
        <script>
          $(document).ready(function () {
            let val = {!! json_encode(old('id_contract') ?? null) !!};
            let data = {
              val: val
            };
            $.ajax({
              url: "{{ route('web.contracts.show') }}",
              headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },
              data: data,
              method: 'POST',
              dataType: 'html',
              success: function ( data ) {
                $('.box__child--list--contract').html(data);
              },
            });
          });
        </script>
        {{-- active_class_folder --}}
        <script>
          $(document).ready(function () {
            $('.button__click--add--contract').click(function () {
              let val = [];
              $(':checkbox:checked').each(function ( i ) {
                val[i] = $(this).val();
              });
              let data = {
                val: val
              };
              $.ajax({
                url: "{{ route('web.contracts.show') }}",
                headers: {
                  'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: data,
                method: 'POST',
                dataType: 'html',
                success: function ( data ) {
                  $('.box__child--list--contract').html(data);
                },
              });
            });
          });
        </script>
        {{-- search_banking --}}
        <script>
          $(document).ready(function () {
            const bankingSearchElemenet = $('.blade__search--banking');
            bankingSearchElemenet.css('display', 'none');
            $('#data__banking').keyup(function () {
              let keywork = $(this).val();
              let data = {
                keywork: keywork
              };
              if (keywork !== '') {
                bankingSearchElemenet.removeClass('d__none--search');
                bankingSearchElemenet.css('display', 'block');
                $.ajax({
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
                });
              } else {
                $('.blade__search--banking').css('display', 'none');
              }
            });
          });
        </script>

        <script>
          $(document).ready(function () {
            let type_customer = {!! json_encode($type) !!};
            let customerSearchElemenet = $('.blade__search--customer');
            customerSearchElemenet.css('display', 'none');
            $('#data__customer').keyup(function () {
              let key = $(this).val();
              let data = {
                key: key,
                type: type_customer
              };
              if (key !== '') {
                customerSearchElemenet.removeClass('d__none--search');
                customerSearchElemenet.css('display', 'block');
                $.ajax({
                  url: "{{ route('web.contracts.searchCustomer') }}",
                  data: data,
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  },
                  method: 'POST',
                  dataType: 'html',
                  success: function ( data ) {
                    $('.blade__search--customer').html(data);
                  },
                });
              } else {
                $('.blade__search--customer').css('display', 'none');
              }
            });
          });
        </script>
        {{-- add_cuost --}}
        <script>
          $(document).ready(function () {
            function checkErrorSDT() {
              $('.phone__number--check').on('change', function () {
                var filter = '/^[0-9-+]+$/';
                if ($(this).val() && ($(this).val().length !== 10 || !$(this).val().match(filter))) {
                  $(this).closest('.show__invalid--message').find('.invalid-feedback').text(
                    'Số điện thoại không đúng');
                } else if (!$(this).val()) {
                  $(this).closest('.show__invalid--message').find('.invalid-feedback').text(
                    'Số điện thoại không được để trống');
                }
              });
            }

            checkErrorSDT();

            function checkEmailValidation() {
              $('.receivers__email--contracts').on('change', function () {
                if ($(this).val()) {
                  $(this).closest('.show__invalid--message').find('.invalid-feedback').text(
                    'Email không đúng định dạng');
                } else {
                  $(this).closest('.show__invalid--message').find('.invalid-feedback').text(
                    'Email không được để trống');
                }
              });
            }

            checkEmailValidation();

            $('.button-account-edit1').click(function () {
              // var a = $('.box__box--box').html();
              // $('.box--html--add').html(a);
              $('.box__box--box').append(
                `@include('dashboard.contract.form_signature_user', ['isShowDeleteButton' => true])`
              );
              checkErrorSDT();
              checkEmailValidation();
            });

            $('.button-account-flow').click(function () {
              // var a = $('.box__box--box').html();
              // $('.box--html--add').html(a);
              $('.box__follow--signature').append(
                `@include('dashboard.contract.form_signature_flow', ['isShowDeleteButton' => true])`
              );
              checkErrorSDT();
              checkEmailValidation();
            });
          });
        </script>
        {{-- search-ajax --}}
        <script>
          $(document).ready(function () {
            let select = document.querySelector('.onchange__search');
            select.oninput = function ( e ) {
              let search = e.target.value;
              data = {
                search: search
              };
              $.ajax({
                url: "{{ route('web.contracts.searchAjax') }}",
                data: data,
                method: 'GET',
                dataType: 'html',
                success: function ( data ) {
                  $('ul.list__file--parent').html(data);
                },
              });
            };
          });
        </script>
        {{-- file_ajax --}}
        <script>
          $(document).ready(function () {
            $('li.content__upload--file--item').click(function () {
              if (!$(this).hasClass('active__parent--files')) {
                $('li.content__upload--file--item').removeClass('content__exp--yes--active');
                $(this).addClass('content__exp--yes--active');
                let id_folder = $(this).find('#content__upload--file--id').attr('data-id');
                let uri = $(this).find('#content__upload--file--id').attr('data-uri');
                data = {
                  id_folder: id_folder
                };
                $.ajax({
                  url: uri,
                  data: data,
                  method: 'GET',
                  dataType: 'html',
                  success: function ( data ) {
                    $('.html_file').html(data);
                  },
                });
              } else {
                $('li.content__upload--file--item').removeClass('content__exp--yes--active');
                $(this).addClass('content__exp--yes--active');
                let id_files = $(this).find('#content__upload--file--id').attr('data-id');
                let uri = $(this).find('#content__upload--file--id').attr('data-uri');
                data = {
                  id_files: id_files
                };
                $.ajax({
                  url: uri,
                  data: data,
                  method: 'GET',
                  dataType: 'html',
                  success: function ( data ) {
                    $('.html_file').html(data);
                  },
                });
              }
            });
          });
        </script>
        <script>
          $(document).ready(function () {
            $('li.content__upload--file--item:last-child').removeClass('border-bottom');
          });
        </script>
        <script type="text/javascript">
          Dropzone.options.fileDropzone = {
            url: '{{ route('web.files.store') }}',
            maxFilesize: 5,
            maxFiles: 8,
            autoProcessQueue: false,
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            acceptedFiles: '.jpeg,.jpg,.png,.gif,.docx,.pdf,.doc',
            addRemoveLinks: true,
            timeout: 60000,
            uploadMultiple: true,
            init: function () {
              $('.button-account-edit1').click(function () {
                // var a = $('.box__box--box').html();
                // $('.box--html--add').html(a);
                $('.box__box--box').append(
                  `@include('dashboard.contract.form_signature_user', ['isShowDeleteButton' => true])`
                );
                checkErrorSDT();
                checkEmailValidation();
              });
            }
          };
        </script>
        {{-- search-ajax --}}
        <script>
          $(document).ready(function () {
            let select = document.querySelector('.onchange__search');
            select.oninput = function ( e ) {
              let search = e.target.value;
              data = {
                search: search
              };
              $.ajax({
                url: "{{ route('web.contracts.searchAjax') }}",
                data: data,
                method: 'GET',
                dataType: 'html',
                success: function ( data ) {
                  $('ul.list__file--parent').html(data);
                },
              });
            };
          });
        </script>
        {{-- file_ajax --}}
        <script>
          $(document).ready(function () {
            $('li.content__upload--file--item').click(function () {
              if (!$(this).hasClass('active__parent--files')) {
                $('li.content__upload--file--item').removeClass('content__exp--yes--active');
                $(this).addClass('content__exp--yes--active');
                let id_folder = $(this).find('#content__upload--file--id').attr('data-id');
                let uri = $(this).find('#content__upload--file--id').attr('data-uri');
                data = {
                  id_folder: id_folder
                };
                $.ajax({
                  url: uri,
                  data: data,
                  method: 'GET',
                  dataType: 'html',
                  success: function ( data ) {
                    $('.html_file').html(data);
                  },
                });
              } else {
                $('li.content__upload--file--item').removeClass('content__exp--yes--active');
                $(this).addClass('content__exp--yes--active');
                let id_files = $(this).find('#content__upload--file--id').attr('data-id');
                let uri = $(this).find('#content__upload--file--id').attr('data-uri');
                data = {
                  id_files: id_files
                };
                $.ajax({
                  url: uri,
                  data: data,
                  method: 'GET',
                  dataType: 'html',
                  success: function ( data ) {
                    $('.html_file').html(data);
                  },
                });
              }
            });
          });
        </script>
        {{-- api-cty --}}
        <script>
          $(document).ready(function () {
            $('#submitGetInfoCompany').on('click', function () {
              let uri = $('input#get_data').attr('data-uri');
              let taxCode = $('input#get_data').val();
              $.ajax({
                url: uri,
                data: {
                  tax_code: taxCode
                },
                method: 'GET',
                dataType: 'json',
                success: function ( data ) {
                  $('.name_manager').val(data.ceo_name);
                  $('.name_cty').val(data.company_name);
                  $('.name_email').val(data.email);
                  $('.addres_cty').val(data.address);
                },
              });
            });
          });
        </script>
        {{-- upload-file --}}
        <script>
          $(document).ready(function () {
            $('li.content__upload--file--item:last-child').removeClass('border-bottom');
          });
        </script>
        <script type="text/javascript">
          Dropzone.options.fileDropzone = {
            url: '{{ route('web.files.store') }}',
            maxFilesize: 5,
            maxFiles: 8,
            autoProcessQueue: false,
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            acceptedFiles: '.jpeg,.jpg,.png,.gif,.docx,.pdf,.doc',
            addRemoveLinks: true,
            timeout: 60000,
            uploadMultiple: true,
            init: function () {

              var myDropzone = this;
              // Update selector to match your button
              $('#uploadFileButton').click(function ( e ) {
                e.preventDefault();
                myDropzone.processQueue();
              });
            },
            removedfile: function ( file ) {},
            success: function ( file, response ) {
              if (response.message === 'success') {
                location.reload();
              }
            },
            error: function ( file, response ) {
              alert('Tải file không thành công. Vui lòng kiểm tra lại!');
            }
          };
        </script>
@endsection
