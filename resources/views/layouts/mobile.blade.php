<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('favicon.png') }}">
    @include('components.apple-meta')
    @laravelPWA
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>

<body>

    {{-- <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div> --}}

    @inertia

    {{-- <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/custom.js"></script> --}}
    {{-- @include('components.popups') --}}
    <div id="menu-install-pwa-android" class="menu menu-box-bottom menu-box-detached rounded-l"
        style="width:90%;margin:0 auto;background:#f9f9f9">
        <div class="boxed-text-l mt-4 pb-3">
            <img class="rounded-l mb-3" src="{{ asset('/images/icons/128.png') }}" alt="img" width="128"
                style="margin: 0 auto">
            <h4 class="mt-3">Add Affirm on your Home Screen</h4>
            <p>
                Install Affirm on your home screen, and access it just like a regular app. It really is that simple!
            </p>
            <a href="#"
                class="pwa-install btn btn-s rounded-s shadow-l text-uppercase font-900 bg-highlight mb-2">Add to Home
                Screen</a><br>
            <a href="#"
                class="pwa-dismiss close-menu color-gray-dark text-uppercase font-900 opacity-60 font-10 pt-2">Maybe
                later</a>
            <div class="clear"></div>
        </div>
    </div>
</body>
