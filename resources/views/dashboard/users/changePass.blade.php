@extends('layouts.admin')
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
                    <p class="mb-1" style="font-size: 18px ; font-weight: 500">Đổi mật khẩu</p>
                    <div class="form-account">
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="ft-size-account">Mật khẩu hiện tại</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                       aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="ft-size-account">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="form-group position-relative">
                                <label for="exampleInputPassword1" class="ft-size-account">Lặp lại mật khẩu mới</label>
                                <input type="password" class="form-control" id="exampleInputPassword1">
                                <i class="fas fa-chevron-down ft-size-account text-secondary pl-1 position-absolute"
                                   style="top: 41px;right: 13px;"></i>
                            </div>
                            <button type="submit"
                                    class="btn btn-primary button-account-edit py-2 px-4 mt-2 box-shadow-account"
                                    style="background-color: #F26D21">Đổi mật khẩu
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
