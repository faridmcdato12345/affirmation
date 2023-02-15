@extends('layouts.mobile')

@section('content')
<div class="container">

<div id="page">

    <div class="page-content pb-0">

        <div data-card-height="cover" class="card">
            <div class="card-top notch-clear">
                <div class="d-flex">
                    <a href="#" data-back-button class="me-auto icon icon-m"><i class="font-14 fa fa-arrow-left color-theme"></i></a>
                    <a href="#" data-toggle-theme class="show-on-theme-light ms-auto icon icon-m"><i class="font-12 fa fa-moon color-theme"></i></a>
                    <a href="#" data-toggle-theme class="show-on-theme-dark ms-auto icon icon-m"><i class="font-12 fa fa-lightbulb color-yellow-dark"></i></a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mt-5 ms-3 me-3 mb-5 alert alert-small rounded-s shadow-xl bg-red-dark" role="alert">
                    <span><i class="fa fa-times"></i></span>
                    @foreach ($errors->all() as $error)
                        <strong>
                            {{ $error }}
                        </strong><br>
                    @endforeach
                    <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card-center">
                    <div class="ps-5 pe-5">
                        <h1 class="text-center font-800 font-40 mb-1">Sign In</h1>
                        <p class="color-highlight text-center font-12">Let's get you logged in</p>

                        <div class="input-style no-borders has-icon validate-field">
                            <i class="fa fa-user"></i>
                            <input type="email" class="form-control validate-email @error('password') is-invalid @enderror" id="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="color-blue-dark font-10 mt-1">Email</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>

                        <div class="input-style no-borders has-icon validate-field mt-4">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control validate-password" id="password" placeholder="Password" name="password" required autocomplete="current-password">
                            <label for="password" class="color-blue-dark font-10 mt-1">Password</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mt-4 mb-4">
                            <div class="w-50 font-11 pb-2 text-start"><a href="/register">Create Account</a></div>
                            @if (Route::has('password.request'))
                                    <div class="w-50 font-11 pb-2 text-end"><a href="{{ route('password.request') }}">Forgot Credentials</a></div>
                                @endif
                        </div>

                        <button type="submit" class="back-button btn btn-full btn-m shadow-large rounded-sm text-uppercase font-700 bg-highlight mx-auto">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

