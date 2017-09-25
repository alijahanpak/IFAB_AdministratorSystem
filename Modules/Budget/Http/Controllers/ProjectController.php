<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CdrCp;

class ProjectController extends Controller
{
    public function approved_projects(){
        return view('budget::pages.approved_projects.main',
            ['pageTitle' => 'ثبت پروژه های مصوب',
                'requireJsFile' => 'approved_projects']);
    }

    public function FetchApprovedProjects(Request $request)
    {

    }

    public function registerCapitalAssetsApprovedProject(Request $request)
    {
/*        $pInput = $request['pInput'];
        $project = new CapitalAssetsProject;
        $project->cdUId = Auth::user()->id;
        $project->cpCapId = $pInput['apPlan'];
        $project->cpCoId = $pInput['apCity'];
        $project->cpTsId = $pInput['apSubSeason'];
        $project->cpHtrId = $pInput['apHowToRun'];
        $project->cpSubject = $pInput['apProjectTitle'];
        $project->cpCode = $pInput['apProjectCode'];
        $project->cpStartYear = $pInput['apStartYear'];
        $project->cpEndOfYear = $pInput['apEndYear'];
        $project->cpPhysicalProgress = $pInput['apPhysicalProgress'];
        $project->cpDescription = $pInput['apDescription'];
        $project->save();

        $cdrInput = $request['cdrInput'];
        $cdrs = CreditDistributionRow::where('cdPlanOrCost' , 0)->get(); // for capital_assets
        foreach ($cdrs as $cdr) {
            if (isset($cdrInput['apCdr' . $cdr->id]))
            {
                $cdrCp = new CdrCp;
                $cdrCp->ccCpId = $project->id;
                $cdrCp->ccCdrId = $cdr->id;
                $cdrCp->ccAmount = AmountUnit::convertInputAmount($cdrInput['apCdr' . $cdr->id]);
                $cdrCp->save();
            }
        }

        SystemLog::setBudgetSubSystemLog('ثبت پروژه تملک داریی های سرمایه ای استانی ' . $pInput['apProjectTitle']);
        //$cdr = CreditDistributionRow::where('cdPlanOrCost' , $request->planOrCost)->get();
        return \response()->json([]);*/
    }

}
