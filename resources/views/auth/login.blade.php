@extends('layouts.auth')
@section('content')
    <div class="right-container-content">
        <div class="">
            <h4 class="register-title">{{ __('Đăng nhập') }}</h4>
            <p class="register-description">Chào mừng bạn đến với OneSign.vn.</p>
            <p class="register-description"> Bạn chưa có tài khoản? <a href="/register">Tạo tài khoản ngay</a></p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                {{-- User Name --}}
                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="email" pattern="[a-zA-Z0-9.-_]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" placeholder="User name" value="{{ old('email') }}" required
                               autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- Password --}}
                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               placeholder="Password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                {{-- Remember Me --}}
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label auth__text--fontfamily" for="remember">
                                {{ __('Ghi nhớ') }}
                            </label>
                        </div>
                    </div>
                    {{-- Forgot Password --}}
                    <div class="col-6">
                        <a class="auth__text--fontfamily" href='{{ route('password.request') }}' style="color: #F26D21;">
                            {{ __('Tìm lại mật khẩu?') }}
                        </a>
                    </div>
                </div>
                {{-- Button Submit --}}
                <div class="form-group row mb-0">
                    <div class="col-md-6">
                        <button class=" btn mt-3 text-center auth__button--text text-decoration-none overflow-hidden auth__text--fontfamily">
                            {{ __('Đăng nhập') }}
                        </button>
                    </div>
                </div>
            </form>
            @include('auth.social-login')
        </div>
    </div>
@endsection
