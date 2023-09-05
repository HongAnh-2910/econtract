@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm thành viên
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('web.users.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        @error('name')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        @error('email')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <input class="form-control" type="text" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="email">Mật khẩu</label>
                        @error('password')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <input class="form-control" type="password" name="password" id="email">
                    </div>
                    <div class="form-group">
                        <label for="email">Nhập lại mật khẩu</label>
                        @error('password_confirmation')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <input class="form-control" type="password" name="password_confirmation" id="email">
                    </div>
                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        @error('role')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                        <select class="form-control" id="" name="role">
                            <option value="">Chọn quyền</option>
                            @if($listRoles->count() > 0)
                                @foreach($listRoles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name_role }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
