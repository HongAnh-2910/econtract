@extends('layouts.dashboard')
@section('content')
    @if (session('success'))
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif
    <div class="subscription__panel">
        <div class="subscription__header">
            <div class="subscription__header--image">
                <img src="{{ asset('images/subscription_image.png') }}" alt="subscription image" />
            </div>
            <div class="subscription__header--text">
                Tài khoản của Quý khách đang thuộc tài khoản MIỄN PHÍ. Vui lòng liên hệ đội ngũ hỗ trợ của <a class="text-primary" href="https://onesign.vn">Onesign.vn</a> để kích hoạt tính năng kí số.
            </div>
            <div class="subscription__header--buttons">
                <a href="#table__subscription--package" class="btn__subscription--package">Đăng ký tư vấn</a>
                <a href="#" class="btn__chat--support">Chat với support</a>
            </div>
        </div>
        <div class="subscription__packages">
            <div class="subscription__package--title">Các gói cước HOT</div>
        </div>
        <div class="table__packages--wrapper container-fluid">
        <div class="col-md-12 px-0">
            <div class="table-responsive">
                <table id="table__subscription--package" class="table table__packages">
                    <thead>
                        <tr>
                            <th scope="col" class="text-white text-center">STT</th>
                            <th scope="col" class="text-white text-center">Tên gói</th>
                            <th scope="col" class="text-white text-center" style="width: 300px;">Cấu hình gói dịch vụ</th>
                            <th scope="col" class="text-white text-center">01 năm</th>
                            <th scope="col" class="text-center text-white">02 năm</th>
                            <th scope="col" class="text-center text-white">03 năm</th>
                            <th scope="col" class="text-center text-white"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($subPackages as $key => $subPackage)
                            <tr class="{{($key+1) % 2 == 0 ? 'even' : ''}}">
                                <th class="text-center align-middle">{{ $key+1 }}</th>
                                <td class="text-center">{{$subPackage->name}}</td>
                                <td class="text-left">{!! $subPackage->description !!}</td>
                                <td class="text-center">{{number_format($subPackage->first_duration)}}</td>
                                <td class="text-center">{{number_format($subPackage->second_duration)}}</td>
                                <td class="text-center">{{number_format($subPackage->third_duration)}}</td>
                                <td>
                                    <a data-toggle="modal" data-sub-id="{{$subPackage->id}}" data-name="{{$subPackage->name}}" data-target="#subscription__package" class="btn__subscription--item" href="#">Đăng ký</a>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('dashboard.subscription.create_package')
            </div>
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.btn__subscription--item').on('click', function () {
                $('.popup__subscription--information').text('Gói đăng ký: '+$(this).data('name'));
                $('.input__subscription--name').val($(this).data('name'));
                $(this).addClass('btn__subitem--active');
                $('.subscription__option--type').val($(this).data('sub-id'));
            });

            $(document).on('click', function (e) {
                var btn = '.btn__subscription--item';
                var modalXl = '#subscription__package .modal-dialog';
                var btnClose = '.btn__close--subscription';

                if((! $(e.target).closest(btn).length && ! $(e.target).closest(modalXl).length) || $(e.target).closest(btnClose).length) {
                    $('.btn__subscription--item').removeClass('btn__subitem--active');
                }
            });
        });
    </script>
@endsection
