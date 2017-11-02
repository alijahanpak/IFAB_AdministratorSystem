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
<style>
    table,td,th{
        border:1px solid #333;
        color: #000000;
        font-size: x-small;
    }
    thead{
        font-size: small;

    }
    .x-small-font{
        font-size: x-small;
    }
    .left-details{
        min-width: 100px;
        margin-left: -15px;
    }
    .left-details-money{
        min-width: 50px;
        margin-left: 0px;
    }
</style>
<body class="BNazanin">
    <div class="row small-font">
        <div class="float-right">
            <div class="text-center">
                <img src="{{ asset('pic/ir-logo.jpg') }}" width="200px" height="100px">
            </div>
        </div>
        <div style="width: 650px;padding-top:50px;">
            <div class="text-center">
                <p class="BTitrBold">{{ $options->title }}</p>
                <p>سال مالی - <span> 1396 </span></p>
            </div>
        </div>
        <div style="margin-top: -75px;" class="float-left">
            <p class="left-details">تاریخ : <span> 1396/08/09 </span></p>
        </div>
    </div>
    <div class="float-left">
        <p class="x-small-font left-details-money">مبلغ به <span> (میلیون ریال) </span></p>
    </div>
        @yield('content')
    <script src="{{ asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/foundation.js') }}"></script>
    <script src="{{ asset('js/key.js') }}"></script>
</body>
</html>