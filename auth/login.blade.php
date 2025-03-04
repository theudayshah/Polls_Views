@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-start vh-100 my-5">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card-body">
                <h3 class="fw-bold text-center text-primary">{{ __('Login to PollCraft') }}</h3>
                <p class="text-center text-muted">Enter your credentials to continue</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email">
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Enter your password">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        {{--
                    @if (Route::has('password.request'))
                        <a class="text-primary text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif 
                    --}}
                    </div>

                    <div class="mb-3">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">
                        {{ __('Login') }}
                    </button>
                </form>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('google.login') }}" class="btn btn-light d-flex align-items-center justify-content-center flex-grow-1 shadow-sm py-2">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" width="22" class="me-2">
                        Google
                    </a>
                    <a href="{{ route('x.login') }}" class="btn btn-dark d-flex align-items-center justify-content-center flex-grow-1 shadow-sm py-2">
                        Login with X
                    </a>
                </div>
                
                

                <p class="text-center mt-3">Don't have an account? <a href="{{ route('register') }}"
                        class="text-primary fw-bold">Sign Up</a></p>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
