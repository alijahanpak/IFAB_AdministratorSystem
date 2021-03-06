@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
            <table>
                <thead align="center" class="BTitrBold">
                <tr class="small-font">
                    <th>کد طرح</th>
                    <th>کد</th>
                    <th>عنوان</th>
                    <th>شهرستان</th>
                    <th>سال شروع</th>
                    <th>سال خاتمه</th>
                    <th>پیشرفت فیزیکی</th>
                    <th>اعتبار</th>
                    <th>شرح</th>
                </tr>
                </thead>
                <tbody>
                <?php $sum = 0; ?>
                @foreach($items as $plan)
                    @foreach($plan['capital_assets_project'] as $project)
                        @if($project['checked']==true)
                            <tr>
                                <td>{{ $plan['credit_distribution_title']['cdtIdNumber'] . ' - ' . $plan['credit_distribution_title']['cdtSubject'] }}</td>
                                <td class="text-center">{{$project['cpCode']}}</td>
                                <td>{{$project['cpSubject']}}</td>
                                <td class="text-center">{{$project['county']['coName']}}</td>
                                <td class="text-center">{{ $project['cpStartYear'] }}</td>
                                <td class="text-center">{{ $project['cpEndOfYear'] }}</td>
                                <td class="text-center">{{ $project['cpPhysicalProgress'] }}</td>
                                <td class="text-center">{{\Modules\Admin\Entities\AmountUnit::convertDispAmount(\Modules\Budget\Entities\CapCreditSource::sumOfCreditSource($project['id']))}}</td>
                                <td>{{$project['cpDescription']}}</td>
                            </tr>
                            @if(count($project['credit_source']) >0)
                                <tr>
                                    <td colspan="9">
                                        <table class="unstriped tbl-secondary-mrg small-font">
                                            <thead class="my-thead">
                                            <tr style="background-color: #F1F1F1 !important;">
                                                <th>ردیف</th>
                                                <th>فصل</th>
                                                <th>عنوان فصل</th>
                                                <th>ریز فصل</th>
                                                <th>نحوه اجرا</th>
                                                <th>مبلغ</th>
                                                <th>توضیحات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($project['credit_source'] as $creditSource)
                                                <tr>
                                                    <td>{{ $creditSource['credit_distribution_row']['cdSubject'] }}</td>
                                                    <td class="text-center">{{ $creditSource['tiny_season']['season_title']['season']['sSubject'] }}</td>
                                                    <td>{{ $creditSource['tiny_season']['season_title']['castSubject'] }}</td>
                                                    <td>{{ $creditSource['tiny_season']['catsSubject'] }}</td>
                                                    <td class="text-center">{{ $creditSource['how_to_run']['htrSubject'] }}</td>
                                                    <td class="text-center">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($creditSource['ccsAmount']) }}</td>
                                                    <td>{{ $creditSource['ccsDescription'] }}</td>
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
                        @endif
                    @endforeach
                @endforeach
                <tr>
                    <td class="text-center BTitrBold" colspan="6">مجموع</td>
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

