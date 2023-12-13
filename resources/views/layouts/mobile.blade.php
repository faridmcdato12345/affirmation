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
    <link rel="manifest" href="{{ public_path('site.webmanifest') }}">
    @include('components.apple-meta')
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>

<body>
    @inertia
    <div id="menu-install-pwa-android" class="menu menu-box-bottom menu-box-detached rounded-md bg-white"
        style="width:95%; margin:0 auto; background:#f9f9f9">
        <div class="boxed-text-l mt-4 pb-3">
            <img class="rounded-l mb-3" src="{{ asset('/images/icons/128.png') }}" alt="img" width="128"
                style="margin: 0 auto">
            <h4 class="mt-3">Add Affirm on your Home Screen</h4>
            <p>
                Install Affirm on your home screen, and access it just like a regular app. It really is that simple!
            </p>
            <a href="#"
                class="pwa-install btn btn-s rounded-s shadow-l text-uppercase font-900 bg-highlight mt-2.5 block w-full py-2.5 px-4">
                Add to Home Screen
            </a><br>
        </div>
    </div>

    <!-- Install instructions for iOS -->
    <div id="menu-install-pwa-ios" class="menu menu-box-bottom menu-box-detached rounded-md">
        <div class="boxed-text-xl mt-4 pb-3">
            <img class="rounded-l mb-3" src="{{ asset('/images/icons/128.png') }}" alt="img" width="128"
                style="margin: 0 auto">
            <h4 class="mt-3">Add Affirm on your Home Screen</h4>
            <p class="mb-0 pb-0">
                Install Affirm, and access it like a regular app. Open your Safari menu and tap "Add to Home Screen".
            </p>
            <div class="clearfix pt-3"></div>
            <a href="#"
                class="pwa-dismiss close-menu color-highlight text-uppercase font-700 mt-1 mb-2 block">Maybe later</a>
        </div>
    </div>
</body>
