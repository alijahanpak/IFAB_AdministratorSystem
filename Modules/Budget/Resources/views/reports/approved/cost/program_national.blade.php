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
                    @if(count($tempItem['ca_credit_source']) >0)
                        <tr>
                            <td colspan="7">
                                <table class="unstriped tbl-secondary-mrg small-font">
                                    <thead class="my-thead">
                                    <tr style="background-color: #F1F1F1 !important;">
                                        <th>برنامه</th>
                                        <th>ردیف</th>
                                        <th>فصل</th>
                                        <th>عنوان فصل</th>
                                        <th>ریز فصل</th>
                                        <th>مبلغ</th>
                                        <th>توضیحات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tempItem['ca_credit_source'] as $creditSource)
                                        <tr>
                                            <td>{{ $creditSource['credit_distribution_title']['cdtIdNumber'] .'-'.$creditSource['credit_distribution_title']['cdtSubject'] }}</td>
                                            <td>{{ $creditSource['credit_distribution_row']['cdSubject'] }}</td>
                                            <td>{{ $creditSource['tiny_season']['season_title']['season']['sSubject']}}</td>
                                            <td>{{ $creditSource['tiny_season']['season_title']['cstSubject'] }}</td>
                                            <td>{{ $creditSource['tiny_season']['ctsSubject'] }}</td>
                                            <td>{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($creditSource['ccsAmount'] )}}</td>
                                            <td>{{ $creditSource['ccsDescription']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endif
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

