@extends('layouts.auth')

@section('content')
    <div class="right-container-content">
        <div class="">
            <h4 class="register-title">{{ __('Set new password') }}</h4>
            @include('common.errors-message')
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->get('email') }}">
                {{-- User Name --}}
                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password" placeholder="New password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                {{-- Password --}}
                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required autocomplete="new-password" placeholder="Confirm new pass">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                {{-- Remember Me --}}

                {{-- Button Submit --}}
                <div class="form-group row mb-0">
                    <div class="col-md-6 ">
                        <button class=" btn mt-2 auth__button--text text-decoration-none overflow-hidden">
                            {{ __('Reset password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
