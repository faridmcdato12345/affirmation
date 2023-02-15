@extends('layouts.mobile')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="page-content pb-0">
        <div data-card-height="cover" class="card">
            <div class="card-top notch-clear">
                <div class="d-flex">
                    <a href="#" data-back-button class="me-auto icon icon-m"><i class="font-14 fa fa-arrow-left color-theme"></i></a>
                    <a href="#" data-toggle-theme class="show-on-theme-light multumesc-auto icon icon-m"><i class="font-12 fa fa-moon color-theme"></i></a>
                    <a href="#" data-toggle-theme class="show-on-theme-dark multumesc-auto icon icon-m"><i class="font-12 fa fa-lightbulb color-yellow-dark"></i></a>
                </div>
            </div>
            <div class="card-center">
                <div class="p-4">
                    <h1 class="text-center font-800 font-40 mb-1">Forgot</h1>
                    <p class="color-highlight text-center font-12">
                        Recover your Account
                    </p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="input-style no-borders has-icon validate-field">
                            <i class="fa fa-at"></i>
                            <input type="email" class="form-control validate-email" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="color-highlight">Email</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                    

                        <div class="d-flex mt-4 mb-2">
                            <div class="w-50 font-11 pb-2 text-start"><a href="/login">Login Account</a></div>
                            <div class="w-50 font-11 pb-2 text-end"><a href="/register">Create Account</a></div>
                        </div>

                        <button type="submit" class="back-button btn btn-full btn-m shadow-large rounded-sm text-uppercase font-900 bg-highlight">Reset Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
