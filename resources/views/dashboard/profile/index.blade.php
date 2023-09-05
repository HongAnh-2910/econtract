@extends('layouts.dashboard', ['key' => 'profile', 'menu_type' => 'menu_profile'])
@section('content')
    <div class="container-fluid custom__container--fluid bg-white">
{{--        <div class="title-account">--}}
{{--            <div class="col-md-12 py-3">--}}
{{--                <h4 class="mb-0">Quản lý tài khoản</h4>--}}
{{--            </div>--}}
{{--        </div>--}}
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="detail-account bg-white mx-sm-3 mx-2" style="height: 70vh">
            <form method="POST" action="{{ route('web.profile.update',$userFind->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="d-flex flex-column-reverse flex-md-row">
                    <div class="col-md-7 pl-1 pr-1 pr-md-3 pt-4 pb-5">
                        <p class="mb-1 text-dark" style="font-size: 18px ; font-weight: 600">Chi tiết tài khoản</p>
                        <div class="form-account">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="ft-size-account font-weight-normal text-dark">Tên
                                    tài khoản</label>
                                <input type="text" class="form-control" disabled value="admin" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Họ
                                    và tên</label>
                                @error('name')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <input type="text" name="name" value="{{ $userFind->name }}" class="form-control"
                                       id="exampleInputPassword1">
                            </div>
                            <div class="form-group position-relative">
                                <label for="exampleInputPassword1" class="ft-size-account font-weight-normal text-dark">Địa
                                    chỉ email (đăng
                                    nhập)</label>
                                @error('email')
                                <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <input type="email" name="email" value="{{ $userFind->email }}" class="form-control"
                                       id="exampleInputPassword1">
                                <i class="fas fa-chevron-down ft-size-account text-secondary pl-1 position-absolute"
                                   style="top: 41px;right: 13px;"></i>
                            </div>
                            <div class="form-group py-2 d-flex align-items-center justify-content-center justify-content-md-start">
                                <a href="" class="text-primary"><span
                                        class="ft-size-account">Địa chỉ và thời gian</span></a>
                                <i class="fas fa-chevron-down ft-size-account text-secondary pl-1"></i>
                            </div>
                            <button type="submit"
                                    class="d-flex mx-auto mx-md-0 btn btn-primary button-account-edit  py-2 px-5 box-shadow-account"
                                    style="background-color: #462ECA">Cập nhật
                            </button>
                        </div>
                    </div>
                    <div class="col-md-5 mt-5 mt-md-0 d-flex align-items-center justify-content-center rounded">
                        <label for="avatar__img--info">
                            <div class="box__avatar--img--info position-relative content__upload--file--item">
                                <div class="avatar__img--black position-absolute w-100 h-100"></div>
                                <div class="avatar__img--info--img position-relative">
                                    <img width="255" height="255" class="rounded-circle image__permission--round" id="thumb"
                                         src="{{ $userFind->avatar_link }}">
                                    <div class="profile__avatar--link">
                                        <i class="fas fa-camera icon__camera--edit"></i>
                                    </div>
                                </div>
                                <input type="file" onchange="preview()" name="file" id="avatar__img--info" multiple
                                       hidden>
                            </div>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function preview() {
            thumb.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
