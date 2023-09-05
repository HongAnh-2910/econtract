@extends('layouts.dashboard', ['key' => 'dashboard_application', 'menu_type' => 'menu_sidebars', 'isShowError' =>
false])
@section('extra_cdn')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>

@endsection
@section('content')
    <style>
        .box__select--application {
            border: 1px solid #dce7f1;
            border-radius: 5px;
        }

        .box__select--application .select2-selection--single {
            height: 36px;
            border: none;
        }

        .box__select--application .select2-selection__rendered {
            height: 100%;
            display: flex !important;
            align-items: center;
        }

        .box__select--application .select2-selection__arrow {
            height: 100% !important;
            display: flex !important;
            align-items: center;
        }

        .box__select--application .select2-container {
            min-width: 100%;
            width: unset !important;
        }

    </style>

    <!--   Modal Validation   -->
    <div class="modal fade" id="overlay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông báo</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        @if (count($errors) > 0)
        $('#overlay').modal('show');
        @endif
    </script>

    <form method="POST" action="{{ route('web.applications.storeProposal') }}" enctype="multipart/form-data"
          class="needs-validation" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="row px-3">
                <div class="col-lg-8 col-12 mt-5 px-0">
                    <div class="row">
                        <div class="col-10 col-md-3">
                            <label class="mr-5 mb-2">Tên đề xuất<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-10 col-md-7">
                            <input name="proposal_name" class="form-control" type="text" placeholder="Tên đề xuất"
                                   required>
                        </div>
                        <div class="col-10 col-md-3 mt-3">
                            <label class="mr-5 mb-2">Loại đề xuất<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-10 col-md-7 mt-3">
                            <div class="box__select--application">
                                <select name="reason" class="form-control select2 w-100"
                                        style="width: 100% !important;">
                                    <option data-foo='Tên đề xuất "Tên thành viên - Phòng ban - BBBG + tên hàng/DV"'
                                            value="Bàn giao tài sản">Bàn giao tài sản
                                    </option>
                                    <option data-foo='Tên đề xuất "Tên thành viên - Phòng ban - Đề nghị mua + tên hàng"'
                                            value="Đề nghị mua hàng">Đề nghị mua hàng
                                    </option>
                                    <option
                                        data-foo='Tên đề xuất "Tên thành viên - Phòng ban - Đề nghị thanh toán + tên hàng/DV"'
                                        value="Đề nghị thanh toán">Đề nghị thanh toán
                                    </option>
                                    <option
                                        data-foo='Tên đề xuất "Tên thành viên - Phòng ban - thanh toán tạm ứng + ngày tạm ứng"'
                                        value="Đề nghị tạm ứng">Đề nghị tạm ứng
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-10 col-md-3 mt-3">
                            <label class="mr-5 mb-2">Người đề nghị<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-10 col-md-7 mt-3">
                            <input name="proponent" class="form-control" type="text" placeholder="Người đề nghị"
                                   required>
                        </div>
                        <div class="col-10 col-md-3 mt-3">
                            <label class="mr-5 mb-2">Số tiền<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-10 col-md-7 mt-3">
                            <input name="price_proposal" class="form-control price_proposal" type="number"
                                   placeholder="Số tiền" required>
                        </div>
                        <script>
                            $(function () {
                                $(".select2").select2({
                                    matcher: matchCustom,
                                    templateResult: formatCustom
                                });
                            })

                            function stringMatch(term, candidate) {
                                return candidate && candidate.toLowerCase().indexOf(term.toLowerCase()) >= 0;
                            }

                            function matchCustom(params, data) {
                                // If there are no search terms, return all of the data
                                if ($.trim(params.term) === '') {
                                    return data;
                                }
                                // Do not display the item if there is no 'text' property
                                if (typeof data.text === 'undefined') {
                                    return null;
                                }
                                // Match text of option
                                if (stringMatch(params.term, data.text)) {
                                    return data;
                                }
                                // Match attribute "data-foo" of option
                                if (stringMatch(params.term, $(data.element).attr('data-foo'))) {
                                    return data;
                                }
                                // Return `null` if the term should not be displayed
                                return null;
                            }

                            function formatCustom(state) {
                                return $(
                                    '<div><div>' + state.text + '</div><div class="text-secondary">' +
                                    $(state.element).attr('data-foo') +
                                    '</div></div>'
                                );
                            }
                        </script>
                        <!-----   Default Value  ---------->

                        <input name="application_type" value="Đơn đề nghị" hidden>
                        <input name="status" value="Chờ duyệt" hidden>

                        <input name="position" value="develop" hidden>

                        <div class="col-12 col-md-3 mt-4">
                            <label class="mb-2">Thông tin tài khoản<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 mt-4">
                            <textarea style="width:418px; height:150px" class="form-control" required
                                      name="account_information"
                                      placeholder="Số tài khoản - Ngân hàng (chi nhánh) - Chủ tài khoản (nếu người nhận tiền khác người đề xuất)"></textarea>
                        </div>

                        <div class="col-12 col-md-3 mt-4">
                            <label class="mb-2">Ngày cần hàng<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12 col-md-7 mt-3">
                            <div class="row mt-2 form-data-default">
                                <div class="col-10 col-xl-5">
                                    <select class="form-select" name="delivery_time" required>
                                        <option class="application__selectOption--disabled" value="" disabled="disabled"
                                                selected="selected">Chọn thời gian
                                        </option>
                                        <option value="Buổi sáng">Buổi sáng</option>
                                        <option value="Buổi chiều">Buổi chiều</option>
                                    </select>
                                </div>
                                <div class="col-10 col-xl-5 mt-2 mt-xl-0">
                                    <?php
                                    date_default_timezone_set('Asia/Kolkata');
                                    ?>
                                    <input class="form-control" type="date" name="delivery_date"
                                           value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                        <!----------------------  Upload file basic  -------------------->
                        <div class="col-12 col-md-3 mt-4">
                            <label>File đính kèm</label>
                        </div>

                        <div class="col-10 col-md-7 mt-4 application__file--customize">
                            <div class="application__file--inputFile">
                                <label for="select_file" class="mb-3">
                                    <div class="btn rounded ml-2 py-2 mb-md-0 " data-bs-target="#uploadFileModal"
                                         data-dismiss="modal">Đính kèm
                                    </div>
                                </label>
                                <input type="file" name="files[]" id="select_file" multiple hidden>
                            </div>
                        </div>

                        <div class="box__child--list--contract pb-4">
                        </div>

                        <div class="col-12 pb-5">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center">
                                    <label class="mb-0">Người kiểm duyệt<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-10 col-md-7 mt-3 mt-md-0 box__check-application">
                                    @if (empty($users))
                                        <input class="form-control" placeholder="Chưa có thành viên" disabled>
                                    @else
                                        <select class="form-control onChangeUser" name="user_id" required>
                                            <option selected disabled hidden>Chọn người kiểm duyệt</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                            @if(!empty($users[0]->parent->id))
                                                @if(\Illuminate\Support\Facades\Auth::id() != $users[0]->parent->id)
                                                    <option value="{{ $users[0]->parent->id }}">{{ $users[0]->parent->name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                    @endif
                                    @error('user_id')
                                    <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- customer_flow--}}
                        <div class="col-12 pb-5">
                            <div class="row">
                                <div class="col-12 col-md-3 d-flex align-items-center">
                                    <label class="mb-0">Người theo dõi<span class="text-danger">*</span></label>
                                </div>
                                <div class="col-10 col-md-7 mt-3 mt-md-0 box__html-applicationWord">
                                    <div class="form-group position-relative parent_department">
                                        <i style="position: absolute;top: 12px;right: 9px;z-index: 1;"
                                           class="fas fa-chevron-down down__active--hover"></i>
                                        <select
                                            class="department__select js-example-placeholder-multiple js-states form-control pl-2 onChangeUserCheck"
                                            name="user_consider[]" multiple="multiple">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                                @if(!empty($users[0]->parent->id))
                                                    @if(\Illuminate\Support\Facades\Auth::id() != $users[0]->parent->id)
                                                        <option value="{{ $users[0]->parent->id }}">{{ $users[0]->parent->name}}</option>
                                                    @endif
                                                @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--   Upload file    -->
                        <script>
                            $(document).ready(function () {
                                $('#select_file').on('change', function () {
                                    let files = $('#select_file').prop("files");
                                    console.log(files)
                                    let names = $.map(files, function (value) {
                                        return value.name
                                    })
                                    let size = $.map(files, function (value) {
                                        return value.size
                                    })
                                    let type = $.map(files, function (value) {
                                        return value.name.split('.').pop();
                                    })
                                    let data = {
                                        names: names,
                                        size: size,
                                        type: type
                                    }
                                    $.ajax({
                                        url: "{{ route('web.applications.listUploadFiles') }}",
                                        headers: {
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        data: data,
                                        method: 'POST',
                                        dataType: 'html',
                                        success: function (data) {
                                            if (data) {
                                                $('.box__child--list--contract').html(data)
                                            }
                                        },
                                    })
                                })
                            })
                        </script>


                    </div>
                </div>
            </div>

            <div class="footer__application--style w-100 position-fixed"
                 style="background: #f7f8f9; box-shadow: 0px 0px 2px #ccc; bottom: 0;">
                <div class="col-12 mt-2 mx-0 form-group application__for--thought">
                    <button type="submit" class="btn btn-primary mr-3 my-2">Cập nhật</button>
                    <button onclick="window.location.href='{{ url()->previous() }}'" type="button"
                            class="btn btn-outline-primary">Thoát
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <script type="text/javascript">
        // select perrmission user when upload file
        $(document).ready(function () {
            $('.department__select').select2({
                placeholder: "Chọn người kiểm duyệt",
                allowClear: true,
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.onChangeUser').on('change', function () {
                const value_id = $(this).val();
                const data = {value_id: value_id}
                $.ajax({
                    url: "{{ route('web.applications.changeUserWord') }}",
                    method: 'GET',
                    data: data,
                    dataType: 'html',
                    success: function (data) {
                        if (data) {
                            $('.box__html-applicationWord').html(data)
                        }
                    },
                })
            })
        })
    </script>


    <script>
        $(document).ready(function () {
            $('.onChangeUserCheck').on('change', function () {
                const value_id = $(this).val();
                const data = {value_id: value_id}
                $.ajax({
                    url: "{{ route('web.applications.changeUserWordCheck') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: 'POST',
                    data: data,
                    dataType: 'html',
                    success: function (data) {
                        if (data) {
                            $('.box__check-application').html(data)
                        }
                    },
                })
            })
        })
    </script>
@endsection
