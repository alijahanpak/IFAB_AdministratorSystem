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
        <style>
            .number_ltr {
                direction: ltr!important;
                unicode-bidi: embed;
            }
            .page {
                position: relative;
                page-break-after: always;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

        </style>
    </head>
    <body style="font-size: 16px;"  class="BZar">
        <div  style="{{'width:' . ($checkFormat->cfHeight * 10) . 'mm;height:' . ($checkFormat->cfWidth * 10).'mm;'}}" class="page">
            <p class="check-element-print size-21" style="{{'margin-top:' . (($checkFormat->cfDateTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfDateRight * 10) . 'mm;width:' . ($checkFormat->cfDateWidth * 10) .'mm;'}}">{{$check['cDate']}}</p>
            <p class="check-element-print" style="{{'margin-top:' . (($checkFormat->cfStringDateTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfStringDateRight * 10) . 'mm;width:' . ($checkFormat->cfStringDateWidth * 10) .'mm;'}}">{{$check['dateText']}}</p>
            <p class="check-element-print" style="{{'margin-top:' . (($checkFormat->cfForTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfForRight * 10) . 'mm;width:' . ($checkFormat->cfForWidth * 10) .'mm;'}}">{{$check['cPdId'] != null ? $check['percentageDecrease']['pdSubject'] . ' - ' . $check['draft']['dFor'] : $check['draft']['dFor']}}</p>
            <p class="check-element-print" style="{{'margin-top:' . (($checkFormat->cfPayToTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfPayToRight * 10) . 'mm;width:' . ($checkFormat->cfPayToWidth * 10) .'mm;'}}">{{$check['cPdId'] != null ? $check['percentageDecrease']['pdPayTo'] : $check['draft']['dPayTo']}}</p>
            <p class="check-element-print" style="{{'margin-top:' . (($checkFormat->cfStringAmountTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfStringAmountRight * 10) . 'mm;width:' . ($checkFormat->cfStringAmountWidth * 10) .'mm;'}}">{{($check['amountText'])}}</p>
            <p class="check-element-print text-left size-21" style="{{'margin-top:' . (($checkFormat->cfAmountTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfAmountRight * 10) . 'mm;width:' . ($checkFormat->cfAmountWidth * 10) .'mm;'}}">{{number_format($check['cAmount'] , 0 , "." ,",")}}</p>
            <p class="check-element-print text-center" style="{{'margin-top:' . (($checkFormat->cfSignatureTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfSignatureRight * 10) . 'mm;width:' . ($checkFormat->cfSignatureWidth * 10) .'mm;'}}">{{$check['selectedVerifiers'][0]['verifier']['user']['name']}}</p>
            <p class="check-element-print text-center" style="{{'margin-top:' . ((($checkFormat->cfSignatureTop * 10) - $baseMargin) + 5) . 'mm;margin-right:' . ($checkFormat->cfSignatureRight * 10) . 'mm;width:' . ($checkFormat->cfSignatureWidth * 10) .'mm;'}}">{{$check['selectedVerifiers'][0]['verifier']['user']['role']['rSubject']}}</p>
            <p class="check-element-print text-center"  style="{{'margin-top:' . (($checkFormat->cfSecondSignatureTop * 10) - $baseMargin) . 'mm;margin-right:' . ($checkFormat->cfSecondSignatureRight * 10) . 'mm;width:' . ($checkFormat->cfSecondSignatureWidth * 10) .'mm;'}}">{{count($check['selectedVerifiers']) > 1 ? $check['selectedVerifiers'][1]['verifier']['user']['name'] : ''}}</p>
            <p class="check-element-print text-center"  style="{{'margin-top:' . ((($checkFormat->cfSecondSignatureTop * 10) - $baseMargin) + 5) . 'mm;margin-right:' . ($checkFormat->cfSecondSignatureRight * 10) . 'mm;width:' . ($checkFormat->cfSecondSignatureWidth * 10) .'mm;'}}">{{count($check['selectedVerifiers']) > 1 ? $check['selectedVerifiers'][1]['verifier']['user']['role']['rSubject'] : ''}}</p>
        </div>
    </body>
</html>


