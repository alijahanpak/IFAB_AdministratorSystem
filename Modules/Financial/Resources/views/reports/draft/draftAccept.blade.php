<!doctype html>
<html class="no-js" lang="en" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>حواله سند</title>
        <link rel="icon" type="image/png" href="{{ asset('pic\logom.jpg') }}">
        <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font.css') }}">
        <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/key.css') }}">
    </head>
    <body class="BZar">
        <div class="grid-x">
            <div class="large-12">
                <p class="size-12">شماره حواله : <span style="direction: rtl;">{{$draftInfo['dLetterNumber']}}</span></p>
                <p style="margin-top: -10px;" class="size-12">تاریخ : <span>{{$draftInfo['dLetterDate']}}</span></p>
            </div>
        </div>
        <div style="margin-top: -60px;" class="grid-x">
            <div class="large-12 text-center">
                <div>
                    <div class="text-center">
                        <img src="{{ asset('pic/ir-logo.jpg') }}" width="200px" height="100px">
                        <p style="margin-top: 15px;">(( حواله ))</p>
                    </div>
                </div>
            </div>
            <div class="large-12 padding-lr">
                <p class="BTitrBold">ذیحساب محترم اداره کل</p>
                <p>باسلام</p>
                <p style="line-height: 2.5em;" class="text-justify"> به استناد مواد 52 و 53 قانون محاسبات عمومی کشور مبلغ <span class="gray-colors">{{number_format($draftInfo['dAmount'])}}</span> ریال بابت  <span class="gray-colors">{{$draftInfo['dFor']}}</span> در وجه <span class="gray-colors">{{$draftInfo['dPayTo']}}</span> پرداخت نمایید. </p>
            </div>
            <div class="large-12 padding-lr">
                <div class="grid-x">
                    <div class="large-6">

                    </div>
                    <div style="margin-right: 50%" class="large-6 text-center BTitrBold size-10">
                        <p>{{$verifierName}}</p>
                        <p style="margin-top: -10px;" class="text-center">{{$verifierRole}}</p>
                        <img style="margin-top: -80px;z-index: 99;" src="{{$draftInfo['verifier'][0]['signature']['sPath']}}" width="150px" height="150px">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


