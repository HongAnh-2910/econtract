<div class="modal fade text-left w-100" id="HRM__modal--edit_{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-uppercase text-center" id="staticBackdropLabel">Sửa nhân sự</h1>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('web.human-resources.update', ['id' => $HRM->id]) }}">
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
                                    <input class="form-control name_validate" type="text" name="name"
                                        value="{{ $HRM->user->name }}">
                                    @error('name')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Giới
                                        tính<span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="gender">
                                        <option class="application__selectOption--disabled" value="" disabled="disabled"
                                            selected="selected">Chọn giới tính</option>
                                        <option @if ($HRM->gender == 'Nam') selected @endif value="Nam">Nam</option>
                                        <option @if ($HRM->gender == 'Nữ') selected @endif value="Nữ">Nữ</option>
                                        <option @if ($HRM->gender == 'Khác') selected @endif value="Khác">Khác</option>
                                    </select>
                                    @error('gender')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Số
                                        điện thoại<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="phone_number" value="{{ $HRM->phone_number }}"
                                        class="form-control name_validate">
                                    @error('phone_number')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative">
                                    <label class="ft-size-account font-weight-normal text-dark">Địa
                                        chỉ email (đăng
                                        nhập)<span class="text-danger">*</span></label>

                                    <input type="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}"
                                        name="email" value="{{ $HRM->user->email }}"
                                        class="form-control email__check--info">
                                    @error('email')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative">
                                    <label class="ft-size-account font-weight-normal text-dark">Mật
                                        khẩu<span class="text-danger">*</span></label>
                                    <input type="password" name="password" value="" class="form-control">
                                    @error('password')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group position-relative">
                                    <label class="ft-size-account font-weight-normal text-dark">Lặp
                                        lại
                                        mật khẩu<span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" value="" class="form-control">
                                    @error('password_confirmation')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
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
                                    <input type="date" name="date_start" value="{{ $HRM->date_start }}"
                                        class="form-control">
                                    @error('date_start')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
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
                                        name="department_id[]" multiple="multiple">
                                        @foreach ($departments as $department)
                                            <option @if (!empty($HRM->department->name))
                                                @if ($HRM->department->name == $department->name)
                                                    selected
                                                @endif
                                        @endif
                                        value="{{ $department->id }}">
                                        {{ str_repeat('---  ', $department->level) . $department->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Hình thức<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="form">
                                        <option class="application__selectOption--disabled" value="{{ old('form') }}"
                                            disabled="disabled" selected="selected">Chọn hình thức</option>
                                        <option @if ($HRM->form == 'TTS') selected @endif value="TTS">TTS</option>
                                        <option @if ($HRM->form == 'Thử việc') selected @endif value="Thử việc">Thử việc</option>
                                        <option @if ($HRM->form == 'HĐ 1 năm') selected @endif value="HĐ 1 năm">Hợp Đồng 1 năm</option>
                                        <option @if ($HRM->form == 'HĐ không thời hạn') selected @endif value="HĐ không thời hạn">Hợp Đồng không thời
                                            hạn</option>
                                    </select>
                                    @error('form')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Sinh ngày<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date_of_birth" value="{{ $HRM->date_of_birth }}"
                                        class="form-control name_validate">
                                    @error('date_of_birth')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Số CMND/Hộ chiếu<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="passport" value="{{ $HRM->passport }}"
                                        class="form-control name_validate">
                                    @error('passport')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Ngày cấp<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date_range" value="{{ $HRM->date_range }}"
                                        class="form-control name_validate">
                                    @error('date_range')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Nơi cấp<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="place_range" value="{{ $HRM->place_range }}"
                                        class="form-control name_validate">
                                    @error('place_range')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Địa chỉ thường trú<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="permanent_address" value="{{ $HRM->permanent_address }}"
                                        class="form-control name_validate">
                                    @error('permanent_address')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Địa chỉ hiện tại<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="current_address" value="{{ $HRM->current_address }}"
                                        class="form-control name_validate">
                                    @error('current_address')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Số tài khoản<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="account_number" value="{{ $HRM->account_number }}"
                                        class="form-control name_validate">
                                    @error('account_number')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Tên tài khoản<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name_account" value="{{ $HRM->name_account }}"
                                        class="form-control name_validate">
                                    @error('name_account')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Tên ngân hàng<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name_bank" value="{{ $HRM->name_bank }}"
                                        class="form-control name_validate">
                                    @error('name_bank')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">Biển số xe<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="motorcycle_license_plate"
                                        value="{{ $HRM->motorcycle_license_plate }}"
                                        class="form-control name_validate">
                                    @error('motorcycle_license_plate')
                                        <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label class="ft-size-account font-weight-normal text-dark">File<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="file" class="form-control name_validate">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
