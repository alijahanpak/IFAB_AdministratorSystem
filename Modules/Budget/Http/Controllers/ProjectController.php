<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CreditDistributionTitle;

class ProjectController extends Controller
{
    public function fetchApprovedProjectData(Request $request)
    {
        return \response()->json(
            $this->getAllProject($request->pOrN , $request->searchValue , $request->itemInPage)
        );
    }

    public function getAllProject($pOrN , $searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);

        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capActive' , '=' , true)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->has('capitalAssetsProject')
            ->where(function($q) use($searchValue){
                return $q->whereHas('capitalAssetsProject' , function($query) use($searchValue){
                    return $query->where('cpSubject' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('cpCode' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhere('cpDescription' , 'LIKE' , '%' . $searchValue . '%')
                        ->orWhereHas('county' , function ($qTemp) use($searchValue){
                            return $qTemp->where('coName' , 'LIKE' , '%' . $searchValue . '%');
                        });
                })->orWhereHas('creditDistributionTitle' , function($query) use($searchValue){
                        return $query->where('cdtIdNumber' , 'LIKE' , '%' . $searchValue . '%')
                            ->orWhere('cdtSubject' , 'LIKE' , '%' . $searchValue . '%');
                    });
            })
            ->with(['capitalAssetsProject' => function($q) use($searchValue){
                return $q->where('cpSubject' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cpCode' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cpDescription' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhereHas('county' , function ($qTemp) use($searchValue){
                        return $qTemp->where('coName' , 'LIKE' , '%' . $searchValue . '%');
                    })
                    ->with('creditSource.creditDistributionRow')
                    ->with('creditSource.tinySeason.seasonTitle.season')
                    ->with('creditSource.howToRun')
                    ->with('county');
            }])
            ->with('creditDistributionTitle.county')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function registerApprovedProject(Request $request)
    {
        $result = DB::transaction(function () use($request){
            if (CapitalAssetsProject::where('cpCode' , '=' , $request->code)->exists())
            {
                return \response()->json([] , 409);
            }else{
                $project = new CapitalAssetsProject;
                $project->cpUId = Auth::user()->id;
                $project->cpCapId = $request->pId;
                $project->cpCoId = $request->coId;
                $project->cpSubject = PublicSetting::checkPersianCharacters($request->subject);
                $project->cpCode = $request->code;
                $project->cpStartYear = $request->startYear;
                $project->cpEndOfYear = $request->endYear;
                $project->cpPhysicalProgress = $request->pProgress;
                $project->cpDescription = PublicSetting::checkPersianCharacters($request->description);
                $project->save();

                SystemLog::setBudgetSubSystemLog('ثبت پروژه تملک داریی های سرمایه ای ' . $request->subject);
                return \response()->json(
                    $this->getAllProject($request->pOrN , $request->searchValue , $request->itemInPage)
                );
            }
        });
        return $result;
    }

    public function deleteApprovedProject(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            $cap = CapitalAssetsProject::find($request->id);
            try {
                $cap->delete();
                SystemLog::setBudgetSubSystemLog('حذف پروژه تملک داریی های سرمایه ای');
                return \response()->json($this->getAllProject($request->pOrN, $request->searchValue, $request->itemInPage));
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
    }

    public function updateApprovedProject(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CapitalAssetsProject::where('id', '<>', $request->id)
                ->where('cpCode', '=', $request->code)->exists()) {
                return \response()->json([], 409);
            } else {
                $old = CapitalAssetsProject::find($request->id);
                $project = CapitalAssetsProject::find($request->id);
                $project->cpUId = Auth::user()->id;
                $project->cpCapId = $request->pId;
                $project->cpCoId = $request->coId;
                $project->cpSubject = PublicSetting::checkPersianCharacters($request->subject);
                $project->cpCode = $request->code;
                $project->cpStartYear = $request->startYear;
                $project->cpEndOfYear = $request->endYear;
                $project->cpPhysicalProgress = $request->pProgress;
                $project->cpDescription = PublicSetting::checkPersianCharacters($request->description);
                $project->save();

                SystemLog::setBudgetSubSystemLog('تغییر در پروژه تملک داریی های سرمایه ای ' . $old->cpSubject);
                return \response()->json(
                    $this->getAllProject($request->pOrN, $request->searchValue, $request->itemInPage)
                );
            }
        });
        return $result;
    }

    public function getAllApprovedProjects(Request $request)
    {
        return \response()->json(CapitalAssetsProject::where('cpCapId' , '=' , $request->pId)->whereHas('capitalAssetsApprovedPlan' , function ($query){
            $query->where('capFyId' , '=' , Auth::user()->seFiscalYear);
        })->get());
    }

    public function registerApCreditSource(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CapCreditSource::where('ccsCapId', '=', $request->capId)
                ->where('ccsCdrId', '=', $request->crId)
                ->where('ccsTsId', '=', $request->tsId)
                ->where('ccsHtrId', '=', $request->htrId)->exists()) {
                return \response()->json([], 409);
            } else {
                $apCs = new CapCreditSource;
                $apCs->ccsUId = Auth::user()->id;
                $apCs->ccsCapId = $request->capId;
                $apCs->ccsCdrId = $request->crId;
                $apCs->ccsTsId = $request->tsId;
                $apCs->ccsHtrId = $request->htrId;
                $apCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
                $apCs->ccsDescription = PublicSetting::checkPersianCharacters($request->description);
                $apCs->save();

                SystemLog::setBudgetSubSystemLog('ثبت تامین اعتبار پروژه تملک داریی های سرمایه ای ' . $request->subject);
                return \response()->json(
                    $this->getAllProject($request->pOrN, $request->searchValue, $request->itemInPage)
                );
            }
        });
        return $result;
    }

    public function updateApCreditSource(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CapCreditSource::where('id', '=', $request->id)
                ->where('ccsCapId', '=', $request->capId)
                ->where('ccsCdrId', '=', $request->crId)
                ->where('ccsTsId', '=', $request->tsId)
                ->where('ccsHtrId', '=', $request->htrId)->exists()) {
                return \response()->json([], 409);
            } else {
                $apCs = CapCreditSource::find($request->id);
                $apCs->ccsUId = Auth::user()->id;
                $apCs->ccsCdrId = $request->crId;
                $apCs->ccsTsId = $request->tsId;
                $apCs->ccsHtrId = $request->htrId;
                $apCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
                $apCs->ccsDescription = PublicSetting::checkPersianCharacters($request->description);
                $apCs->save();

                SystemLog::setBudgetSubSystemLog('تغییر در تامین اعتبار پروژه تملک داریی های سرمایه ای ');
                return \response()->json(
                    $this->getAllProject($request->pOrN, $request->searchValue, $request->itemInPage)
                );
            }
        });
        return $result;
    }

    public function deleteApCreditSource(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            $cs = CapCreditSource::find($request->id);
            try {
                $cs->delete();
                SystemLog::setBudgetSubSystemLog('حذف تامین اعتبار پروژه تملک داریی های سرمایه ای');
                return \response()->json($this->getAllProject($request->pOrN, $request->searchValue, $request->itemInPage));
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
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
