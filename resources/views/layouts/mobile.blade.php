<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>{{ env('APP_NAME') }}</title>
<link rel="icon" type="image/png" sizes="128x128" href="{{ asset('favicon.png') }}">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
@include('components.apple-meta')
@laravelPWA
@vite(['resources/js/app.js'])
</head>

<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">

{{-- <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div> --}}

<div id="page" x-data>
	@if(Auth::check())
	<!-- header and footer bar go here-->
	<div class="header header-fixed header-logo-center">
		<a href="index.html" class="header-title">{{ env('APP_NAME') }}</a>
		<a href="#" class="back-button header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
		<a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>
	</div>
	<div id="footer-bar" class="footer-bar-1">
		@php
			$active = isset($active) ? $active : null;
		@endphp
		<a href="/" @class(["active-nav" => ($active === 'home')])><i class="fa fa-home"></i><span>Home</span></a>
		<a href="/categories" @class(["active-nav" => ($active === 'categories')])><i class="fa fa-star"></i><span>Categories</span></a>
		{{-- <a href="index-pages.html"><i class="fa fa-heart"></i><span>Pages</span></a>
		<a href="index-search.html"><i class="fa fa-search"></i><span>Search</span></a> --}}
		<a href="/settings" @class(["active-nav" => ($active === 'settings')])><i class="fa fa-cog"></i><span>Settings</span></a>
	</div>
	@endif

	<!--start of page content, add your stuff here-->
	@yield('content')

	{{-- popup card section --}}
	@include('components.popups')
	@yield('popups')
	<!--end of div id page-->
</div>

{{-- <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script> --}}
@yield('scripts')
</body>