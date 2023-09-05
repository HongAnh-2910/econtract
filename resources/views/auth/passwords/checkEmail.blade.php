@extends('layouts.auth')

@section('content')
    <div class="right-container-content">
        <div class="">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <h4 class="register-title">{{ __('Bạn đã nhận được một email') }}</h4>
                @error('email')
                <span class="">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <p class="register-description ">Chúng tôi đã gửi một email đến <a class="text-primary">{{$email}}</a> một liên kết để làm mới mật khẩu.</p>
                <input id="email" type="hidden" @error('email') is-invalid @enderror name="email" value="{{$email}}" required autocomplete="email">
                <div class="form-group row mb-0">
                    <div class="col-md-6 ">
                        {{--                        <button class=" btn auth__button--text text-decoration-none overflow-hidden mt-2 bg-white border">--}}
                        <button type="submit" class="btn auth__button--text text-decoration-none overflow-hidden">
                        <span class="text-dark">
{{--                                  {{ __('Sent again') }}--}}
                            Gửi lại
                        </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
