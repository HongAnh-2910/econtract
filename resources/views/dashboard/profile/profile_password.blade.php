@extends('layouts.dashboard', ['key' => 'profile_password', 'menu_type' => 'menu_profile' , 'isShowError' => false])
@section('content')
    <div class="container-fluid custom__container--fluid bg-white">
{{--        <div class="title-account">--}}
{{--            <div class="col-md-12 py-3">--}}
{{--                <h4 class="mb-0">Quản lý tài khoản</h4>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="detail-account bg-white mx-3" style="height: 70vh">
            <div class="">
                <div class="col-md-7 py-4 px-0 px-sm-1 px-md-2">
                    <p class="mb-1 text-dark" style="font-size: 18px ; font-weight: 600">Đổi mật khẩu</p>
                    <div class="form-account">
                        <form method="POST" action="{{ route('web.profile.changePassword') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="ft-size-account font-weight-normal text-dark">Mật
                                    khẩu hiện tại</label>
                                @error('pass-old')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <input type="password" name="pass-old" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Mật
                                    khẩu mới</label>
                                @error('password')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group position-relative">
                                <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Lặp
                                    lại mật khẩu mới</label>
                                @error('password_confirmation')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <input type="password" name="password_confirmation" class="form-control"
                                       id="exampleInputPassword1">
                                <i class="fas fa-chevron-down ft-size-account text-secondary pl-1 position-absolute"
                                   style="top: 41px;right: 13px;"></i>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary button-account-edit py-2 px-4 mt-2 box-shadow-account"
                                    style="background-color: #462ECA">Đổi mật khẩu
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
