<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CdrCp;
use Modules\Budget\Entities\CreditDistributionRow;

class ProjectController extends Controller
{
    public function approved_projects(){
        return view('budget::pages.approved_projects.main',
            ['pageTitle' => 'ثبت پروژه های مصوب',
                'requireJsFile' => 'approved_projects']);
    }

    public function FetchApprovedProjects(Request $request)
    {
        return \response()->json(
            $this->getAllProject()
        );
    }

    public function getAllProject()
    {
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->with('creditDistributionTitle')
            ->with('capitalAssetsProject')
            ->with('capitalAssetsProject.howToRun')
            ->with('capitalAssetsProject.tinySeason')
            ->with('capitalAssetsProject.cdrCp')->get();
    }

    public function registerCapitalAssetsApprovedProject(Request $request)
    {
        $pInput = $request['pInput'];
        $project = new CapitalAssetsProject;
        $project->cpUId = Auth::user()->id;
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
        return \response()->json(
            $this->getAllProject()
        );
    }

    public function getAllApprovedProjects(Request $request)
    {
        return \response()->json(CapitalAssetsProject::whereHas('capitalAssetsApprovedPlan' , function ($query){
            $query->where('capFyId' , '=' , Auth::user()->seFiscalYear);
        })->get());
    }

}
