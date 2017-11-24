@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
            <table>
                <thead align="center" class="BTitrBold">
                <tr class="small-font">
                    <th>شماره مبادله</th>
                    <th>تاریخ مبادله</th>
                    <th>شماره ابلاغ</th>
                    <th>تاریخ ابلاغ</th>
                    <th>اعتبار</th>
                    <th>شرح</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $tempItem)
                    <tr>
                        <td>{{$tempItem['caLetterNumber']}}</td>
                        <td>{{$tempItem['caLetterDate']}}</td>
                        <td>{{$tempItem['caExchangeIdNumber']}}</td>
                        <td>{{$tempItem['caExchangeDate']}}</td>
                        <td>0</td>
                        <td>{{$tempItem['caDescription']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($options['withReporterName'])
            <div class="text-left">
                <p style="margin-top: 50px;margin-left: 50px;" class="BTitrBold x-small-font">علی جهان پاک</p>
            </div>
            @endif
        </div>
    </div>
    @stop

