<!doctype html>
<html class="no-js" lang="en" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>درخواست پرداخت</title>
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
        <div class="grid-x">
            <div class="large-12">
                <p style="z-index: 999;" class="size-12">شماره درخواست : <span class="number_ltr">{{$payRequestInfo['prLetterNumber']}}</span></p>
                <p style="margin-top: -10px;" class="size-12">تاریخ : <span>{{$payRequestInfo['prLetterDate']}}</span></p>
            </div>
        </div>
        <div style="margin-top: -45px;" class="grid-x">
            <div class="large-12 text-center">
                <div>
                    <div class="text-center">
                        <img style="z-index: 1;" src="{{ asset('pic/ir-logo.jpg') }}" width="170px" height="100px">
                        <p style="margin-top: 15px;">(( فرم تایید پرداخت ))</p>
                    </div>
                </div>
            </div>
        </div>
        <table style="width: 100%" class="unstriped">
            <tbody>
                <tr>
                    <td>
                        <span class="BTitrBold">واحد: </span>
                        <span class="BZar size-14">{{$payRequestInfo['prOfficeUnit']}}</span>
                    </td>
                    <td>
                        <span class="BTitrBold">پیمانکار: </span>
                        <span class="BZar size-14"> {{$payRequestInfo['contract']['executor']['eSubject']}}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="BTitrBold">شماره ثبت قرارداد: </span>
                        <span class="BZar size-14">{{$payRequestInfo['contract']['cLetterNumber']}}</span>
                    </td>
                    <td>
                        <span class="BTitrBold">تاریخ ثبت قرارداد: </span>
                        <span class="BZar size-14">{{$payRequestInfo['contract']['cLetterDate']}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="BTitrBold">شرح عملیات: </span>
                        <span class="BZar size-14">{{$payRequestInfo['prDescription']}}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="BTitrBold">درصد افزایش / کاهش حجم عملیات: </span>
                        <span class="BZar size-14">{{$payRequestInfo['prIsFinal'] == true ? ($payRequestInfo['prPhysicalProgress'] - 100 > 0 ? ($payRequestInfo['prPhysicalProgress'] - 100) . '% افزایش' : (100 - $payRequestInfo['prPhysicalProgress']) . '% کاهش') : '--'}}</span>
                    </td>
                    <td>
                        <span class="BTitrBold">درصد کل پیشرفت فیزیکی: </span>
                        <span class="BZar size-14">{{$payRequestInfo['prPhysicalProgress'] . '%'}}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="BTitrBold">درصد پیشرفت ریالی: </span>
                        <span class="BZar size-14">{{$payRequestInfo['prAmountProgress'] . '%'}}</span>
                    </td>
                    <td>
                        <span class="BTitrBold">مبلغ پرداختی به عدد: </span>
                        <span class="BZar size-14">{{number_format($payRequestInfo['prAmount']) . ' ریال'}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-bottom: 40px">
                        <span class="BTitrBold">مبلغ پرداختی به حروف: </span>
                        <span class="BZar size-14">{{\Modules\Financial\Http\Controllers\ReportController::digit_to_persain_letters($payRequestInfo['prAmount'])}}</span>
                    </td>
                </tr>
                <?php
                   $row = 0;
                ?>
                @foreach($payRequestInfo['verifiers'] as $verifier)
                    @if($row % 2 == 0)
                        <tr>
                    @endif
                        <td class="text-center">
                            <p class="BTitrBold">{{$verifier['user']['name']}}</p>
                            <p style="margin-top: -10px;" class="text-center BTitrBold">{{$verifier['user']['role']['rSubject']}}</p>
                            <img style="margin-top: -80px;z-index: 99;" src="{{$verifier['signature']['sPath']}}" width="150px" height="150px">
                        </td>
                        <?php
                            $row++;
                        ?>
                    @if($row % 2 == 0)
                        </tr>
                    @endif
                @endforeach
                    @if($row % 2 != 0)
                        </tr>
                    @endif
            </tbody>
        </table>
    </body>
</html>

