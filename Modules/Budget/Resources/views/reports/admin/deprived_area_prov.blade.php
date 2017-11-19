@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
            <table>
                <thead align="center" class="BTitrBold">
                <tr class="small-font">
                    <th>شهرستان</th>
                    <th>بخش</th>
                    <th>دهستان</th>
                    <th>روستا</th>
                    <th>شرح</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $deprived_area)
                    <tr>
                        <td>{{$deprived_area['county']['coName']}}</td>
                        <td>{{$deprived_area['region']['reName']}}</td>
                        <td>{{$deprived_area['rural_district']['rdName']}}</td>
                        <td>{{$deprived_area['village']['viName']}}</td>
                        <td>{{$deprived_area['daDescription']}}</td>
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

