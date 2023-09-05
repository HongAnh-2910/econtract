@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row mt-4 mx-3">
            <div class="col-12 ">
                <h2 class="text-black">Hình thức thanh toán</h2>
            </div>
            <div class="col-12">
                <p>Tổng tiền:</p>
            </div>
            <div class="col-12">
                <h1>230.000đ</h1>
            </div>
            <div class="col-12 payment__background--color--ul">
                <ul>
                    <li class="mt-4">Bước 1: Lựa chọn Gói Dịch Vụ + Số Tháng tại đây để xem số tiền phải thanh toán</li>
                    <li class="mt-3">Bước 2: Chuyển khoản vào các thông tin tài khoản bên dưới theo cú pháp [Tên_tài_khoản]
                        _ [Gói Nạp]_[Số tháng]</li>
                    <li class="mt-3">Bước 3: Chờ từ 1- 15 phút để được kích hoạt hạn mức</li>
                </ul>
            </div>
            <div class="col-12 mt-5 ">
                <ul class="d-flex justify-content-center list-unstyled">
                    <li class="text-center text-dark">
                        <div class="payment__image--ul">
                            <img class="mt-4" src="{{ asset('images/vpbank.png') }}">
                            <p class="mt-3" style="color: #828282;">VPBank</p>
                        </div>
                        <div class="mt-3">VIETCOMBANK HÀ NỘi</div>
                        <div class="mt-3">Chủ tài khoản: Tran Tuan Anh</div>
                        <div class="mt-3">STK: <span class="text-primary">00 21 000I 26 00 95</span></div>
                    </li>
                    <li class="text-center text-dark mx-5">
                        <div class="payment__image--ul">
                            <img class="mt-2" src="{{ asset('images/vietcombank.png') }}">
                            <p class="mt-2" style="color: #828282;">Vietcombank</p>
                        </div>
                        <div class="mt-3">VIETCOMBANK HÀ NỘi</div>
                        <div class="mt-3">Chủ tài khoản: Tran Tuan Anh</div>
                        <div class="mt-3">STK: <span class="text-primary">00 21 000I 26 00 95</span></div>
                    </li>
                    <li class="text-center text-dark">
                        <div class="payment__image--ul">
                            <img class="mt-4" src="{{ asset('images/acbbank.png') }}">
                            <p class="mt-3" style="color: #828282;">ACB</p>
                        </div>
                        <div class="mt-3">VIETCOMBANK HÀ NỘi</div>
                        <div class="mt-3">Chủ tài khoản: Tran Tuan Anh</div>
                        <div class="mt-3">STK: <span class="text-primary">00 21 000I 26 00 95</span></div>
                    </li>
                </ul>
            </div>
            <div class="col-12 payment__textNote--color bg-white text-dark mt-5">
                <div class="my-3 mx-1">
                    <div>* Lưu ý: Sau khi hoàn tất thanh toán, Quý đối tác vui lòng kiểm tra lại mục Thanh toán xem đơn hàng đã
                        thanh toán thành công hay chưa?</div>
                    <div>Thông thường sau khi hoàn tất thanh toán, tiền sẽ được nạp vào ID trong 1- 15p . Sau thời gian này nếu
                        tài khoản ID không có tiền quý khách vui lòng liên hệ ngay bộ phận kinh doanh của chúng tôi để kiểm tra.
                    </div>
                    <div>HCM +82(28) 36229999, HN: +84(24) 35123457(Giờ hành chính) hoặc Hotline: 19001830(24/7)</div>
                </div>

            </div>
            <div class="col-12 text-center mt-5">
                <button type="button" class="btn buttonPayment__resendRequest--color text-white">Gửi yêu cầu</button>
            </div>
        </div>
    </div>
@endsection
