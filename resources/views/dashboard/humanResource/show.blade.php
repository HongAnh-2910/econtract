<div class="modal fade text-left w-100" id="HRM__modal--show_{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-full" role="document">
        <div class="modal-content" style="overflow-y: scroll">
            <h3 class="text-center my-4 text-uppercase" id="myModalLabel20">Chi tiết nhân sự </h3>
            <div class="container-fluid px-4">
                <div class="row">

                    <h5 class="text-uppercase">Thông tin tài khoản</h5>
                    <div class="col-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->user->name))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Họ và tên:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->user->name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->gender))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Giới tính:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->gender }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->phone_number))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Số điện thoại:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->phone_number }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->user->email))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Email:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->user->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h5 class="text-uppercase mt-5">Thông tin nhân sự</h5>
                    <div class="col-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->date_start))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Ngày bắt đầu:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ date('d/m/Y', strtotime($HRM->date_start)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->department->name))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Phòng ban:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->department->name }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->form))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Hình thức:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->form }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->date_of_birth))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Sinh ngày:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ date('d/m/Y', strtotime($HRM->date_of_birth)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->passport))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Số CMND/Hộ chiếu:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->passport }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->date_range))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Ngày cấp:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ date('d/m/Y', strtotime($HRM->date_range)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->place_range))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Nơi cấp:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->place_range }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->permanent_address))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Địa chỉ thường
                                                    trú:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->permanent_address }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->current_address))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Địa chỉ hiện
                                                    tại:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->current_address }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->account_number))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Số tài khoản:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->account_number }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->name_account))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Tên tài khoản:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->name_account }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->name_bank))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Tên ngân hàng:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->name_bank }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->motorcycle_license_plate))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Biển số xe:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    {{ $HRM->motorcycle_license_plate }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 col-12">
                                @if (!empty($HRM->file))
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">File:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText">
                                                    <img src="{{ asset($HRM->file) }}" height="50" width="50"
                                                        alt="Can't show image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="my-md-4 my-4 mx-md- 5 d-flex justify-content-md-end justify-content-center">
                <button type="button" class="btn btn-light-secondary button__add--customer mx-3"
                    data-bs-dismiss="modal">
                    <span>Đóng</span>
                </button>

            </div>
        </div>
    </div>
</div>
