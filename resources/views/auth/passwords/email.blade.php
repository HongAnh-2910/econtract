@extends('layouts.auth')

@section('content')
    <div class="right-container-content">
        <div class="">
            <div class="">
                <h4 class="register-title">Quên mật khẩu?</h4>
                <p class="register-description">
                    Quay lại <a href="/login">đăng nhập</a>
                </p>
{{--                {{$message}}--}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    {{-- User Name --}}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Nhập email của bạn" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 ">
                            <button class=" btn auth__button--text text-decoration-none overflow-hidden">
{{--                                {{ __('Confirm') }}--}}
                                Xác nhận
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
