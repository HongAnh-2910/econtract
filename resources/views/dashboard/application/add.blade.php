@extends('layouts.dashboard', ['key' => 'dashboard_application', 'menu_type' => 'menu_sidebars', 'isShowError' =>
false])
@section('extra_cdn')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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

    <form method="POST" action="{{ route('web.applications.store') }}" class="needs-validation" enctype="multipart/form-data"
          novalidate>
        @csrf
        <div class="container-fluid">
            <div class="row px-3">
                <div class="col-lg-8 col-12 mt-5 px-0">
                    <div class="row">
                        <div class="col-10 col-md-5">
                            <label class="mr-5 mb-2">Lý do<span class="text-danger">*</span></label>
                            {{-- <input name="reason" class="form-control" type="text" placeholder="Chọn lý do..." required> --}}
                            <div class="box__select--application">
                                <select name="reason" class="form-control select2 w-100"
                                        style="width: 100% !important;">
                                    <option data-foo="Tối đa: 30 Ngày/ Năm" value="Nghỉ ốm">Nghỉ ốm</option>
                                    <option data-foo="Tối đa: 180 Ngày/ Năm" value="Nghỉ thai sản">Nghỉ thai sản
                                    </option>
                                    <option data-foo="Tối đa: 20 Ngày/ Năm" value="Nghỉ không lương">Nghỉ không lương
                                    </option>
                                    <option data-foo="  " value="Nghỉ phép năm">Nghỉ phép năm</option>
                                    <option data-foo="Tối đa: 3 Ngày/ Năm" value="Nghỉ khác">Nghỉ khác</option>
                                    <option data-foo="Tối đa: 20 Ngày/ Năm" value="Nghỉ con ốm">Nghỉ con ốm</option>
                                    <option data-foo="Tối đa: 10 Ngày/ Năm" value="Nghỉ dưỡng sức sau ốm đau">Nghỉ dưỡng
                                        sức
                                        sau ốm đau
                                    </option>
                                    <option data-foo="Tối đa: 7 Ngày/ Năm" value="Nghỉ hội nghị, học tập">Nghỉ hội nghị,
                                        học
                                        tập
                                    </option>
                                    <option data-foo="Tối đa: 30 Ngày/ Năm" value="Nghỉ dưỡng sức sau thai sản">Nghỉ
                                        dưỡng
                                        sức sau thai sản
                                    </option>
                                    <option data-foo="Tối đa: 7 Ngày/ Năm"
                                            value="Nghỉ dưỡng sau điều trị thương tật, tai nạn">Nghỉ dưỡng sau điều trị
                                        thương
                                        tật, tai nạn
                                    </option>
                                    <option data-foo="Đơn vị tính theo giờ" value="Nghỉ bù">Nghỉ bù</option>
                                    <option data-foo="Tối đa: 30 Ngày/ Năm" value="Nghỉ tai nạn">Nghỉ tai nạn</option>
                                    <option data-foo="Tối đa: 3 Ngày/ Năm" value="Nghỉ hiếu hỷ">Nghỉ hiếu hỷ</option>
                                    <option data-foo="Tối đa: 3 Ngày/ Năm" value="Gặp khách hàng    ">Gặp khách hàng
                                    </option>
                                </select>
                            </div>
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
                        <input name="application_type" value="Đơn xin nghỉ" hidden>
                        <input name="status" value="Chờ duyệt" hidden>
                        <input name="position" value="develop" hidden>
                        <div class="col-4 col-md-3">
                            <label class="my-2 mb-md-2 mt-md-0">Tính công</label>
                            <input class="form-control" value="Không" disabled>
                        </div>
                    </div>
                    <div class="row mt-4 form-data-default">
                        <div class="col-5 col-xl-2">
                            <label class="mb-2">Ca<span class="text-danger">*</span></label>
                            <select class="form-select" name="information_day_1[]" required>
                                <option class="application__selectOption--disabled" value="" disabled="disabled"
                                        selected="selected">Chọn ca
                                </option>
                                <option value="Ca sáng">Ca sáng</option>
                                <option value="Ca chiều">Ca chiều</option>
                            </select>
                        </div>
                        <div class="col-5 col-xl-3 px-0">
                            <label class="mb-2">Từ ngày<span class="text-danger">*</span></label>
                            <?php
                            date_default_timezone_set('Asia/Kolkata');
                            ?>
                            <input class="form-control" type="date" name="information_day_2[]"
                                   value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-5 col-xl-2 mt-3 mt-xl-0">
                            <label class="mb-2">Ca<span class="text-danger">*</span></label>
                            <select class="form-select" name="information_day_3[]" required>
                                <option class="application__selectOption--disabled" value="" disabled="disabled"
                                        selected="selected">Chọn ca
                                </option>
                                <option value="Ca sáng">Ca sáng</option>
                                <option value="Ca chiều">Ca chiều</option>
                            </select>
                        </div>
                        <div class="col-5 col-xl-3 mt-3 mt-xl-0 px-0">
                            <label class="mb-2">Đến ngày<span class="text-danger">*</span></label>
                            <input class="form-control" type="date" name="information_day_4[]"
                                   value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <i class="fas fa-times delete__data--button mt-0 mt-xl-4" style="width:35px; height:40px;"></i>
                    </div>

                    <div class="show__more--data"></div>


                    <div class="col-12 mt-3 px-0">
                        <button
                            class="btn btn-outline-primary d-flex justify-content-center align-items-center rounded-circle application__addFile--button add__file--button">
                            <i class="fas fa-plus"></i></button>
                        <script>
                            $(document).ready(function () {
                                var x = 1;
                                $(".add__file--button").click(function (e) {
                                    e.preventDefault();
                                    x++;
                                    $(".show__more--data").append(
                                        `@include('dashboard.application.dataAjaxTemplateForApplication')`)
                                });

                                $(".show__more--data").on("click", ".delete__data--button", function (e) {
                                    e.preventDefault();
                                    $(this).parent().remove();
                                    x--;
                                });

                                $(".form-data-default").on("click", ".delete__data--button", function (e) {
                                    e.preventDefault();
                                    $(this).parent().remove();
                                })


                            })
                        </script>
                    </div>
                    <div class="col-12 col-md-10 mt-4 px-0">
                        <label class="mb-2">Mô tả<span class="text-danger">*</span></label>
                        <textarea class="ckeditor" required name="description"></textarea>
                        <script type="text/javascript">
                            var editor = new CKEDITOR.replace('description', {
                                language: 'vi',
                                filebrowserImageBrowseUrl: {{asset('vendor/editor/ckfinder/ckfinder.html?Type=Images')}},
                                filebrowserFlashBrowseUrl: {{asset('vendor/editor/ckfinder/ckfinder.html?Type=Flash')}},
                                filebrowserImageUploadUrl: {{asset('vendor/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images')}},
                                filebrowserFlashUploadUrl: {{asset('vendor/editor/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash')}},
                            });
                            CKEDITOR.editorConfig = function (config) {
                                enterMode: CKEDITOR.ENTER_BR;
                            };
                        </script>
                    </div>

                    <!----------------------  Upload file basic  -------------------->
                    <div class="col-12 col-md-10 mt-4 px-0 application__file--customize">
                        <div class="application__file--inputFile">
                            <label for="select_file" class="mb-3">
                                <div class="btn rounded ml-2 py-2 mb-md-0 " data-bs-target="#uploadFileModal"
                                     data-dismiss="modal">Đính kèm
                                </div>
                            </label>
                            <input type="file" name="files[]" id="select_file" multiple hidden>

                            {{-- <label for="file-1">Đính kèm</label>
                            <input class="input__file--none" name="file-1" id="file-1" type="file"
                                onchange="loadFile(event)"> --}}

                            {{-- <div class="file-item hide-btn">
                                <p><img id="output" width="50" /></p>
                                <p><img id="output1" width="50" /></p>
                                <span class="file-name"></span>
                                <span class="btn btn-del-file">x</span>
                            </div> --}}

                        </div>
                    </div>

                {{-- <script>
                    var loadFile = function(event) {
                        var image = document.getElementById('output');
                        image.src = URL.createObjectURL(event.target.files[0]);
                    };

                    $(function() {
                        var countFiles = 1,
                            $body = $('body'),
                            typeFileArea = ['txt', 'doc', 'docx', 'ods', 'png'],
                            coutnTypeFiles = typeFileArea.length;

                        //create new element
                        $body.on('click', '.application__file--customize label', function() {
                            var wrapFiles = $('.application__file--customize'),
                                newFileInput;

                            countFiles = wrapFiles.data('count-files') + 1;
                            wrapFiles.data('count-files', countFiles);

                            newFileInput = '<div class="application__file--inputFile"><label for="file-' + countFiles +
                                '">Đính kèm</label>' +
                                '<input class="input__file--none" type="file" onchange="loadFile1(event)" name="file-' +
                                countFiles +
                                '" id="file-' +
                                countFiles +
                                '"><div class="file-item hide-btn">' +
                                '<span class="file-name"></span><span class="btn btn-del-file">x</span></div></div>';
                            wrapFiles.prepend(newFileInput);
                        });



                        //show text file and check type file
                        $body.on('change', 'input[type="file"]', function() {
                            var $this = $(this),
                                valText = $this.val(),
                                fileName = valText.split(/(\\|\/)/g).pop(),
                                fileItem = $this.siblings('.file-item'),
                                beginSlice = fileName.lastIndexOf('.') + 1,
                                typeFile = fileName.slice(beginSlice);

                            fileItem.find('.file-name').text(fileName);
                            if (valText != '') {
                                fileItem.removeClass('hide-btn');

                                for (var i = 0; i < coutnTypeFiles; i++) {

                                    if (typeFile == typeFileArea[i]) {
                                        $this.parent().addClass('has-mach');
                                    }
                                }
                            } else {
                                fileItem.addClass('hide-btn');
                            }

                            if (!$this.parent().hasClass('has-mach')) {
                                $this.parent().addClass('error');
                            }
                        });

                        //remove file
                        $body.on('click', '.btn-del-file', function() {
                            var elem = $(this).closest('.application__file--inputFile');
                            elem.fadeOut(400);
                            setTimeout(function() {
                                elem.remove();
                            }, 400);
                        });
                    });

                    var loadFile1 = function(event) {
                        var image = document.getElementById('output1');
                        console.log('ok');
                        image.src = URL.createObjectURL(event.target.files[0]);
                    };
                </script> --}}



                <!----------------------------------     Example        -------------------------------->
                    {{-- <label for="select_file" class="mb-5">
                        <div class="btn btn-primary rounded button-account-edit ml-2 py-2 px-5 box-shadow-account mb-md-0 mb-3"
                            data-bs-target="#uploadFileModal" data-dismiss="modal" style="background-color: #5442BC">Tải hợp
                            đồng
                        </div>
                    </label>
                    <input type="file" name="files[]" id="select_file" multiple hidden> --}}

                    <div class="box__child--list--contract pb-4">
                    </div>

                    <div class="col-12 pb-5 px-0">
                        <div class="row">
                            <div class="col-12 col-md-4 d-flex align-items-center">
                                <label class="mb-0">Người kiểm duyệt<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-11 col-md-6 mt-3 mt-md-0 box__check-application">
                                @if (empty($users))
                                    <input class="form-control" placeholder="Chưa có thành viên" disabled>
                                @else
                                    <select class="form-control onChangeUser" name="user_id" required>
                                        <option selected disabled hidden>Chọn người kiểm duyệt</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
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
                    <div class="col-12 pb-5 px-0">
                        <div class="row">
                            <div class="col-12 col-md-4 d-flex align-items-center">
                                <label class="mb-0">Người theo dõi<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-11 col-md-6 mt-3 mt-md-0 box__html-applicationWord">
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
             style="background: #f7f8f9; box-shadow: 0px 0px 2px #ccc; bottom: 0; z-index: 3">
            <div class="col-12 mt-2 mx-0 form-group application__for--thought">
                <button type="submit" class="btn btn-primary mr-3 my-2">Cập nhật</button>
                <button onclick="window.location.href='{{ url()->previous() }}'" type="button"
                        class="btn btn-outline-primary">Thoát
                </button>
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
                placeholder: "Chọn người xem xét",
                allowClear: true,
            });
        });
    </script>

    <script>
        $(document).ready(function () {
           $('.onChangeUser').on('change' , function (){
              const value_id = $(this).val();
              const data = {value_id:value_id}
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
            $('.onChangeUserCheck').on('change' , function (){
                const value_id = $(this).val();
                const data = {value_id:value_id}
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
