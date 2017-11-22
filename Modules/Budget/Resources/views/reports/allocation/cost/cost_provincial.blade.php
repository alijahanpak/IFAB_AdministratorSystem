@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
             <table>
                 <thead align="center" class="BTitrBold">
                 <tr class="small-font">
                     <th>طرح</th>
                     <th>پروژه</th>
                     <th>ردیف اعتبار</th>
                     <th>شماره</th>
                     <th>تاریخ</th>
                     <th>مبلغ</th>
                 </tr>
                 </thead>
                 <tbody>
                     @foreach($items as $plan)
                         @foreach($plan['ca_credit_source_has_allocation'] as $credit_source)
                             @foreach($credit_source['allocation'] as $alloc)
                                 @if($alloc['checked']==true)
                                     <tr>
                                         <td>{{ $plan['caLetterNumber'] }}</td>
                                         <td>{{ $credit_source['credit_distribution_title']['cdtIdNumber'] . ' - '. $credit_source['credit_distribution_title']['cdtSubject'] }}</td>
                                         <td>{{ $credit_source['credit_distribution_row']['cdSubject'] }}</td>
                                         <td>{{ $alloc['caLetterNumber'] }}</td>
                                         <td>{{ $alloc['caLetterDate'] }}</td>
                                         <td>{{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($alloc['caAmount'])}}</td>
                                     </tr>
                                 @endif
                             @endforeach
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

