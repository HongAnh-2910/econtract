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
    <div class="subscription__panel my-4 completed__option--wrapper">
        <h2 class="subscription__option--completed">Cảm ơn bạn đã đăng ký dịch vụ của chúng tôi</h2>
        <div class="mb-2">Một email đã được gửi bên ban quản trị dự án, chúng tôi sẽ phản hồi đến bạn sớm nhất có thể.</div>
        <fieldset class="subscription__option--info text-left">
            <legend>Thông tin gói cước</legend>
            <div class="mb-2">- Tên gói cước: <span class="text-danger font-weight-bold">{{$subType->name}}</span></div>
            <div class="">{!! $subType->description !!}</div>
            <div class="">- Thời hạn gói: <span class="text-danger font-weight-bold">0{{$subscription->duration_package}} năm</span></div>
        </fieldset>
        <div class="mt-2">
            <a href="{{route('dashboard')}}" class="btn btn-primary"><i class="fas fa-angle-double-left"></i>&nbsp;Trang chủ</a>
        </div>
    </div>
@endsection
