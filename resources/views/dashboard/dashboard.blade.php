@extends('layouts.dashboard', ['key' => 'dashboard'])
@section('content')
    <div id="content" class="container-fluid">
        <div class="title-account">
            <div class="col-md-12 pb-2">
                <h2 class="py-3 mb-0 font-bold">Tổng quan</h2>
                <div class="box-cat-dashboard">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <div class=" px-3 box-1 py-3 d-flex align-items-center justify-content-between rounded"
                                style="background-color: #4E3AC0;">
                                <div class="box-1.1 d-flex align-items-center">
                                    <img class="img-fluid" src="{{ asset('images/Group.png') }}">
                                    <span class="text-white ft-size pl-2">Chờ tôi ký</span>
                                </div>
                                <span
                                    class="d-inline-block text-white ft-size-01 text-right">{{ $statusContracts['wait_approval'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class=" px-3 box-1 py-3 d-flex align-items-center justify-content-between rounded"
                                style="background-color: #FAAE30;">
                                <div class="box-1.1 d-flex align-items-center">
                                    <img class="img-fluid" src="{{ asset('images/Vector (2).png') }}">
                                    <span class="text-white ft-size pl-1 pt-2">Đã bị hủy</span>
                                </div>
                                <span
                                    class="d-inline-block text-white ft-size-01 text-right">{{ $statusContracts['canceled'] ?? 0 }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class=" px-3 box-1 py-3 d-flex align-items-center justify-content-between rounded"
                                style="background-color: #50CC4F;">
                                <div class="box-1.1 d-flex align-items-center">
                                    <i class="far fa-check-circle text-white" style="font-size: 20px"></i>
                                    <span class="text-white ft-size pl-2">Hoàn thành</span>
                                </div>
                                <span
                                    class="d-inline-block text-white ft-size-01 text-right">{{ $statusContracts['success'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="open-file bg-white mx-3 rounded mt-3">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="file d-inline-block py-3 ">
                        <div class="img-click-file">
                            <label for="actual-btn" class="cursor">
                                <img src="{{ asset('images/Vector.png') }}">
                            </label>
                            <input accept="image/png,image/jpeg" type="file" id="actual-btn" hidden />
                        </div>
                        <div class="dropdown">
                            <button class="text-white btn btn-danger px-4 cursor dropdown-toggle"
                                style="background-color: #2508C2; border: none;" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div>Bắt đầu ngay</div>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('web.contracts.create', ['type' => 'personal']) }}">Nội
                                    bộ</a>
                                <a class="dropdown-item" href="{{ route('web.contracts.create', ['type' => 'company']) }}">Khách
                                    hàng</a>
                            </div>
                        </div>
                        {{-- <a href="{{ route('contract.add', ['type' => 'personal']) }}" class="text-white btn btn-danger px-4 cursor" for="actual-btn"
                            style="background-color: #2508C2; border: none;">
                            Bắt đầu ngay
                        </a> --}}
                        <p class="text-secondary mb-0"><span class="text-danger">* </span>Định dạng được hỗ trợ: .pdf</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mx-3 mt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="box-setting mb-4 box-shadow bg-white d-flex px-3 rounded align-items-center py-3">
                        <div class="img mr-3">
                            <img class="img-fluid" src="{{ asset('images/Vector (3).png') }}">
                        </div>
                        <div class="text-right-content">
                            <a href="{{ route('web.signature-list.index') }}">
                                <span class="font-weight-bold ft-size-18" style="color: #29398C;">Tạo chữ ký của bạn</span>
                            </a>
                            <p class="mb-0 ft-size-content pt-1">Vẽ tay chữ ký và dùng nó để ký trên các tài liệu</p>
                        </div>
                    </div>
                    <div class="box-setting mb-4 box-shadow bg-white d-flex px-3 rounded align-items-center py-3">
                        <div class="img mr-3">
                            <img class="img-fluid" src="{{ asset('images/Vector (4).png') }}">
                        </div>
                        <div class="text-right-content ">
                            <a href="{{ route('web.profile.index', \Illuminate\Support\Facades\Auth::id()) }}">
                                <span class="font-weight-bold ft-size-18" style="color: #29398C;">Cập nhật thông tin cá
                                    nhân</span>
                            </a>
                            <p class="mb-0 ft-size-content pt-1">Hình ảnh đại diện, tên hiển thị, đổi mật khẩu</p>
                        </div>
                    </div>
                    <div class="box-setting mb-3 box-shadow bg-white d-flex px-3 rounded align-items-center py-3">
                        <div class="img mr-3">
                            <img class="img-fluid" src="{{ asset('images/Vector (5).png') }}">
                        </div>
                        <div class="text-right-content ">
                            <a href="{{ route('web.profile.index') }}">
                                <span class="font-weight-bold ft-size-18" style="color: #29398C;">Cài đặt tài khoản</span>
                            </a>
                            <p class="mb-0 ft-size-content pt-1">Định dạng ngày tháng năm, chính sách bảo mật, điều
                                khoản....</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="box-statistical rounded bg-white px-4 box-shadow">
                        <div class="text-statistical  pt-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="">
                                        <span class="font-weight-bold ft-size-18" style="color: #29398C;">Thống kê hợp đồng
                                            theo tháng</span>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="select-statistical d-flex justify-content-between">
                                        <span class="ft-size-content d-flex align-items-center">Chọn năm</span>
                                        <div class="form-statistical">
                                            <select class=" w-100 py-0 border-form-statistical"
                                                id="exampleFormControlSelect1">
                                                <option>Tổng thể</option>
                                                {{-- <option>Last Months</option> --}}
                                                {{-- <option>Tổng thể</option> --}}
                                                {{-- <option>Tổng thể</option> --}}
                                            </select>
                                        </div>
                                        <a href="">
                                            <i class="fas fa-redo text-secondary"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="chart-profile-visit"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var arrayContracts = {!! json_encode($contracts) !!};
        @php
        @endphp
        var dataChart = [];
        var t = 0;

        dataChart[t++] = arrayContracts['Jan'] ?? 0;
        dataChart[t++] = arrayContracts['Feb'] ?? 0;
        dataChart[t++] = arrayContracts['Mar'] ?? 0;
        dataChart[t++] = arrayContracts['Apr'] ?? 0;
        dataChart[t++] = arrayContracts['May'] ?? 0;
        dataChart[t++] = arrayContracts['Jun'] ?? 0;
        dataChart[t++] = arrayContracts['Jul'] ?? 0;
        dataChart[t++] = arrayContracts['Aug'] ?? 0;
        dataChart[t++] = arrayContracts['Sep'] ?? 0;
        dataChart[t++] = arrayContracts['Oct'] ?? 0;
        dataChart[t++] = arrayContracts['Nov'] ?? 0;
        dataChart[t++] = arrayContracts['Dec'] ?? 0;

        var optionsProfileVisit = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled: false
            },
            chart: {
                type: 'bar',
                height: 300
            },
            fill: {
                opacity: 1
            },
            plotOptions: {},
            series: [{
                name: 'contracts',
                data: dataChart
                // data: [12, 20, 35, 20, 10, 20, 30, 20, 10, 20, 30, 20]
            }],
            colors: '#435ebe',
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            },
        }
        let optionsVisitorsProfile = {
            series: [70, 30],
            labels: ['Male', 'Female'],
            colors: ['#435ebe', '#55c6e8'],
            chart: {
                type: 'donut',
                width: '100%',
                height: '350px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '30%'
                    }
                }
            }
        }

        var optionsEurope = {
            series: [{
                name: 'series1',
                data: [310, 800, 600, 430, 540, 340, 605, 805, 430, 540, 340, 605]
            }],
            chart: {
                height: 80,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            colors: ['#5350e9'],
            stroke: {
                width: 2,
            },
            grid: {
                show: false,
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                    "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                    "2018-09-19T06:30:00.000Z", "2018-09-19T07:30:00.000Z", "2018-09-19T08:30:00.000Z",
                    "2018-09-19T09:30:00.000Z", "2018-09-19T10:30:00.000Z", "2018-09-19T11:30:00.000Z"
                ],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    show: false,
                }
            },
            show: false,
            yaxis: {
                labels: {
                    show: false,
                },
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        let optionsAmerica = {
            ...optionsEurope,
            colors: ['#008b75'],
        }
        let optionsIndonesia = {
            ...optionsEurope,
            colors: ['#dc3545'],
        }



        var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
        var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)
        var chartEurope = new ApexCharts(document.querySelector("#chart-europe"), optionsEurope);
        var chartAmerica = new ApexCharts(document.querySelector("#chart-america"), optionsAmerica);
        var chartIndonesia = new ApexCharts(document.querySelector("#chart-indonesia"), optionsIndonesia);

        chartIndonesia.render();
        chartAmerica.render();
        chartEurope.render();
        chartProfileVisit.render();
        chartVisitorsProfile.render()
    </script>
@endsection
