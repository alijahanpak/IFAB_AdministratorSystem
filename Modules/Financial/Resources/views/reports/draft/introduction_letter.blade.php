<!doctype html>
<html class="no-js" lang="en" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>نامه معرفی</title>
        <link rel="icon" type="image/png" href="{{ asset('pic\logom.jpg') }}">
        <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font.css') }}">
        <link rel="stylesheet" href="{{ asset('foundation-icons/foundation-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/key.css') }}">
        <style>
            .number_ltr {
                direction: ltr!important;
                unicode-bidi: embed;
            }

            tbody{
                border:none !important;
            }

            /* remove padding */
            td, th ,tr {
                border:none !important;
            }
        </style>
    </head>
    <body class="BZar">
        <div style="padding-top: 120px;" class="grid-x padding-l">
            <div class="large-12 padding-lr size-12">
                <p class="BTitrBold">ریاست محترم {{ $checkFormat['cfBank'] }}</p>
                <p style="margin: 0px">باسلام</p>
                <p style="line-height: 2.5em; text-indent: 2em" class="text-justify">احتراما به پیوست یک فقره چک به شماره <span class="gray-colors">{{$printHistory['phIdNumber']}}</span> مورخ <span class="gray-colors">{{$printHistory['phDate']}}</span> از حساب <span class="gray-colors">{{$checkFormat['cfAccountNumber']}}</span> به مبلغ <span class="gray-colors">{{number_format($printHistory['phIdNumber'] , 0 , "." ,",")}}</span> ریال به حروف <span class="gray-colors">{{$printHistory['amountText']}}</span> ریال در وجه <span class="gray-colors">{{$printHistory['phPayTo']}}</span> بابت <span class="gray-colors">{{$printHistory['phFor']}}</span> ارسال می گردد. خواهشمند است دستور فرمایید نسبت به پرداخت آن اقدام لازم مبذول نمایند.</p>
            </div>
            <table style="width: 100%" class="unstriped size-12">
                <tbody>
                <tr>
                    <td class="text-center">
                        @if(!empty($printHistory['phSecondVerifierName']))
                            <p class="BTitrBold" style="margin: 5px">{{ $printHistory['phSecondVerifierName'] }}</p>
                            <p class="BTitrBold" style="margin: 5px">{{ $printHistory['phSecondVerifierRole'] }}</p>
                        @endif
                    </td>
                    <td class="text-center">
                        <p class="BTitrBold" style="margin: 5px">{{ $printHistory['phVerifierName'] }}</p>
                        <p class="BTitrBold" style="margin: 5px">{{ $printHistory['phVerifierRole'] }}</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>


