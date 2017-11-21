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
                 @foreach($items as $plan)
                     @foreach($plan['credit_distribution_plan'] as $cdPlan)
                         @if($cdPlan['checked']==true)
                             <tr>
                                 <td>{{ $plan['cdtIdNumber'] .'-'. $plan['cdtSubject'] }}</td>
                                 <td>{{ $cdPlan['credit_distribution_row']['cdSubject'] }}</td>
                                 <td>{{ $cdPlan['county']['coName'] }}</td>
                                 <td>{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($cdPlan['cdpCredit']) }}</td>
                                 <td>{{ $cdPlan['cdpDescription'] }}</td>

                             </tr>
                         @endif
                     @endforeach
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

