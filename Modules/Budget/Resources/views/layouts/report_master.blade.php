<!doctype html>
<html class="no-js" lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>گزارش</title>
    <link rel="icon" type="image/png" href="{{ asset('pic\logom.jpg') }}">
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/key.css') }}">
</head>
<body class="body-color BYekan">
    <div class="grid-x">
        <div class="medium-2 small-font">
            <div class="text-center">
                <img src="{{ asset('pic/ir-logo.png') }}" width="32px" height="32px">
                <p>اداره کل میراث فرهنگی، صنایع دستی و گردشگری</p>
                <p>استان همدان</p>
            </div>
        </div>
        <div class="medium-8">
        </div>
        <div class="medium-2">

        </div>
    </div>
        @yield('content')
    <script src="{{ asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/foundation.js') }}"></script>
    <script src="{{ asset('js/key.js') }}"></script>
</body>
</html>