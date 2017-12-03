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
                    <?php
                        $sum = 0;
                        $sumOfCost = 0;
                        $sumOfConverted = 0;
                    ?>
                     @foreach($items as $found)
                         <tr>
                             <td class="text-center">{{$found['caLetterDate']}}</td>
                             <td class="text-center">{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($found['caAmount'])}}</td>
                             <td class="text-center">{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($found['caSumOfCost'])}}</td>
                             <td class="text-center">{{\Modules\Admin\Entities\AmountUnit::convertDispAmount($found['caConvertedAllocAmount'])}}</td>
                             <td>{{$found['caDescription']}}</td>
                         </tr>
                         <?php
                            $sum += $found['caAmount'];
                            $sumOfCost += $found['caSumOfCost'];
                            $sumOfConverted += $found['caConvertedAllocAmount'];
                         ?>
                     @endforeach
                    <tr>
                        <td class="text-center BTitrBold">مجموع</td>
                        <td class="text-center BTitrBold">
                            {{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($sum) }}
                        </td>
                        <td class="text-center BTitrBold">
                            {{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($sumOfCost) }}
                        </td>
                        <td class="text-center BTitrBold">
                            {{ \Modules\Admin\Entities\AmountUnit::convertDispAmount($sumOfConverted) }}
                        </td>
                    </tr>
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

