@extends('layouts.dashboard', ['id'=> 1, 'type' => 'profile'])
@section('content')
    <div id="content" class="container">
        <div class="title-account">
            <div class="col-md-12 pb-2">
                <h4>Quản lý tài khoản</h4>
            </div>
        </div>
        <div class="detail-account bg-white mx-3" style="height: 70vh">
            <div class="row">
                <div class="col-md-7 px-5 pt-3">
                    <p class="mb-1" style="font-size: 18px ; font-weight: 500">Chi tiết tài khoản</p>
                    <div class="form-account">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="ft-size-account">Tên tài khoản</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="ft-size-account">Họ</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group position-relative">
                                <label for="exampleInputPassword1" class="ft-size-account">Địa chỉ email (đăng
                                    nhập)</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                                <i class="fas fa-chevron-down ft-size-account text-secondary pl-1 position-absolute"
                                   style="top: 41px;right: 13px;"></i>
                            </div>
                            <div class="form-group py-2">
                                <a href="" class="text-primary"><span
                                        class="ft-size-account">Địa chỉ và thời gian</span></a>
                                <i class="fas fa-chevron-down ft-size-account text-secondary pl-1"></i>
                            </div>
                            <button type="submit" class="btn btn-primary button-account-edit py-2 px-5 box-shadow-account"
                                    style="background-color: #F26D21">Cập nhật
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-5">

                </div>
            </div>
        </div>
    </div>
@endsection
