@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
            <table>
                <thead align="center" class="BTitrBold">
                <tr class="small-font">
                    <th>شماره</th>
                    <th>عنوان</th>
                    <th>فصل بودجه</th>
                    <th>شرح</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($item as $plan)
                        <tr>
                            <td>{{$plan['cdtIdNumber']}}</td>
                            <td>{{$plan['cdtSubject']}}</td>
                            <td>{{$plan['budget_season']['bsSubject']}}</td>
                            <td>{{$plan['cdtDescription']}}</td>
                        </tr>

                        @if(count($plan['c_d_t_in_county']) >0)
                        <tr>
                            <td colspan="3">
                                <table class="unstriped tbl-secondary-mrg small-font">
                                    <thead class="my-thead">
                                    <tr style="background-color: #F1F1F1 !important;">
                                        <th>شهرستان</th>
                                        <th>کد</th>
                                        <th>شرح</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($plan['c_d_t_in_county'] as $cdtInCounty)
                                        <tr>
                                            <td>{{ $cdtInCounty['county']['coName'] }}</td>
                                            <td>{{ $cdtInCounty['cdtIdNumber'] }}</td>
                                            <td>{{ $cdtInCounty['cdtDescription']}}</td>
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

