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
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    @include('components.apple-meta')
    @laravelPWA
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>

<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">

    {{-- <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div> --}}

    @inertia

    {{-- <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script> --}}

</body>
