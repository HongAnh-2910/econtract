@extends('layouts.dashboard', ['key' => 'dashboard'])
@section('content')
    <style>
        .apexcharts-menu-icon {
            display: none;
        }

        .d__none--search {
            display: none !important;
        }

        .form-control:disabled, .form-control[readonly] {
            background-color: #e9ecef2e !important;
            opacity: 1;
        }
    </style>
    <div id="content" class="ml-md-3 mx-2 mt-2">
        <div class="title__statistical">
            <h2 class="py-3 mb-0 font-bold">Thống kê nhân sự</h2>
        </div>
        <div class="statistical__up">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 pr-0">
                            <div class="human__statistical bg-white text-center py-4 fz-human-14 box_shadow_human"
                                 style=" border-right: 2px solid #80808026;">
                                <div class="title__human text-uppercase">
                                    Nhân sự
                                </div>
                                <div class="title__total--human text-dark table__contract--item-fz">
                                    Tất cả
                                </div>
                                <div class="number__total--human font-weight-bold text-dark py-1 fz-human-25">
                                    {{ $countStatusHrm['countHRM'] }}
                                </div>
                                <div class="number__total--human table__contract--item-fz">
                                    <div class="bg__human d-inline-block px-2 rounded"
                                         style="background-color: #ffc10752">
                                        Danh sách
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 px-0">
                            <div class="human__statistical bg-white text-center py-4 fz-human-14 box_shadow_human"
                                 style=" border-right: 2px solid #80808026;">
                                <div class="title__human text-uppercase">
                                    Nhân sự
                                </div>
                                <div class="title__total--human text-dark table__contract--item-fz">
                                    Đang làm việc
                                </div>
                                <div class="number__total--human font-weight-bold text-dark py-1 fz-human-25">
                                    {{ $countStatusHrm['countHRM'] }}
                                </div>
                                <div class="number__total--human table__contract--item-fz">
                                    <div class="bg__human d-inline-block px-2 rounded"
                                         style="background-color: #ffc10752">
                                        Danh sách
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pl-0">
                            <div class="human__statistical bg-white text-center py-4 fz-human-14 box_shadow_human">
                                <div class="title__human text-uppercase">
                                    Nhân sự
                                </div>
                                <div class="title__total--human text-dark table__contract--item-fz">
                                    Đã nghỉ việc
                                </div>
                                <div class="number__total--human font-weight-bold text-dark py-1 fz-human-25">
                                    {{ $countStatusHrm['countDeletes'] }}
                                </div>
                                <div class="number__total--human table__contract--item-fz">
                                    <div class="bg__human d-inline-block px-2 rounded"
                                         style="background-color: #ffc10752">
                                        Danh sách
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-7 pr-0">
                            <div
                                class="box__human--gt bg-white d-flex justify-content-around border__human-80808026 box_shadow_human">
                                <div class="human__statistical--gt d-flex">
                                    <div class="border__human bg-success"></div>
                                    <div class="list__human--gt">
                                        <div class="total__human-male">
                                            <span class="count__male d-block text-success font-weight-bold fz-human-24"
                                                  style="line-height: 23px;">{{ $countStatusHrm['male'] }}</span>
                                            <span class="title__male text-success fz-human-14">Nhân sự nam</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="human__statistical--gt bg-white d-flex">
                                    <div class="border__human bg-danger"></div>
                                    <div class="list__human--gt">
                                        <div class="total__human-male">
                                            <span class="count__male d-block text-danger font-weight-bold fz-human-24"
                                                  style="line-height: 23px;">{{ $countStatusHrm['female'] }}</span>
                                            <span class="title__male text-danger fz-human-14">Nhân sự nữ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="human__statistical--gt bg-white d-flex">
                                    <div class="border__human bg-secondary"></div>
                                    <div class="list__human--gt">
                                        <div class="total__human-male">
                                            <span
                                                class="count__male d-block text-secondary font-weight-bold fz-human-24"
                                                style="line-height: 23px;">{{ $countStatusHrm['different'] }}</span>
                                            <span class="title__male text-secondary fz-human-14">Không xác định</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="human__statistical bg__human--app py-4 fz-human-14 pl-4 box_shadow_human"
                                 style="height: 157px;">
                                <div class="title__human text-uppercase text-white">
                                    Nhân sự
                                </div>
                                <div class="title__total--human text-dark table__contract--item-fz text-white">
                                    Mới trong tháng
                                </div>
                                <div
                                    class="number__total--human font-weight-bold text-dark py-1 fz-human-25 text-white">
                                    {{ $monthHrm['data'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--        expor--}}
        <div class="row">
            <div class="col-md-12 d-md-flex mt-4">
                <div class="col-md-3 pl-0 pr-md-1 pr-0 mb-4 mb-md-0">
                    <div class="human__statistical bg__tts py-4 fz-human-14 pl-4  box_shadow_human"
                         style=" height: 157px">
                        <div class="title__human text-uppercase text-white">
                            Thực tập sinh
                        </div>
                        <div class="title__total--human text-dark table__contract--item-fz text-white">
                            Tổng số
                        </div>
                        <div
                            class="number__total--human font-weight-bold text-dark py-1 fz-human-25 text-white">
                            {{ $countStatusHrm['TTS'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pl-md-1 pl-0 pr-md-1 pr-0 mb-4 mb-md-0">
                    <div class="human__statistical bg__1n py-4 fz-human-14 pl-4  box_shadow_human"
                         style=" height: 157px">
                        <div class="title__human text-uppercase text-white">
                            Hợp đồng 1 năm
                        </div>
                        <div class="title__total--human text-dark table__contract--item-fz text-white">
                            Tổng số
                        </div>
                        <div
                            class="number__total--human font-weight-bold text-dark py-1 fz-human-25 text-white">
                            {{ $countStatusHrm['yearOne'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pl-md-1 pl-0 pr-md-1 pr-0 mb-4 mb-md-0">
                    <div class="human__statistical bg__tv py-4 fz-human-14 pl-4  box_shadow_human"
                         style="height: 157px">
                        <div class="title__human text-uppercase text-white">
                            Thử việc
                        </div>
                        <div class="title__total--human text-dark table__contract--item-fz text-white">
                            Tổng số
                        </div>
                        <div
                            class="number__total--human font-weight-bold text-dark py-1 fz-human-25 text-white">
                            {{ $countStatusHrm['inter'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pr-0 pl-md-1 pl-0 pr-md-1 pr-0 mb-4 mb-md-0">
                    <div class="human__statistical bg__nn py-4 fz-human-14 pl-4 box_shadow_human"
                         style=" height: 157px">
                        <div class="title__human text-uppercase text-white">
                            Hợp đồng không giới hạn
                        </div>
                        <div class="title__total--human text-dark table__contract--item-fz text-white">
                            Tổng số
                        </div>
                        <div
                            class="number__total--human font-weight-bold text-dark py-1 fz-human-25 text-white">
                            {{ $countStatusHrm['unlimitedContract'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--        end_statisical_up--}}
        <div class="statistical__down mt-4">
            <div class="row">
                <div class="col-md-6 pr-4">
                    <div class="statistical__down--gt">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart__statistical--gt bg-white box_shadow_human">
                                    <div class="title__chart-gt border-bottom text-dark font-weight-bold pl-3 py-1">
                                        Giới tính
                                    </div>
                                    <div class="box__chart-gt py-2">
                                        <div id="chart-visitors-profile"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pr-0  bg-white box_shadow_human" style="height: 366px ; padding-top: 32px ; overflow: scroll">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="text-dark">STT</th>
                            <th scope="col" class="text-dark">Tên nhân sự</th>
                            <th scope="col" class="text-dark">Ngày bắt đầu</th>
                            <th scope="col" class="text-dark">Phòng ban</th>
                            <th scope="col" class="text-dark">Đã nghỉ (Ngày)</th>
                            <th scope="col" class="text-dark">Còn lại (Ngày)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listHrm->count() > 0)
                            @foreach($listHrm as $key => $Hrm)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $Hrm->user->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($Hrm->date_start)) }}</td>
                                    <td>{{ $Hrm->department->name }}</td>
                                    <td>
                                        @php
                                             echo $applicationModel->getCountDay($Hrm->user_id).' '.'Ngày' ;
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                          echo $applicationModel->totalBackRest($Hrm->user_id , $Hrm->date_start);
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="chart__statistical--gt bg-white box_shadow_human">
                        <div class="title__chart-year">
                            <div class="row border-bottom  py-2">
                                <div class="col-md-10 pr-0">
                                    <div class="title__chart-gt text-dark font-weight-bold pl-3 py-2">
                                        Biểu đồ thống kê nhân sự gia nhập công ty theo tháng
                                    </div>
                                </div>
                                <div class="col-md-2 pl-0 d-flex align-items-center justify-content-center">
                                    <span class="ft-size-content d-flex align-items-center text-dark font-weight-bold">Chọn năm</span>
                                    <div class="form-statistical ml-2">
                                        <select class=" w-100 py-0 border-form-statistical py-1 change_chart_year"
                                                id="exampleFormControlSelect1">
                                            <option hidden selected>Select</option>
                                            <option value="Overall">All Time</option>
                                            <option value="Last Year">Last Year</option>
                                            <option value="This Year">This Year</option>
                                            {{--                                             <option value="Customize">Customize</option>--}}
                                        </select>
                                        <div class="date mt-2 d-none">
                                            <div class="box__cus d-flex">
                                                <input type="date" class="get_value_date">
                                                <input type="date" class="get_value_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box__chart-gt py-2 boxHtml__chart-year">
                            @include('dashboard.humanResource.chart_year' , compact('listHrmMonthArray' , 'countStatusHrm'))
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(() => {
            $('.change_chart_year').on('change', () => {
                const value = $('.change_chart_year').val();
                if (value === 'Customize') {
                    $('.get_value_date').on('change', (e) => {
                        console.log(e.target.value)
                    })
                    $('.date').removeClass('d-none')
                    $('.date').addClass('d-block')
                } else {
                    $('.date').removeClass('d-block')
                    $('.date').addClass('d-none')
                    const getDate = $('.get_date_time').val();
                    let data = {value: value, getDate: getDate}
                    $.ajax({
                        url: "{{ route('web.human-resources.filterYearChart') }}",
                        method: 'GET',
                        data: data,
                        dataType: 'html',
                        success: function success(data) {
                            $('.boxHtml__chart-year').html(data)
                        }
                    })
                }
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('.blade__search--banking').css('display', 'none');
            $('#data__banking').click(function () {
                $('.blade__search--banking').removeClass('d__none--search')
                $('.blade__search--banking').css('display', 'block');
                $.ajax({
                    url: "{{ route('web.human-resources.filterYearChart') }}",
                    method: 'GET',
                    data: data,
                    dataType: 'html',
                    success: function success(data) {
                        $('.boxHtml__chart-year').html(data)
                    }
                })
            })
        })
    </script>
    {{--    {{ add_banking }}--}}

@endsection

