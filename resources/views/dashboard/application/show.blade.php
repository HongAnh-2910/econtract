<div class="modal fade text-left w-100" id="application__modal--show_{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel20" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-full" role="document">
        <div class="modal-content" style="overflow-y: scroll">
            <h3 class="text-center my-4 text-uppercase" id="myModalLabel20">{{$application->proposal_name != null ? "Chi tiết đơn đề nghị" : "Chi tiết đơn xin nghỉ"  }}</h3>
            <div class="container-fluid px-4">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="row">
                            @if (!empty($application->code))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Mã KH:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->code }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->name))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Người tạo đơn:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->proposal_name))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Tên đề suất:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->proposal_name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->proponent))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Người đề nghị:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->proponent }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->status))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Trạng thái:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->status }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->reason))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Lý do:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->reason }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->application_type))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Loại đơn từ:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->application_type }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="row">
                            @if (!empty($application->position))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Vị trí:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText">
                                                {{ $application->position }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="font-weight-bold customer__show--sizeText">Người phê duyệt:
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <p class="customer__show--sizeText">
                                            {{ !empty($application->user->name) ? $application->user->name : '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @if (!empty($application->department_id))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Phòng ban:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText ">
                                                {{ $application->department_id }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->account_information))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Thông tin tài khoản:</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p class="customer__show--sizeText ">
                                                {{ $application->account_information }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($application->application_type == 'Đơn xin nghỉ')
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Tổng ngày nghỉ</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            @php
                                                if ($application->user_application) {
                                                    $informationDays = \App\Models\Application::with('dateTimeOfApplications')
                                                        ->where('user_application', $application->user_application)
                                                        ->get();
                                                    $count = 0;
                                                    foreach ($informationDays as $value) {
                                                        $countDay = 0;
                                                        foreach ($value->dateTimeOfApplications as $total) {
                                                            $to_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $total->information_day_2);
                                                            $from_date = Illuminate\Support\Carbon::createFromFormat('Y-m-d H:s:i', $total->information_day_4);
                                                            $countDay += $to_date->diffInDays($from_date);
                                                        }
                                                        $count += $countDay;
                                                    }
                                                }
                                            @endphp
                                            <p class="customer__show--sizeText">
                                                {{ $application->user_application ? $count . ' ' . 'Ngày' : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($application->application_type == 'Đơn đề nghị')
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="font-weight-bold customer__show--sizeText">Ngày cần hàng</div>
                                        </div>
                                        <div class="col-md-8 col-6">
                                            <p>Ngày {{ date('d/m/Y', strtotime($application->delivery_date)) }} vào {{ $application->delivery_time }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($application->description))
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                            <div class="font-weight-bold customer__show--sizeText">Mô tả:
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-6 col-12">
                                            <div style="font-size: 18px" class="customer__show--sizeText"
                                                id="description_show">{!! $application->description !!} </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($application->proposal_name)
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Số tiền:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText"
                                                     id="description_show">{{number_format($application->price_proposal , 0 ,'' , '.')."đ"}} </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($application->created_at)
                                    <div class="col-12{{ request()->status == "Đơn đề nghị" ? ' mt-2' : '' }}">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-12 mb-sm-0 mb-2">
                                                <div class="font-weight-bold customer__show--sizeText">Ngày tạo:
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-12">
                                                <div style="font-size: 18px" class="customer__show--sizeText"
                                                     id="description_show">{{ $application->created_at }} </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 modal__contract--bg--header mt-3">
                        <span class="text-dark pl-3 d-inline-block py-1">TRẠNG THÁI ĐƠN TỪ</span>
                    </div>
                </div>
                <div class="mt-4 mb-5">
                        <div class="col-md-6 col-12 dashboard__contract--status">
                                <div class="d-flex align-items-center">
                                    <i class="{{ $application->status == 'Chờ duyệt' ? 'fas fa-exclamation' : 'fas fa-check' }}
                                    {{ $application->status == 'Chờ duyệt' ? 'text-warning' : 'text-success' }}" aria-hidden="true"></i>
                                    <h5 class="ml-3 mb-0 {{ $application->status == 'Chờ duyệt' ? 'text-warning' : 'text-success' }}">{{ $application->status == 'Chờ duyệt' ? 'Chờ Duyệt' : 'Đã Duyệt' }}</h5>
                                </div>
{{--                            <div class="d-flex align-items-md-center justify-content-between align-items-start flex-md-row flex-column">--}}
{{--                                <a target="_blank" href=""></a>--}}
{{--                                <a href="#" class="float-right">2021</a>--}}
{{--                            </div>--}}
                            <ul class="dashboard__timeline">
                                    <li class="dashboard__timeline--active'">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex flex-column">
                                                <span>Người phê duyệt:</span>
                                                <span>Email</span>
                                                <span>Trạng thái:</span>
                                            </div>
                                            <div class="d-flex flex-column ml-4">
                                                <span class="font-weight-bold">{{ $application->user->name ?? '' }}</span>
                                                <span>
                                                {{ $application->user->email ?? '' }}
                                                <!-- Neu chua ky va contract da duoc mail thi moi cho gui lai email -->
                                                        <a href="{{ route('web.applications.sendMailReturn' , $application->user->id) }}"  class="text-warning pe-auto dashboard__resend--button">(Gửi lại)</a>
                                            </span>
                                                <span class="{{ $application->status == 'Chờ duyệt' ? 'text-warning' : 'text-success' }}">{{ $application->status }}</span>
                                            </div>
                                        </div>
                                    </li>
                            </ul>
                            <div class="box__follow">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa-1x text-success" aria-hidden="true"></i>
                                    <h5 class="ml-3 mb-0 text-dark">Người theo dõi</h5>
                                </div>
                                @if($application->users->count() > 0)
                                <ul class="dashboard__timeline">
                                    <li class="dashboard__timeline--active'">
                                        @foreach($application->users as $user_follow)
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="d-flex flex-column">
                                                <span>Email:</span>
                                            </div>
                                            <div class="d-flex flex-column ml-4">
                                                <span class="font-weight-bold">{{ $user_follow->name }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </li>
                                </ul>
                                @endif
                            </div>
                        </div>
                </div>
            </div>

            <div class="mb-md-4 mb-4 mx-md-5 d-flex justify-content-md-end justify-content-center">
                <button type="button" class="btn btn-light-secondary button__add--customer mx-3"
                    data-bs-dismiss="modal">
                    <span>Đóng</span>
                </button>

            </div>
        </div>
    </div>
</div>
