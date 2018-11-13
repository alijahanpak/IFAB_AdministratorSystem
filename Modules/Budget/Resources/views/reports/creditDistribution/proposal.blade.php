@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
             <table>
                 <thead align="center" class="BTitrBold">
                 <tr class="small-font">
                     <th>شهرستان</th>
                     <th>طرح</th>
                     <th>کد پروژه</th>
                     <th>عنوان</th>
                     <th>اعتبار</th>
                     <th>شرح</th>
                 </tr>
                 </thead>
                 <tbody>
                    <?php $sum = 0; ?>
                     @foreach($items as $county)
                         @foreach($county['credit_distribution_plan_has_proposal'] as $plan)
                             @foreach($plan['proposal'] as $proposal)
                                @if($proposal['checked']==true)
                                    <tr>
                                        <td>{{$county['coName']}}</td>
                                        <td>{{$plan['credit_distribution_title']['cdtIdNumber']. ' - ' . $plan['credit_distribution_title']['cdtSubject'] }}</td>
                                        <td class="text-center">{{$proposal['pbpCode']}}</td>
                                        <td>{{$proposal['pbpSubject']}}</td>
                                        <td class="text-center">{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($proposal['pbpAmount'])}}</td>
                                        <td>{{$proposal['pbpDescription']}}</td>
                                    </tr>
                                    <?php
                                    $sum += $proposal['pbpAmount'];
                                    ?>
                                @endif
                             @endforeach
                         @endforeach
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

