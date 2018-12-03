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
    <body class="BZar size-12">
        <div class="text-right" style="width: 150px;position: fixed; left: 0px">
            <p style="z-index: 999;">شماره سند: <span class="number_ltr">........................</span></p>
            <p style="margin-top: -10px;">تاریخ: <span>................................</span></p>
        </div>
        <div style="margin-top: 0px;" class="grid-x">
            <div class="large-12 text-center">
                <div>
                    <div class="text-center">
                        <img style="z-index: 1;" src="{{ asset('pic/ir-logo.jpg') }}" width="170px" height="100px">
                        <div style="width: 100%; margin-top: 10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <span class="BZar">گیرنده وجه:</span><span>{{ ' ' . $draft->dPayTo }}</span>
                        </div>
                        <table style="margin-top: 5px" class="unstriped">
                            <thead align="center" class="BTitrBold">
                            <tr class="small-font">
                                <th class="text-center BTitrBold" colspan="2">شرح پرداخت</th>
                                <th class="text-center BTitrBold">اصل مبلغ <span class="btn-red">(ریال) </span></th>
                                <th class="text-center BTitrBold">افزایش <span class="btn-red">(ریال) </span></th>
                                <th class="text-center BTitrBold">کسور<span class="btn-red">(ریال) </span></th>
                                <th class="text-center BTitrBold">خالص<span class="btn-red">(ریال) </span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="min-height: 50px">
                                <td class="BZar size-10" colspan="2">
                                    <p style="margin: 0px">
                                        {{ $draft->dFor }}
                                    </p>
                                </td>
                                <td class="BZar size-10">
                                    <p style="margin: 0px">
                                        {{ number_format ($draft->dBaseAmount, 0 , "." , "," ) }}
                                    </p>
                                </td>
                                <td class="BZar size-10"></td>
                                <td class="BZar size-10"></td>
                                <td class="BZar size-10"></td>
                            </tr>
                            <tr style="min-height: 50px">
                                <td class="BTitrBold size-8"> کسر می شود </td>
                                <td class="BZar size-10">پرداخت های قبلی <span class="btn-red size-10">(طی صورت وضعیت های ارائه شده) </span></td>
                                <td class="BZar size-10">({{ number_format ($draft->dSumOfLastDraftPureAmount , 0 , "." , "," ) }})</td>
                                <td class="BZar size-10"></td>
                                <td class="BZar size-10"></td>
                                <td class="BZar size-10"></td>
                            </tr>
                            <tr style="min-height: 50px">
                                <td class="BTitrBold size-10" colspan="2">مبلغ هزینه شده <span class="btn-red">(ریال) </span></td>
                                <td class="BZar size-10" colspan="4">{{ number_format ($draft->dPureAmount , 0 , "." , "," ) }}</td>
                            </tr>
                            @foreach($increaseItems as $increaseItem)
                                <tr style="min-height: 50px">
                                    @if ($loop->first)
                                        <td class="BTitrBold size-8" rowspan="{{ count($increaseItems) }}"> اضافه می شود </td>
                                    @endif
                                    <td class="BZar size-10">
                                        <p style="margin: 0px">
                                            {{ $increaseItem->piSubject . ' - ' . $increaseItem->piPercent . '%' }}
                                        </p>
                                    </td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10">
                                        <p style="margin: 0px">
                                            {{ number_format (round(($draft->dPureAmount * $increaseItem->piPercent) / 100)  , 0 , "." , "," ) }}
                                        </p>
                                    </td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10"></td>
                                </tr>
                            @endforeach
                            @foreach($decreaseChecks as $check)
                                <tr style="min-height: 50px">
                                    @if ($loop->first)
                                        <td class="BTitrBold size-8" rowspan="{{ count($decreaseChecks) }}"> کسر می شود </td>
                                    @endif
                                    <td class="BZar size-10"><span class="size-10">{{ $check['percentageDecrease']['pdSubject'] . ' - ' . $check['percentageDecrease']['pdPercent'] . '%' }}</span><span></span></td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10">({{ number_format($check->cAmount , 0 , "." ,",") }})</td>
                                    <td class="BZar size-10"></td>
                                </tr>
                            @endforeach
                            @foreach($depositChecks as $check)
                                <tr style="min-height: 50px">
                                    @if ($loop->first)
                                        <td class="BTitrBold size-8" rowspan="{{ count($depositChecks) }}"> کسر می شود </td>
                                    @endif
                                    <td class="BZar size-10"><span class="size-10">{{ $check['deposit']['depositPercentage']['dpSubject'] . ' - ' . $check['deposit']['depositPercentage']['dpSumOfPercents'] . '%' }}</span><span></span></td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10"></td>
                                    <td class="BZar size-10">({{ number_format($check->cAmount , 0 , "." ,",") }})</td>
                                    <td class="BZar size-10"></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="BTitrBold size-10" colspan="2">مجموع مبلغ قابل پرداخت طی این سند<span class="btn-red">(ریال) </span></td>
                                <td class="BZar size-10" colspan="2">{{ number_format($draft->dAmount , 0 , "." ,",") }}</td>
                                <td class="BZar size-10">({{ number_format(($decreaseChecks->sum('cAmount') + $depositChecks->sum('cAmount')) , 0 , "." ,",") }})</td>
                                <td class="BZar size-10">{{ number_format($draft->dAmount - ($decreaseChecks->sum('cAmount') + $depositChecks->sum('cAmount')) , 0 , "." ,",") }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-right" style="width: 100%; margin-top: 5px;">
                            <p class="BTitrBold size-10" style="margin-bottom: 5px">گواهی و رسید گیرنده وجه:</p>
                            <span class="BZar" style="margin-right: 5px">امضا کننده گواهی می نمایم که بابت کالا / خدمات مشروحه بالا مبلغ (بحروف) </span>
                            <span class="BZar">{{ ' ' . \Modules\Financial\Http\Controllers\ReportController::digit_to_persain_letters($draft->dAmount) . ' ریال ' }}</span>
                            <span class="BZar"> دریافت نموده ام.</span>
                        </div>
                        <div class="text-left" style="width: 100%; margin-top: 0px">
                            <span class="BTitrBold size-10">امضاء </span>
                            <span class="BZar">..............................</span>
                            <span class="BTitrBold size-10">تاریخ </span>
                            <span class="BZar">..............................</span>
                        </div>
                        <div style="width: 100%; margin-top: 10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px;margin-bottom: 0">
                            <p class="BTitrBold size-10">گواهی تنظیم کننده سند:</p>
                            <p class="BZar" style="margin-top: -10px">گواهی می شود که این سند هزینه بموجب اسناد و املاک به پیوست طبق مقررات مالی و معاملاتی موسسات پژوهشی وزارت متبوع تنظیم گردید.</p>
                        </div>
                        <table style="border:none !important; margin-top: -20px; margin-bottom: 0">
                            <tbody style="border:none !important">
                            <tr style="border:none !important">
                                <td style="border:none !important">
                                    <p class="BTitrBold" style="margin: 0">تنظیم کننده</p>
                                    <p class="BZar">......................................</p>
                                </td>
                                <td style="border:none !important">
                                    <p class="BTitrBold" style="margin: 0">مسئول رسیدگی</p>
                                    <p class="BZar">......................................</p>
                                </td>
                                <td style="border:none !important">
                                    <p class="BTitrBold"style="margin: 0">مدیرکل</p>
                                    <p class="BZar">......................................</p>
                                </td>
                                <td style="border:none !important">
                                    <p class="BTitrBold"style="margin: 0">ذیحساب</p>
                                    <p class="BZar">......................................</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="width: 100%; margin-top: -20px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <p class="BTitrBold size-10" style="margin-bottom: 0px">تامین اعتبار:</p>
                            @foreach($capFinancing as $item)
                                <div style="padding-right: 20px">
                                    <span class="BTitrBold size-10">{{ 'از محل: ' . $item['creditDistributionTitle']['cdtIdNumber'] . ' - ' }}</span>
                                    <span class="BZar">{{ $item['creditDistributionTitle']['cdtSubject'] }}</span>
                                </div>
                            @endforeach
                            @foreach($costFinancing as $item)
                                <div style="padding-right: 20px">
                                    <span class="BTitrBold size-10">{{ 'از محل: ' . $item['creditDistributionTitle']['cdtIdNumber'] . ' - ' }}</span>
                                    <span class="BZar">{{ $item['creditDistributionTitle']['cdtSubject'] }}</span>
                                </div>
                            @endforeach
                            <span class="BZar">مسئول تامین اعتبار </span>
                            <span class="BZar">..............................................</span>
                            <span class="BZar"> امضاء </span>
                            <span class="BZar">......................................</span>
                            <span class="BZar"> تاریخ </span>
                            <span class="BZar">....................</span>
                        </div>
                        <div style="width: 100%; margin-top: 10px; border-bottom: 2px black groove"></div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <span class="BZar">بموجب چک / چک های شماره </span>
                            <span class="BZar">.................................</span>
                            <span class="BZar"> به </span>
                            <span class="BZar">{{ $draft->dPayTo }}</span>
                            <span class="BZar"> بابت </span>
                            <span class="BZar">{{ $draft->dFor }}</span>
                            <span class="BZar"> پرداخت شد.</span>
                        </div>
                        <div class="text-right" style="width: 100%; margin-top: 5px">
                            <span class="BZar">صادر کننده چک </span>
                            <span class="BZar">..............................................</span>
                            <span class="BZar"> تاریخ / امضاء </span>
                            <span class="BZar">....................</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


