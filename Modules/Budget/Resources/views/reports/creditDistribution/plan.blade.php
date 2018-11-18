@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
             <table>
                 <thead align="center" class="BTitrBold">
                 <tr class="small-font">
                     <th>طرح</th>
                     <th>ردیف</th>
                     <th>فصل بودجه</th>
                     <th>مبلغ اعتبار</th>
                     <th>شرح</th>
                 </tr>
                 </thead>
                 <tbody>
                    <?php $sum = 0; ?>
                     @foreach($items as $plan)
                         @foreach($plan['credit_distribution_plan'] as $cdPlan)
                             @if($cdPlan['checked']==true)
                                 <tr>
                                     <td>{{ $plan['cdtIdNumber'] .'-'. $plan['cdtSubject'] }}</td>
                                     <td class="text-center">{{ $cdPlan['credit_distribution_row']['cdSubject'] }}</td>
                                     <td class="text-center">{{ $cdPlan['county']['coName'] }}</td>
                                     <td class="text-center">{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($cdPlan['cdpCredit']) }}</td>
                                     <td>{{ $cdPlan['cdpDescription'] }}</td>
                                 </tr>
                                 <?php
                                    $sum += $cdPlan['cdpCredit'];
                                 ?>
                             @endif
                         @endforeach
                     @endforeach
                    <tr>
                        <td class="text-center BTitrBold" colspan="2">مجموع</td>
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

