@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
            <table>
                <thead align="center" class="BTitrBold">
                <tr class="small-font">
                    <th>شماره ابلاغ</th>
                    <th>تاریخ ابلاغ</th>
                    <th>شماره مبادله</th>
                    <th>تاریخ مبادله</th>
                    <th>اعتبار</th>
                    <th>شرح</th>
                </tr>
                </thead>
                <tbody>
                <?php $sum = 0; ?>
                @foreach($items as $tempItem)
                    <tr>
                        <td class="text-center">{{ $tempItem['caLetterNumber'] }}</td>
                        <td class="text-center">{{ $tempItem['caLetterDate'] }}</td>
                        <td class="text-center">{{ $tempItem['caProvinceOrNational'] == 0 ? $tempItem['caExchangeIdNumber'] : ' -- '}}</td>
                        <td class="text-center">{{ $tempItem['caProvinceOrNational'] == 0 ? $tempItem['caExchangeDate']  : ' -- '}}</td>
                        <td class="text-center">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CaCreditSource::sumOfCreditSource($tempItem['id']))}}</td>
                        <td>{{ $tempItem['caDescription']}}</td>
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
                                                <td class="text-center">{{ $creditSource['tiny_season']['season_title']['season']['sSubject']}}</td>
                                                <td>{{ $creditSource['tiny_season']['season_title']['cstSubject'] }}</td>
                                                <td>{{ $creditSource['tiny_season']['ctsSubject'] }}</td>
                                                <td class="text-center">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($creditSource['ccsAmount'])}}</td>
                                                <td>{{ $creditSource['ccsDescription']}}</td>
                                            </tr>
                                            <?php
                                                $sum += $creditSource['ccsAmount'];
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="text-center BTitrBold" colspan="3">مجموع</td>
                    <td class="text-center BTitrBold" colspan="2">
                        {{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($sum) }}
                    </td>
                </tr>
                </tbody>
            </table>
            @if ($options['withReporterName'])
            <div class="text-left">
                <p style="margin-top: 50px;margin-left: 50px;" class="BTitrBold x-small-font">{{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
            </div>
            @endif
        </div>
    </div>
    @stop

