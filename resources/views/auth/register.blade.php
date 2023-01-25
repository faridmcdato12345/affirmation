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

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card-center">
                    <div class="ps-5 pe-5">
                        <h1 class="text-center font-800 font-40 mb-1">Sign Up</h1>
                        <p class="color-highlight text-center font-12">Create an Account. It's free!</p>

                        <div class="input-style no-borders has-icon validate-field">
                            <i class="fa fa-user"></i>
                            <input type="name" name="name" class="form-control validate-name @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="Name" autofocus required autocomplete="name">
                            <label for="name" class="color-blue-dark font-10 mt-1">Name</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style no-borders has-icon validate-field mt-2">
                            <i class="fa fa-at"></i>
                            <input type="email" name="email" class="form-control validate-email @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                            <label for="email" class="color-blue-dark font-10 mt-1">Email</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style no-borders has-icon validate-field mt-2">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password" class="form-control validate-password" id="password" placeholder="Choose a Password" required>
                            <label for="password" class="color-blue-dark font-10 mt-1">Choose a Password</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style no-borders has-icon mt-2">
                            <i class="fa fa-lock"></i>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm your Password" required>
                            <label for="password_confirmation" class="color-blue-dark font-10 mt-1">Confirm your Password</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <p class="text-center font-12">Password must contain at least:
                            <br>8 characters
                            <br>one uppercase letter
                            <br>one lowercase letter
                            <br>one number
                            <br>one special character: @,$,!,%,*,?,&
                        </p>

                        <div class="text-center mb-5 mt-5">
                            <a href="/login" class="font-12">Already Registered? Sign in Here</a>
                        </div>

                        <button type="submit" class="back-button btn btn-full btn-m shadow-large rounded-sm text-uppercase font-900 bg-highlight mx-auto">Create Account</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

