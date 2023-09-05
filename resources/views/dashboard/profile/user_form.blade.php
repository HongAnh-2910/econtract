<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <form id="demoForm" class="needs-validation" method="POST" action="{{ route('web.users.store') }}" novalidate>
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Thêm mới người dùng
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mt-2" style="overflow-y: hidden">
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Họ
                            và tên</label>
                        @error('name_add')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name_add" value="{{ old('name_add') }}"
                            class="form-control name_validate" id="exampleInputPassword1" required>
                        <div class="invalid-feedback pl-0">
                            Tên người dùng không được để trống
                        </div>
                    </div>
                    <div class="form-group position-relative">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Địa
                            chỉ email (đăng
                            nhập)</label>

                        <input type="email"
                            name="email_add" value="{{ old('email_add') }}" class="form-control email__check--info"
                            id="exampleInputPassword1" required>
                        <div class="invalid-feedback pl-0">
                            Bạn nhập sai định dạng Email hoặc đang được để trống
                        </div>
                        @error('email_add')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group position-relative">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Mật
                            khẩu</label>
                        @error('password')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <input type="password" name="password" value="" class="form-control"
                            id="exampleInputPassword1" required>
                        <div class="invalid-feedback pl-0">
                            Mật khẩu không được để trống
                        </div>
                    </div>
                    <div class="form-group position-relative">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Lăp lại
                            mật khẩu</label>
                        @error('password_confirmation')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <input type="password" name="password_confirmation" value="" class="form-control"
                            id="exampleInputPassword1" required>
                        <div class="invalid-feedback pl-0">
                            Lặp lại mật khẩu không được để trống
                        </div>
                    </div>
                    <div class="form-group position-relative parent_department">
                        <label for="exampleInputPassword1"
                            class="ft-size-account font-weight-normal d-block text-dark">Phòng ban</label>
                        @error('department_add.*')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <i style="position: absolute;top: 39px;right: 9px;z-index: 2;"
                            class="fas fa-chevron-down down__active--hover"></i>
                        <select class="department__select js-example-placeholder-multiple js-states form-control pl-2"
                            name="department_add[]" multiple="multiple" required>
                            @foreach ($listDepartmentLevel as $department)
                                <option @if (!empty(old('department_add')))
                                    @foreach (old('department_add') as $value)
                                        @if ($value == $department->id)
                                            selected
                                        @endif
                                    @endforeach
                            @endif
                            value="{{ $department->id }}">{{ str_repeat('---  ', $department->level) . $department->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback pl-0">
                            Phòng ban không được để trống
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary button-account-edit py-2 px-5 box-shadow-account"
                        style="background-color: #462ECA"> Tạo mới
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- validate --}}
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
