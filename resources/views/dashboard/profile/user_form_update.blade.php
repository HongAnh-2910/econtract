<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <form method="POST" action="{{ route('web.profile.update', ['id' => $user->id]) }}">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Sửa người dùng
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mt-2" style="overflow-y: hidden">
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Họ
                            và tên</label>
                        @error('name')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control name_validate"
                            id="exampleInputPassword1">
                    </div>
                    <div class="form-group position-relative">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Địa
                            chỉ email (đăng
                            nhập)</label>
                        @error('email')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="form-control email__check--info" id="exampleInputPassword1">
                    </div>
                    <div class="form-group position-relative">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Mật
                            khẩu</label>
                        <input type="password" name="password" value="" class="form-control"
                            id="exampleInputPassword1">

                    </div>
                    <div class="form-group position-relative">
                        <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Lăp lại
                            mật khẩu</label>
                        <input type="password" name="password_confirmation" value="" class="form-control"
                            id="exampleInputPassword1">

                    </div>
                    <div class="form-group position-relative parent_department--edit">
                        <label for="exampleInputPassword1"
                            class="ft-size-account font-weight-normal d-block text-dark">Phòng ban</label>
                        @error('department.*')
                            <div class="text text-danger" style="font-size: 14px">{{ $message }}</div>
                        @enderror
                        <i style="position: absolute;top: 39px;right: 9px;z-index: 2;"
                            class="fas fa-chevron-down down__active--hover"></i>
                        <select class="department__select js-example-placeholder-multiple js-states form-control pl-2"
                            name="department[]" multiple="multiple" required>
                            @foreach ($listDepartmentLevel as $department)
                                <option @foreach ($user->departments as $department_id)
                                    @if ($department_id->id == $department->id)
                                        selected
                                    @endif
                            @endforeach
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
                        style="background-color: #462ECA"> Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
