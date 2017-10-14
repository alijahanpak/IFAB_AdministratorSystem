<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CapCreditSource;
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

    public function fetchApprovedProjectData(Request $request)
    {
        return \response()->json(
            $this->getAllProject($request->pOrN)
        );
    }

    public function getAllProject($pOrN)
    {
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->with('capitalAssetsProject')
            ->whereHas('capitalAssetsProject')
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->with('capitalAssetsProject.creditSource')
            ->with('capitalAssetsProject.creditSource.creditDistributionRow')
            ->with('capitalAssetsProject.creditSource.tinySeason')
            ->with('capitalAssetsProject.creditSource.tinySeason.seasonTitle')
            ->with('capitalAssetsProject.creditSource.tinySeason.seasonTitle.season')
            ->with('capitalAssetsProject.creditSource.howToRun')
            ->with('capitalAssetsProject.county')->paginate(5);
    }

    public function registerApprovedProject(Request $request)
    {
        $project = new CapitalAssetsProject;
        $project->cpUId = Auth::user()->id;
        $project->cpCapId = $request->pId;
        $project->cpCoId = $request->coId;
        $project->cpSubject = $request->subject;
        $project->cpCode = $request->code;
        $project->cpStartYear = $request->startYear;
        $project->cpEndOfYear = $request->endYear;
        $project->cpPhysicalProgress = $request->pProgress;
        $project->cpDescription = $request->description;
        $project->save();

        SystemLog::setBudgetSubSystemLog('ثبت پروژه تملک داریی های سرمایه ای ' . $request->subject);
        return \response()->json(
            $this->getAllProject($request->pOrN)
        );
    }

    public function getAllApprovedProjects(Request $request)
    {
        return \response()->json(CapitalAssetsProject::where('cpCapId' , '=' , $request->pId)->whereHas('capitalAssetsApprovedPlan' , function ($query){
            $query->where('capFyId' , '=' , Auth::user()->seFiscalYear);
        })->get());
    }

    public function registerApCreditSource(Request $request)
    {
        $apCs = new CapCreditSource;
        $apCs->ccsUId = Auth::user()->id;
        $apCs->ccsCapId = $request->capId;
        $apCs->ccsCdrId = $request->crId;
        $apCs->ccsTsId = $request->tsId;
        $apCs->ccsHtrId = $request->htrId;
        $apCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
        $apCs->ccsDescription = $request->description;
        $apCs->save();

        SystemLog::setBudgetSubSystemLog('ثبت تامین اعتبار پروژه تملک داریی های سرمایه ای ' . $request->subject);
        return \response()->json(
            $this->getAllProject($request->pOrN)
        );
    }

    public function getAllApCreditSourceItems(Request $request)
    {
        return \response()->json(
            CapCreditSource::where('ccsCapId' , '=' , $request->pId)
                ->with('creditDistributionRow')
                ->with('tinySeason')
                ->with('tinySeason.seasonTitle')
                ->with('tinySeason.seasonTitle.season')
                ->with('howToRun')->get()
        );
    }
}
