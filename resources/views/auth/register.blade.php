@extends('layouts.auth')
@section('content')
    <div class="right-container-content">
        <div class="">
            <h4 class="register-title">{{ __('Đăng ký') }}</h4>
            <p class="register-description">Chào mừng bạn đến với OneSign.vn.</p>
            <p class="register-description"> Bạn chưa có tài khoản? <a href="/login">Đăng nhập ngay</a></p>
            @if (config('app.isDisableRegister'))
                <h5>Tính năng bị hạn chế</h5>
            @else
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    {{-- FullName --}}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Email --}}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Password --}}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Confirm Password --}}
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="password_confirmation" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Password Confirmation" required autocomplete="new-password">

                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    {{-- Remember Me --}}
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label remember-me" for="remember">
                                    {{ __('Ghi nhớ') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Button Submit --}}
                    <div class="form-group row mb-0">
                        <div class="col-md-6 ">
                            <button class=" btn mt-3 auth__button--text text-decoration-none overflow-hidden">
                                {{ __('Đăng ký tài khoản') }}
                            </button>
                            {{-- @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif --}}
                        </div>
                    </div>
                </form>
            @endif
            @include('auth.social-login')
        </div>
    </div>
@endsection
