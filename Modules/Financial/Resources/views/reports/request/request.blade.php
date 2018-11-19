<!doctype html>
<html class="no-js" lang="en" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>سند هزینه</title>
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
            table,td,th{
                border:1px solid #333;
                color: #000000;
                font-size: x-small;
            }
            tr{
                page-break-inside: avoid;
            }
            td{
                padding: 0;
            }
            thead{
                font-size: small;
            }

            .unborder-table{
                border:none !important;
            }
        </style>
    </head>
    <body class="BZar size-14">
        <div class="text-right" style="width: 150px;position: fixed;top: 20px; left: 0px">
            <p style="z-index: 999;" class="size-12">شماره: <span class="number_ltr">{{ $request['rLetterNumber'] }}</span></p>
            <p style="margin-top: -10px;" class="size-12">تاریخ: <span>{{ $request['rLetterDate'] }}</span></p>
        </div>
        <div style="margin: 5px;margin-top: 10px;" class="grid-x">
            <div class="large-12 text-center">
                <div>
                    <div class="text-right">
                        <img style="z-index: 1;" src="{{ asset('pic/ir-logo.jpg') }}" width="170px" height="100px">
                    </div>
                    <div class="text-center size-14">
                        <div style="width: 100%; margin-top: 10px; border-bottom: 3px black groove"></div>
                        @if($request['requestType']['rtType'] == 'BUY_SERVICES')
                            <p class="BTitrBold" style="margin-top: 2rem">درخواست خرید خدمات</p>
                            <div class="text-right BZar padding-lr">
                                <p class="BTitrBold size-12" style="margin-top: 2rem">مدیر کل محترم اداره متبوع</p>
                                <p class="text-justify" style="margin-bottom: 0px">با سلام و احترام</p>
                                <p class="text-justify" style="text-indent: 50px">{{ 'نظر به ضرورت انجام ' . $request['rSubject'] . ' به شرح مشخصات ذیل، خواهشمند است دستورات لازم را به منظور تنظیم قرارداد / توافقنامه صادر فرمایید.'}}</p>
                            </div>
                            <div class="padding-lr">
                                <table style="margin-top: 5px" class="unstriped padding-lr">
                                    <thead align="center" class="BTitrBold">
                                    <tr class="small-font">
                                        <th colspan="2" class="text-center BTitrBold">شرح خدمات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="min-height: 50px">
                                        <td colspan="2" class="BZar size-14 text-justify">{{ $request['rDescription'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="BZar size-12 text-right" rowspan="2">برآورد تقریبی اعتبار مورد نیاز <span class="btn-red">(ریال) </span></td>
                                        <td class="size-14">
                                            <p class="text-left" style="margin: 0">{{ number_format($request['rCostEstimation'] , 0 , "." ,",") }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                       <td class="size-12">
                                           <p class="text-right" style="margin: 0">{{ \Modules\Financial\Http\Controllers\ReportController::digit_to_persain_letters($request['rCostEstimation']) }}</p>
                                       </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right BZar padding-lr">
                                <span class="BTitrBold size-12" style="margin-top: 2rem">توضیحات تکمیلی:</span>
                                <span class="text-justify">{{ ' ' . $request['rFurtherDetails'] }}</span>
                            </div>
                            <div class="padding-lr">
                                <table style="width: 100%; margin-top: 2rem" class="unstriped unborder-table padding-lr">
                                    <tbody class="unborder-table">
                                    <?php
                                    $row = 0;
                                    ?>
                                    @foreach($request['verifiers'] as $verifier)
                                        @if($row % 2 == 0)
                                            <tr class="unborder-table">
                                                @endif
                                                <td class="text-center unborder-table">
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
                            </div>
                        @elseif($request['requestType']['rtType'] == 'BUY_COMMODITY')
                            <p class="BTitrBold" style="margin-top: 2rem">فرم درخواست خرید</p>
                            <div class="text-right BZar padding-lr">
                                <p class="text-justify">{{ 'خواهشمند است دستور فرمایید ملزومات / اثاثیه ذیل برای ' . $request['rSubject'] . ' خریداری و تحویل گردد.'}}</p>
                                <table style="margin-top: 5px" class="unstriped">
                                    <thead align="center" class="BTitrBold">
                                    <tr class="small-font">
                                        <th class="text-center BTitrBold">ردیف</th>
                                        <th class="text-center BTitrBold">شرح و نوع جنس</th>
                                        <th class="text-center BTitrBold">تعداد</th>
                                        <th class="text-center BTitrBold">مبلغ براورد <span class="btn-red">(ریال) </span></th>
                                        <th class="text-center BTitrBold">موجود در انبار</th>
                                        <th class="text-center BTitrBold">توضیحات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $row = 1; ?>
                                    @foreach($request['requestCommodity'] as $rCommodity)
                                        <tr>
                                            <td class="BZar size-14 text-center" style="width: 1rem">{{ $row++ }}</td>
                                            <td class="BZar size-14 text-justify">{{ $rCommodity['commodity']['cSubject'] }}</td>
                                            <td class="BZar size-14 text-center">{{ $rCommodity['rcCount'] }}</td>
                                            <td class="BZar size-14 text-center">{{ number_format($rCommodity['rcCostEstimation'] , 0 , "." ,",") }}</td>
                                            <td class="BZar size-14 text-center">{{ $rCommodity['rcExistCount'] }}</td>
                                            <td class="BZar size-14 text-justify">{{ $rCommodity['rcDescription'] }}</td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="3" class="text-center BTitrBold">مجموع برآورد <span class="btn-red">(ریال) </span></td>
                                            <td colspan="3" class="text-center BZar size-14">{{ number_format($request['rCostEstimation'] , 0 , "." ,",") }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p></p>
                            </div>
                            <div class="padding-lr">
                                <table style="width: 100%; margin-top: 2rem" class="unstriped unborder-table padding-lr">
                                    <tbody class="unborder-table">
                                    <?php
                                    $row = 0;
                                    ?>
                                    @foreach($request['verifiers'] as $verifier)
                                        @if($row % 2 == 0)
                                            <tr class="unborder-table">
                                                @endif
                                                <td class="text-center unborder-table">
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
                            </div>
                        @elseif($request['requestType']['rtType'] == 'FUND')
                            <p class="BTitrBold" style="margin-top: 2rem">درخواست تنخواه پرداخت</p>
                            <div class="text-right BZar padding-lr">
                                <p class="BTitrBold size-12">{{ $request['verifiers'][1]['user']['role']['rSubject'] . ' محترم' }}</p>
                                <p class="text-justify" style="margin-bottom: 0px">با سلام و احترام</p>
                                <p class="text-justify" style="text-indent: 50px">{{ 'خواهشمند است در صورت موافقت دستور فرمایید اقدام لازم در خصوص پرداخت مبلغ ' . number_format($request['rCostEstimation'] , 0 , "." ,",") . ' ریال تنخواه، بابت ' . $request['rSubject'] . ' به حساب کارپردازی مبذول گردد.'}}</p>
                                <div class="text-center" style="width: 200px; float: left">
                                    <p class="BTitrBold size-12">{{$request['verifiers'][0]['user']['name']}}</p>
                                    <p style="margin-top: -10px;" class="text-center BTitrBold size-12">{{$request['verifiers'][0]['user']['role']['rSubject']}}</p>
                                    <img style="margin-top: -80px;z-index: 99;" src="{{$request['verifiers'][0]['signature']['sPath']}}" width="150px" height="150px">
                                </div>
                            </div>
                            <div class="text-right BZar padding-lr" style="margin-top: 150px">
                                <p class="BTitrBold size-12">مسئول محترم امور مالی</p>
                                <p class="text-justify" style="margin-bottom: 0px">با سلام</p>
                                <p class="text-justify" style="text-indent: 50px">{{ 'در صورت وجود اعتبار، نسبت به پرداخت تنخواه به حساب کارپردازی اقدام نمایید.'}}</p>
                                <div class="text-center" style="width: 200px; float: left">
                                    <p class="BTitrBold size-12">{{$request['verifiers'][1]['user']['name']}}</p>
                                    <p style="margin-top: -10px;" class="text-center BTitrBold size-12">{{$request['verifiers'][1]['user']['role']['rSubject']}}</p>
                                    <img style="margin-top: -80px;z-index: 99;" src="{{$request['verifiers'][1]['signature']['sPath']}}" width="150px" height="150px">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


