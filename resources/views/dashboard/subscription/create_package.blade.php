<style>
        #form__subscription--option input.form-control.name_validate::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            opacity: 0.7;
        }

        #form__subscription--option input.form-control.name_validate:-ms-input-placeholder { /* Internet Explorer 10-11 */
            opacity: 0.7;
        }

        #form__subscription--option input.form-control.name_validate::-ms-input-placeholder { /* Microsoft Edge */
            opacity: 0.7;
        }
</style>
<div class="modal fade text-left" id="subscription__package" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="needs-validation" id="form__subscription--option" method="POST" action="{{ route('web.subscriptionStore') }}" novalidate>
                @method('POST')
                @csrf

                <div class="modal-body mt-2">
                    <h5 class="modal-title px-3 mb-2" id="staticBackdropLabel" style="color: #343434;">Thông tin đăng kí</h5>
                    <p class="px-2 mx-1 mb-2" style="color: #696767; font-size: 14px;">Điền thông tin của bản để hoàn tất đăng kí</p>
                    <div class="px-2 mx-1 popup__subscription--information pb-2 text-danger font-weight-bold"></div>
                    <input class="subscription__option--type" name="subscription_option" value="" type="hidden" />
                    <input class="input__subscription--name" name="subscription_option_name" value="" type="hidden" />

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Tên doanh nghiệp
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input placeholder="Nhập tên doanh nghiệp" type="text" name="business_name" value="{{ old('business_name') }}"
                                        class="subOpt__business--name form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Tên doanh nghiệp không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Tên viết tắt
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input placeholder="Nhập tên viết tắt" type="text" name="business_alias" value="{{ old('business_alias') }}"
                                        class="subOpt__business--alias form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Tên viết tắt không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Mã số thuế
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input placeholder="Nhập mã số thuế" type="text" name="tax_code" value="{{ old('tax_code') }}"
                                        class="subOpt__tax--code form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Mã số thuế không được để trống
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Thời hạn gói
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select subOpt__duration--package" name="duration_package" required>
                                        <option {{ ! in_array(old('duration_package'), [2, 3]) ? 'checked' : '' }} value="1">01 năm</option>
                                        <option {{old('duration_package') == 2 ? 'checked' : '' }} value="2">02 năm</option>
                                        <option {{old('duration_package') == 3 ? 'checked' : '' }} value="3">03 năm</option>
                                    </select>
                                    <div class="invalid-feedback pl-0">
                                        Bạn phải chọn thời hạn gói
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Họ
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input placeholder="Nhập họ của bạn" type="text" name="last_name" value="{{ old('last_name') }}"
                                        class="subOpt__last--name form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Họ không được để trống
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Tên và đệm
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input placeholder="Nhập tên và đệm" type="text" name="first_middle_name" value="{{ old('first_middle_name') }}"
                                        class="subOpt__first--middle form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Tên và đệm không được để trống
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group position-relative creator__email--subscription">
                                    <label class="ft-size-account text-dark">Email
                                        <span class="text-danger">*</span></label>
                                    <input placeholder="Nhập email của bạn" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
{{--                                           pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"--}}
                                        name="email" value="{{ old('email') }}"
                                        class="form-control email__check--info creator__email--customer name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Bạn nhập sai định dạng Email hoặc đang được để trống
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group show__invalid--message">
                                    <label class="ft-size-account text-dark">Điện thoại
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" placeholder="Nhập số điện thoại" type="text" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" name="phone_number"
                                        value="{{ old('phone_number') }}" class="form-control name_validate phone__number--customer" required>
                                    <div class="invalid-feedback pl-0">
                                        Số điện thoại không được để trống
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group customer__date--birthday">
                                    <label class="ft-size-account text-dark">Ngày sinh
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input min="1900-01-01" max="3000-01-01" pattern="\d{1,2}/\d{1,2}/\d{4}" type="date" name="birthday" value="{{ old('birthday') }}"
                                        class="form-control name_validate creator__date--birthday" required>
                                    <div class="invalid-feedback pl-0">
                                        Ngày sinh không được để trống
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Giới tính
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select subOpt__gender" name="gender" required>
                                        <option class="application__selectOption--disabled" value="" disabled="disabled"
                                            selected="selected">Chọn giới tính</option>
                                        <option {{ ! in_array(old('gender'), [0, 2]) ? 'checked' : '' }} value="1">Nam</option>
                                        <option {{! old('gender') ? 'checked' : '' }} value="0">Nữ</option>
                                        <option {{ old('gender') == 2 ? 'checked' : '' }} value="2">Khác</option>
                                    </select>
                                    <div class="invalid-feedback pl-0">
                                        Bạn phải chọn giới tính
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account text-dark">Địa chỉ
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input placeholder="Nhập địa chỉ" type="text" name="address"
                                        value="{{ old('address') }}" class="subOpt__address form-control name_validate"
                                        required>
                                    <div class="invalid-feedback pl-0">
                                        Địa chỉ không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input style="width: 20px; height: 20px;" id="check__is--agree" name="accept_term_condition" type="checkbox" required class="name_validate" />&nbsp;
                                    <label for="check__is--agree" class="text-dark font-weight-normal d-inline" style="color: #696767; !important;">Tôi đã đọc, hiểu và đồng ý với phương thức hợp đồng điện tử</label>
                                    <div class="invalid-feedback pl-0">Bạn phải đồng ý với điều khoản trên</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn__close--subscription" data-dismiss="modal">Quay lại</button>
                    <button type="submit" class="btn__register_subscription">Đăng ký</button>
                </div>
            </form>
        </div>
    </div>
</div>

 <script>
        $(document).ready(function() {
            function checkErrorSDTCustomer() {
                $('.phone__number--customer').on('change', function () {
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

            function checkErrorEmailCustomer() {
                $('.creator__email--customer').on('change', function() {
                    if ($(this).val()) {
                        $(this).closest('.creator__email--subscription').find('.invalid-feedback').text('Email không đúng định dạng');
                    } else {
                        $(this).closest('.creator__email--subscription').find('.invalid-feedback').text('Email không được để trống');
                    }
                });
            }

            function checkErrorBirthday() {
                $('.creator__date--birthday').on('change', function() {
                    if ($(this).val()) {
                        $(this).closest('.customer__date--birthday').find('.invalid-feedback').text('Ngày sinh không đúng');
                    } else {
                        $(this).closest('.customer__date--birthday').find('.invalid-feedback').text('Ngày sinh không được để trống');
                    }
                });
            }

            checkErrorBirthday();
            checkErrorSDTCustomer();
            checkErrorEmailCustomer();
        });
 </script>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();

                        $('.phone__number--customer').each(function() {
                            var filter = '/^[0-9-+]+$/';
                            if ($(this).val() && ($(this).val().length !== 10 || !$(
                                this).val().match(filter))) {
                                $(this).closest('.show__invalid--message').find('.invalid-feedback').text('Số điện thoại không đúng');
                            } else if (!$(this).val()) {
                                $(this).closest('.show__invalid--message').find('.invalid-feedback').text('Số điện thoại không được để trống');
                            }
                        });

                        $('.creator__email--customer').each(function() {
                            if ($(this).val()) {
                                $(this).closest('.creator__email--subscription').find('.invalid-feedback').text('Email không đúng định dạng');
                            } else {
                                $(this).closest('.creator__email--subscription').find('.invalid-feedback').text('Email không được để trống');
                            }
                        });

                        $('.creator__date--birthday').each(function() {
                            if ($(this).val()) {
                                $(this).closest('.customer__date--birthday').find('.invalid-feedback').text('Ngày sinh không đúng');
                            } else {
                                $(this).closest('.customer__date--birthday').find('.invalid-feedback').text('Ngày sinh không được để trống');
                            }
                        });
                    } else {
                        var btnThis = $(this);
                        event.preventDefault();
                        $('.btn__register_subscription').attr('disabled', true);
                        $.ajax({
                            url: "{{route('web.subscriptionValidate')}}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            data: {
                                'business_name': $('.subOpt__business--name').val(),
                                'business_alias': $('.subOpt__business--alias').val(),
                                'tax_code': $('.subOpt__tax--code').val(),
                                'duration_package': $('.subOpt__duration--package').val(),
                                'last_name': $('.subOpt__last--name').val(),
                                'first_middle_name': $('.subOpt__first--middle').val(),
                                'email': $('.creator__email--customer').val(),
                                'phone_number': $('.phone__number--customer').val(),
                                'birthday': $('.creator__date--birthday').val(),
                                'gender': $('.subOpt__gender').val(),
                                'address': $('.subOpt__address').val(),
                            },
                            success: function(response) {
                                console.log(response);
                                if(response.hasOwnProperty('success')) {
                                    console.log(3212);
                                    let formSubOption = $('#form__subscription--option');
                                    console.log(formSubOption.serialize());
                                    $.ajax({
                                        url: 'https://script.google.com/macros/s/AKfycbyL01gn1pZ_VgsgiK-IsABGO0ztcJLDWysLWT4IojcvYpf6w7_wqY2Ll03fE6jGfOY/exec',
                                        method: 'GET',
                                        dataType: 'json',
                                        data: formSubOption.serialize(),
                                        success: function(responseData, textStatus, jqXHR) {
                                            console.log(responseData);
                                            console.log(textStatus);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            console.log(errorThrown);
                                        }
                                    });

                                    btnThis.submit();
                                }
                            },
                            error: function(errorThrown) {
                                $('.btn__register_subscription').removeAttr('disabled');
                                console.log(errorThrown);
                            }
                        });
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
