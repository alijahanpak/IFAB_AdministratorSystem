@extends('budget::layouts.report_master')
@section('content')
    <div class="row">
        <div class="large-12 column">
             <table>
                 <thead align="center" class="BTitrBold">
                 <tr class="small-font">
                     <th>کد طرح</th>
                     <th>کد</th>
                     <th>عنوان</th>
                     <th>شهرستان</th>
                     <th>اعتبار</th>
                     <th>شرح</th>
                 </tr>
                 </thead>
                 <tbody>

                 @foreach($plan as $approvedProjects_prov)
                     <?php
                     $plan = json_decode($approvedProjects_prov);
                     ?>
                     <tr>
                         @foreach($project as $tempProject)
                             <?php
                             $plan = json_decode($tempProject);
                             ?>
                         <td>{{ $project->capital_assets_project->cdtIdNumber . ' - ' . $project->credit_distribution_title->cdtSubject . ' - ' . $project->credit_distribution_title->county->coName }}</td>
                         @endforeach
                             <td>{{$project->capital_assets_project->cpCode}}</td>
                             <td>{{$project->capital_assets_project->cpSubject}}</td>
                             <td>{{$project->capital_assets_project->county->coName}}</td>
                             <td>0</td>
                             <td>{{$project->capital_assets_project->cpDescription}}</td>
                     </tr>
                     <tr>
                         <td colspan="5">
                             <table class="unstriped tbl-secondary-mrg small-font">
                                 <thead class="my-thead">
                                 <tr style="background-color: #F1F1F1 !important;">
                                     <th>ردیف</th>
                                     <th>فصل</th>
                                     <th>عنوان فصل</th>
                                     <th>ریز فصل</th>
                                     <th>نحوه اجرا</th>
                                     <th>مبلغ</th>
                                     <th>توضیحات</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 @foreach($creditSource as $plan_capital_assets)
                                     <?php
                                     $creditSource=json_decode($plan_capital_assets);
                                     ?>
                                     <tr>
                                         <td>{{ $creditSource->credit_distribution_row->cdSubject }}</td>
                                         <td>{{ $creditSource->tiny_season->season_title->season->sSubject }}</td>
                                         <td>{{ $creditSource->tiny_season->season_title->castSubject}}</td>
                                         <td>{{ $creditSource->tiny_season->catsSubject}}</td>
                                         <td>{{ $creditSource->how_to_run->htrSubject }}</td>
                                         <td></td>
                                         <td>{{ $creditSource->creditSource->ccsDescription}}</td>
                                     </tr>
                                 @endforeach
                                 </tbody>
                             </table>
                         </td>
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

