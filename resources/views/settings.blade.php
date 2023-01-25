@extends('layouts.mobile')

@section('content')
	<div class="page-content header-clear-medium">

        @if ($errors->any())
            <div class="mt-3 ms-3 me-3 mb-5 alert alert-small rounded-s shadow-xl bg-red-dark" role="alert">
                <span><i class="fa fa-times"></i></span>
                @foreach ($errors->all() as $error)
                    <strong>
                        {{ $error }}
                    </strong><br>
                @endforeach
                <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif
        @if (session('alert'))
            <div class="mt-3 ms-3 me-3 mb-5 alert alert-small rounded-s shadow-xl bg-green-dark" role="alert">
                <span><i class="fa fa-check"></i></span>
                <strong>
                    {{ session('alert') }}
                </strong><br>
                <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif

        <div class="card card-style">
            {{-- <a data-menu="settings-pane" href="#" class="d-flex m-3"> --}}
            <a href="#" class="d-flex m-3">
                <div><i class="me-3 rounded-circle font-40 fa-solid fa-user-circle"></i></div>
                <div>
                    <h3 class="mt-2 mb-0 font-700">Account</h3>
                    <p class="font-12 mt-n1 mb-0 pb-0"></p>
                </div>
                {{-- <div class="ms-auto mt-1 pt-1"><i class="fa fa-chevron-right color-theme opacity-30"></i></div> --}}
            </a>
        </div>

        <div class="card card-style">
            <div class="content my-0">
                <div class="list-group list-custom-small">
                    <a data-toggle-theme data-trigger-switch="switch-21" href="#">
                        <i class="fa font-14 fa-lightbulb rounded-s bg-yellow-dark"></i>
                        <span>Dark Mode</span>
                        <div class="custom-control scale-switch ios-switch">
                            <input data-toggle-theme type="checkbox" class="ios-input" id="switch-21">
                            <label class="custom-control-label" for="switch-21"></label>
                        </div>
                        <i class="fa fa-chevron-right opacity-30"></i>
                    </a>
                    <a data-menu="menu-report" href="#">
                        <i class="fa font-14 fa-bug rounded-s bg-red-dark"></i>
                        <span>Report A Bug</span>
                        <i class="fa fa-chevron-right opacity-30"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card card-style">
            <div class="content my-0">
                <div class="list-group list-custom-small">
                    <a data-menu="#" href="#" class="disabled">
                        <i class="fa font-14 fa-cog rounded-s bg-red-dark"></i>
                        <span>Subscription</span>
                        <i class="fa fa-chevron-right opacity-30"></i>
                    </a>
                    <a data-menu="#" href="#" class="disabled">
                        <i class="fa font-14 fa-tint rounded-s bg-blue-dark"></i>
                        <span>Referrals</span>
                        <i class="fa fa-chevron-right opacity-30"></i>
                    </a>
                    <a data-menu="#" href="#" class="disabled">
                        <i class="fa font-14 fa-brush rounded-s bg-green-dark"></i>
                        <span>Background Image</span>
                        <i class="fa fa-chevron-right opacity-30"></i>
                    </a>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type="submit">
                            <i style="margin-left: 0px;width: 30px;height: 30px;line-height: 30px;margin-top: 10px;text-align: center;float: left;margin-right: 10px;" class="fa font-14 fa-door-open rounded-s bg-magenta-dark"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                    <a data-menu="menu-delete" href="#">
                        <i class="fa font-14 fa-trash rounded-s bg-red-dark"></i>
                        <span>Delete Account</span>
                        <i class="fa fa-chevron-right opacity-30"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer card card-style">
            <a href="#" class="footer-title"><span class="color-highlight">Affirm</span></a>
            <p class="footer-text"><span>Made with <i class="fa fa-heart color-highlight font-16 ps-2 pe-2"></i> by Adam Toth Software</span><br>Proudly Canadian</p>
            <p class="footer-copyright">Copyright &copy; Enabled <span id="copyright-year">2017</span>. All Rights Reserved.</p>
        </div>

    </div>
@endsection

@section('popups')
<!-- menu-delete -->
	<div id="menu-delete" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-effect="menu-over" data-menu-height="300">
        <div class="menu-title mt-n1">
            <h1>Delete Account</h1>
			<p class="color-theme opacity-50">Are You Sure You Want To Delete Your Account?</p>
			<a href="#" class="close-menu"><i class="fa fa-times"></i></a>
		</div>
		<div class="content mb-0 mt-2">
            <form action="{{route('deleteUser')}}" method="POST">
                @csrf
                <div class="divider mb-3"></div>
                <p class="mb-3">
                    Confirm you want to delete your account by entering your password. This will delete your account, subscription data, and any other information stored.
                </p>
                <div class="input-style no-borders no-icon validate-field">
                    <input type="password" class="form-control validate-text" id="password" placeholder="Password" name="password">
                    <label for="password" class="color-highlight">Password</label>
                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                    <i class="fa fa-check disabled valid color-green-dark"></i>
                    <em>(required)</em>
                </div>
                <button type="submit" class="btn btn-l mx-auto rounded-sm btn-full bg-red-dark text-uppercase font-800">Delete Now</button>
            </form>
		</div>
	</div>
<!-- menu report -->
    <div id="menu-report" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-effect="menu-over" data-menu-height="300">
        <div class="menu-title mt-n1">
            <h1>Report A Bug</h1>
            <p class="color-highlight mt-1">Please describe the issue as best as possible.</p>
            <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
        </div>
        <div id="validator-text" class="disabled bg-red-dark content rounded-sm shadow-xl text-center line-height-xs py-3 text-uppercase font-700">Please enter your message!</div>

        <div class="card contact-form">
            <div class="content mb-0 mt-2">
                <form action="{{route('report')}}" method="POST">
                    @csrf
                    <fieldset>
                        <div class="form-field form-text">
                            <label class="contactMessageTextarea color-theme" for="contactMessageTextarea">Message:<span>(required)</span></label>
                            <textarea name="contactMessageTextarea" class="round-small" id="contactMessageTextarea" style="height:80px;"></textarea>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="btn btn-l mx-auto rounded-sm btn-full bg-red-dark text-uppercase font-800">Send Message</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection