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
        </style>
    </head>
    <body class="BZar size-14">
        <div class="text-right" style="width: 150px;position: fixed;top: 20px; left: 0px">
            <p style="z-index: 999;" class="size-12">شماره: <span class="number_ltr">......................</span></p>
            <p style="margin-top: -10px;" class="size-12">تاریخ: <span>......................</span></p>
        </div>
        <div style="margin: 5px;margin-top: 10px;" class="grid-x">
            <div class="large-12 text-center">
                <div>
                    <div class="text-center">
                        <img style="z-index: 1;" src="{{ asset('pic/ir-logo.jpg') }}" width="170px" height="100px">
                        <div style="width: 100%; margin-top: 10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <span class="BZar size-14">گیرنده وجه:</span><span>{{ ' ' . $draft->dPayTo }}</span>
                        </div>
                        <table style="margin-top: 5px" class="unstriped">
                            <thead align="center" class="BTitrBold">
                            <tr class="small-font">
                                <th class="text-center BTitrBold">شرح پرداخت</th>
                                <th class="text-center BTitrBold">اصل مبلغ <span class="btn-red">(ریال) </span></th>
                                <th class="text-center BTitrBold">کسور<span class="btn-red">(ریال) </span></th>
                                <th class="text-center BTitrBold">مبلغ پرداختی<span class="btn-red">(ریال) </span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="min-height: 50px">
                                <td class="BZar size-10">
                                    <p style="margin: 0px">
                                        {{ $draft->dFor }}
                                    </p>
                                    @foreach($increaseItems as $increaseItem)
                                        <p style="margin: 0px">
                                            {{ $increaseItem->piSubject . ' - %' . $increaseItem->piPercent }}
                                        </p>
                                    @endforeach
                                </td>
                                <td class="BZar size-10">
                                    <p style="margin: 0px">
                                        {{ number_format ($draft->dBaseAmount, 0 , "." , "," ) }}
                                    </p>
                                    @foreach($increaseItems as $increaseItem)
                                        <p style="margin: 0px">
                                            {{ number_format (round(($draft->dBaseAmount * $increaseItem->piPercent) / 100)  , 0 , "." , "," ) }}
                                        </p>
                                    @endforeach
                                </td>
                                <td class="BZar size-10"></td>
                                <td class="BZar size-10"></td>
                            </tr>
                            <tr style="min-height: 50px">
                                <td class="BZar size-10">پرداخت های قبلی</td>
                                <td class="BZar size-10">{{ number_format ($draft->dSumOfLastDraftAmount , 0 , "." , "," ) }}</td>
                                <td class="BZar size-10"></td>
                                <td class="BZar size-10"></td>
                            </tr>
                            @foreach($decreaseChecks as $check)
                                <tr style="min-height: 50px">
                                    <td class="BZar size-10"><span class="size-10">{{ $check['percentageDecrease']['pdSubject'] . ' - %' . $check['percentageDecrease']['pdPercent'] }}</span><span></span></td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10">{{ number_format($check->cAmount , 0 , "." ,",") }}</td>
                                    <td class="BZar size-10"></td>
                                </tr>
                            @endforeach
                            @foreach($depositChecks as $check)
                                <tr style="min-height: 50px">
                                    <td class="BZar size-10"><span class="size-10">{{ $check['deposit']['depositPercentage']['dpSubject'] . ' - %' . $check['deposit']['depositPercentage']['dpSumOfPercents'] }}</span><span></span></td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10">{{ number_format($check->cAmount , 0 , "." ,",") }}</td>
                                    <td class="BZar size-10"></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="BTitrBold size-10">مبلغ محاسبه شده<span class="btn-red">(ریال) </span></td>
                                <td class="BZar size-10">{{ number_format($draft->dAmount , 0 , "." ,",") }}</td>
                                <td class="BZar size-10">{{ number_format(($decreaseChecks->sum('cAmount') + $depositChecks->sum('cAmount')) , 0 , "." ,",") }}</td>
                                <td class="BZar size-10">{{ number_format($draft->dAmount - ($decreaseChecks->sum('cAmount') + $depositChecks->sum('cAmount')) , 0 , "." ,",") }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-right" style="width: 100%; margin-top: 5px;">
                            <p class="BTitrBold size-12" style="margin-bottom: 5px">گواهی و رسید گیرنده وجه:</p>
                            <span class="BZar size-14" style="margin-right: 5px">امضا کننده گواهی می نمایم که بابت کالا / خدمات مشروحه بالا مبلغ (بحروف) </span>
                            <span class="BZar size-14">{{ ' ' . \Modules\Financial\Http\Controllers\ReportController::digit_to_persain_letters($draft->dAmount - ($decreaseChecks->sum('cAmount') + $depositChecks->sum('cAmount'))) . ' ریال ' }}</span>
                            <span class="BZar size-14"> دریافت نموده ام.</span>
                        </div>
                        <div class="text-left" style="width: 100%; margin-top: 5px">
                            <span class="BTitrBold size-12">امضاء </span>
                            <span class="BZar size-14">..............................</span>
                            <span class="BTitrBold size-12">تاریخ </span>
                            <span class="BZar size-14">..............................</span>
                        </div>
                        <div style="width: 100%; margin-top: 10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px;margin-bottom: 0">
                            <p class="BTitrBold size-12">گواهی تنظیم کننده سند:</p>
                            <p class="BZar size-14" style="margin-top: -10px">گواهی می شود که این سند هزینه بموجب اسناد و املاک به پیوست طبق مقررات مالی و معاملاتی موسسات پژوهشی وزارت متبوع تنظیم گردید.</p>
                        </div>
                        <table style="border:none !important; margin-top: 0">
                            <tbody style="border:none !important">
                            <tr style="border:none !important">
                                <td style="border:none !important">
                                    <p class="BTitrBold">تنظیم کننده</p>
                                    <p class="BZar size-14">......................................</p>
                                </td>
                                <td style="border:none !important">
                                    <p class="BTitrBold">مسئول رسیدگی</p>
                                    <p class="BZar size-14">......................................</p>
                                </td>
                                <td style="border:none !important">
                                    <p class="BTitrBold">مدیرکل</p>
                                    <p class="BZar size-14">......................................</p>
                                </td>
                                <td style="border:none !important">
                                    <p class="BTitrBold">ذیحساب</p>
                                    <p class="BZar size-14">......................................</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="width: 100%; margin-top: -10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <p class="BTitrBold size-12" style="margin-bottom: 0px">تامین اعتبار:</p>
                            @foreach($capFinancing as $item)
                                <div class="size-14" style="padding-right: 20px">
                                    <span class="BTitrBold size-10">{{ $item['creditDistributionTitle']['cdtIdNumber'] . ' - ' }}</span>
                                    <span class="BZar size-14">{{ $item['creditDistributionTitle']['cdtSubject'] }}</span>
                                </div>
                            @endforeach
                            @foreach($costFinancing as $item)
                                <div class="size-14" style="padding-right: 20px">
                                    <span class="BTitrBold size-10">{{ $item['creditDistributionTitle']['cdtIdNumber'] . ' - ' }}</span>
                                    <span class="BZar size-14">{{ $item['creditDistributionTitle']['cdtSubject'] }}</span>
                                </div>
                            @endforeach
                            <span class="BZar size-14">اسم و امضاء مسئول تامین اعتبار </span>
                            <span class="BZar size-14">..............................................</span>
                            <span class="BZar size-14"> سمت </span>
                            <span class="BZar size-14">......................................</span>
                            <span class="BZar size-14"> تاریخ </span>
                            <span class="BZar size-14">....................</span>
                        </div>
                        <div style="width: 100%; margin-top: 10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <span class="BZar size-14">بموجب حواله / چک شماره </span>
                            <span class="BZar size-14">.................................</span>
                            <span class="BZar size-14"> به </span>
                            <span class="BZar size-14">{{ $draft->dPayTo }}</span>
                            <span class="BZar size-14"> بابت </span>
                            <span class="BZar size-14">{{ $draft->dFor }}</span>
                            <span class="BZar size-14"> پرداخت شد.</span>
                        </div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <span class="BZar size-14">اسم و امضاء </span>
                            <span class="BZar size-14">..............................................</span>
                            <span class="BZar size-14"> سمت </span>
                            <span class="BZar size-14">......................................</span>
                            <span class="BZar size-14"> تاریخ </span>
                            <span class="BZar size-14">....................</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


