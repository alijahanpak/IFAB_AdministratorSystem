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
                    <?php
                        $item = json_decode($tempItem);
                    ?>
                    <tr>
                        <td>{{ $item->credit_distribution_title->cdtIdNumber . ' - ' . $item->credit_distribution_title->cdtSubject }}</td>
                        <td class="text-center">
                            <div>{{ $item->capExchangeIdNumber }}</div>
                            <div>{{ $item->capExchangeDate }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ $item->capLetterNumber }}</div>
                            <div>{{ $item->capLetterDate }}</div>
                        </td>
                        <td>{{ $item->credit_distribution_title->county->coName }}</td>
                        <td>{{ $item->capDescription }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if ($options->withReporterName)
            <div class="text-left">
                <p style="margin-top: 50px;margin-left: 50px;" class="BTitrBold x-small-font">علی جهان پاک</p>
            </div>
            @endif
        </div>
    </div>
    @stop

