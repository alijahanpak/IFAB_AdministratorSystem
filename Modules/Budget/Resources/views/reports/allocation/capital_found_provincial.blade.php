@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
             <table>
                 <thead align="center" class="BTitrBold">
                 <tr class="small-font">
                     <th>تاریخ</th>
                     <th>مبلغ</th>
                     <th>هزینه</th>
                     <th>تبدیل شده به تخصیص</th>
                     <th>شرح</th>
                 </tr>
                 </thead>
                 <tbody>
                     @foreach($items as $found)
                         <tr>
                             <td>{{$found['caaLetterDate']}}</td>
                             <td>{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($found['caaAmount'])}}</td>
                             <td>{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($found['caaSumOfCost'])}}</td>
                             <td>{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($found['caaConvertedAllocAmount'])}}</td>
                             <td>{{$found['caaDescription']}}</td>
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

