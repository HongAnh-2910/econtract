<div class="modal fade" id="humanResource__modal--create" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-uppercase text-center" id="staticBackdropLabel">Thêm mới nhân sự</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="needs-validation" method="POST" action="{{ route('web.human-resources.store') }}"
                enctype="multipart/form-data" novalidate>
                @method('POST')
                @csrf

                <div class="modal-body mt-2">
                    <h5 class="modal-title text-uppercase" id="staticBackdropLabel">Thông tin tài khoản</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Họ
                                        và tên<span class="text-danger">*</span>
                                    </label>
                                    @error('name')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Tên người dùng không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Giới
                                        tính<span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="gender" required>
                                        <option class="application__selectOption--disabled" value="" disabled="disabled"
                                            selected="selected">Chọn giới tính</option>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                    <div class="invalid-feedback pl-0">
                                        Giới tính không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Số
                                        điện thoại<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" name="phone_number"
                                        value="{{ old('phone_number') }}" class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Số điện thoại không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative">
                                    <label class="ft-size-account font-weight-normal text-dark">Địa
                                        chỉ email (đăng
                                        nhập)<span class="text-danger">*</span></label>
                                    @error('email')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                    <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"
                                        name="email" value="{{ old('email') }}"
                                        class="form-control email__check--info" required>
                                    <div class="invalid-feedback pl-0">
                                        Bạn nhập sai định dạng Email hoặc đang được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative">
                                    <label class="ft-size-account font-weight-normal text-dark">Mật
                                        khẩu<span class="text-danger">*</span></label>
                                    <input type="password" name="password" value="" class="form-control" required>
                                    <div class="invalid-feedback pl-0">
                                        Mật khẩu không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative">
                                    <label class="ft-size-account font-weight-normal text-dark">Lặp
                                        lại
                                        mật khẩu<span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" value="" class="form-control"
                                        required>
                                    <div class="invalid-feedback pl-0">
                                        Lặp lại mật khẩu không được để trống
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!---------------------------  Thông tin nhân sự       -------------------------------->
                    <h5 class="modal-title text-uppercase mt-2">Thông tin nhân sự</h5>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Ngày bắt đầu<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date_start_add" value="{{ old('date_start_add') }}"
                                        class="form-control" required>
                                    <div class="invalid-feedback pl-0">
                                        Ngày bắt đầu không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative parent_department">
                                    <label class="ft-size-account font-weight-normal d-block text-dark">Phòng
                                        ban</label>
                                    <i style="position: absolute;top: 39px;right: 9px;z-index: 2;"
                                        class="fas fa-chevron-down down__active--hover"></i>
                                    <select
                                        class="department__select js-example-placeholder-multiple js-states form-control pl-2"
                                        name="department_id[]" multiple="multiple" required>
                                        @foreach ($departments as $department)
                                            <option @if (!empty(old('department_id')))
                                                @foreach (old('department_id') as $value)
                                                    @if ($value == $department->id)
                                                        selected
                                                    @endif
                                                @endforeach
                                        @endif
                                        value="{{ $department->id }}">
                                        {{ str_repeat('---  ', $department->level) . $department->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback pl-0">
                                        Phòng ban không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Hình thức<span
                                            class="text-danger">*</span>
                                    </label>
                                    @error('form')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                    <select class="form-select" name="form" required>
                                        <option class="application__selectOption--disabled" disabled="disabled"
                                            selected="selected">Chọn hình thức</option>
                                        <option value="TTS">TTS</option>
                                        <option value="Thử việc">Thử việc</option>
                                        <option value="HĐ 1 năm">Hợp Đồng 1 năm</option>
                                        <option value="HĐ không thời hạn">Hợp Đồng không thời hạn</option>
                                    </select>
                                    <div class="invalid-feedback pl-0">
                                        Hình thức không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Sinh ngày<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Sinh ngày không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Số CMND/Hộ chiếu<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="passport" value="{{ old('passport') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Số CMND/Hộ chiếu không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Ngày cấp<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date_range" value="{{ old('date_range') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Ngày cấp không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Nơi cấp<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="place_range" value="{{ old('place_range') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Nơi cấp không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Địa chỉ thường trú<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="permanent_address"
                                        value="{{ old('permanent_address') }}" class="form-control name_validate"
                                        required>
                                    <div class="invalid-feedback pl-0">
                                        Địa chỉ thường trú không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Địa chỉ hiện tại<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="current_address" value="{{ old('current_address') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Địa chỉ hiện tại không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Số tài khoản<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="account_number" value="{{ old('account_number') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Số tài khoản không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Tên tài khoản<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="name_account"
                                        value="{{ old('name_account') }}" required>
                                    <div class="invalid-feedback pl-0">
                                        Tên tài khoản không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Tên ngân hàng<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name_bank" value="{{ old('name_bank') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Tên ngân hàng không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Biển số xe<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="motorcycle_license_plate"
                                        value="{{ old('motorcycle_license_plate') }}"
                                        class="form-control name_validate" required>
                                    <div class="invalid-feedback pl-0">
                                        Biển số xe không được để trống
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">File
                                    </label>
                                    <input type="file" name="file" class="form-control name_validate">
                                    <div class="invalid-feedback pl-0">
                                        File không được để trống
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-placeholder-multiple').select2();
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
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
