@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
            <table>
                <thead align="center" class="BTitrBold">
                <tr class="small-font">
                    <th>طرح</th>
                    <th>مبادله شده</th>
                    <th>ابلاغی</th>
                    <th>شهرستان</th>
                    <th>شرح</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $tempItem)
                    <tr>
                        <td>{{ $tempItem['credit_distribution_title']['cdtIdNumber'] . ' - ' . $tempItem['credit_distribution_title']['cdtSubject'] }}</td>
                        <td class="text-center">
                            <div>{{ $tempItem['capExchangeIdNumber'] }}</div>
                            <div>{{ $tempItem['capExchangeDate'] }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ $tempItem['capLetterNumber'] }}</div>
                            <div>{{ $tempItem['capLetterDate'] }}</div>
                        </td>
                        <td>{{ $tempItem['credit_distribution_title']['county']['coName'] }}</td>
                        <td>{{ $tempItem['capDescription'] }}</td>
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

