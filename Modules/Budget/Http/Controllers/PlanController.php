<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\SystemLog;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapCreditSourceTemp;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsApprovedPlanTemp;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CapitalAssetsProjectTemp;
use Modules\Budget\Entities\CdrCap;
use Modules\Budget\Entities\CostAgreement;
use Modules\Budget\Entities\CreditDistributionRow;

class PlanController extends Controller
{
    public function __construct() {
        //$this->middleware('auth');
    }

    public function fetchCapitalAssetsApprovedPlan(Request $request){
        return \response()->json($this->getAllPlans($request->pOrN));
    }

    public function registerCapitalAssetsApprovedPlan(Request $request)
    {
        $cap = new CapitalAssetsApprovedPlan;
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = $request->cdtId;
        $cap->capFyId = Auth::user()->seFiscalYear;
        $cap->capLetterNumber = $request->idNumber;
        $cap->capLetterDate = $request->date;
        $cap->capExchangeIdNumber = $request->exIdNumber;
        $cap->capExchangeDate = $request->exDate;
        $cap->capProvinceOrNational = $request->pOrN;
        $cap->capDescription = $request->description;
        if (isset($request->capId))
            $cap->capCapId = $request->capId;
        $cap->save();



        SystemLog::setBudgetSubSystemLog('ثبت طرح تملک داریی های سرمایه ای استانی');
        return \response()->json($this->getAllPlans($request->pOrN));
    }

    public function getAllPlans($pOrN)
    {
        return CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->paginate(5);
    }

    public function deleteCapitalAssetsApprovedPlan($capId)
    {
        $cap = CapitalAssetsApprovedPlan::find($capId);
        try {
            $logTemp = $cap->creditDistributionTitle->cdtSubject;
            $cap->delete();
            SystemLog::setBudgetSubSystemLog('حذف طرح مصوب تملک داریی های سرمایه ای ' . $logTemp);
            return Redirect::to(URL::previous() . '#provincial');
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous() . '#provincial')->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }

    public function CAPIsExist(Request $request)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (!isset($request->capId)){
                if ((CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
                        ->where('capProvinceOrNational' , '=' , $request->pORn)
                        ->where('capCdtId' , '=' , $request->cdtId)->exists()) ||
                    (CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
                        ->where('capProvinceOrNational' , '=' , $request->pORn)
                        ->Where('capLetterNumber' , '=' , $request->letterNumber)->exists()))
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                else
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }
            else{
                if ((CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
                        ->where('capProvinceOrNational' , '=' , $request->pORn)
                        ->where('id' , '<>' , $request->capId)
                        ->where('capCdtId' , '=' , $request->cdtId)->exists()) ||
                    (CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
                        ->where('capProvinceOrNational' , '=' , $request->pORn)
                        ->where('id' , '<>' , $request->capId)
                        ->Where('capLetterNumber' , '=' , $request->letterNumber)->exists()))
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                else
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }

        }
    }

    public function updateCapitalAssetsApprovedPlan(Request $request)
    {
        $cap = CapitalAssetsApprovedPlan::find(Input::get('capId'));
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = Input::get('capPtitle');
        $cap->capLetterNumber = Input::get('capLetterNumber');
        $cap->capLetterDate = Input::get('capLetterDate');
        $cap->capExchangeDate = Input::get('capExchangeDate');
        $cap->capDescription = Input::get('capDescription');
        $cap->save();

        SystemLog::setBudgetSubSystemLog('تغییر در طرح تملک داریی های سرمایه ای ');
        return Redirect::to(URL::previous() . '#provincial');
    }

    public function getAllApprovedPlan(Request $request)
    {
        return \response()->json(CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('capProvinceOrNational' , '=' , $request->pOrN)
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->get());
    }

    /////////////////////////////// amendment ////////////////////////////////////////////

    public function acceptApprovedAmendment(Request $request)
    {
        $temp = CapitalAssetsApprovedPlanTemp::find($request->capId);
        $cap = new CapitalAssetsApprovedPlan;
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = $temp->capCdtId;
        $cap->capFyId = $temp->capFyId;
        $cap->capLetterNumber = $temp->capLetterNumber;
        $cap->capLetterDate = $temp->capLetterDate;
        $cap->capExchangeIdNumber = $temp->capExchangeIdNumber;
        $cap->capExchangeDate = $temp->capExchangeDate;
        $cap->capProvinceOrNational = $temp->capProvinceOrNational;
        $cap->capDescription = $temp->capDescription;
        $cap->capCapId = $request->parentId;
        $cap->save();

        CapitalAssetsApprovedPlan::where('id' , '=' , $request->parentId)
            ->orWhere('capCapId' , '=' , $request->parentId)
            ->where('id' , '<>' , $cap->id)
            ->update(['capActive' => 0]);

        $pTemps = CapitalAssetsProjectTemp::where('cpCapId' , '=' , $temp->id)->get();
        foreach ($pTemps as $pTemp)
        {
            $project = new CapitalAssetsProject;
            $project->cpUId = $pTemp->cpUId;
            $project->cpCapId = $cap->id;
            $project->cpCoId = $pTemp->cpCoId;
            $project->cpSubject = $pTemp->cpSubject;
            $project->cpCode = $pTemp->cpCode;
            $project->cpStartYear = $pTemp->cpStartYear;
            $project->cpEndOfYear = $pTemp->cpEndOfYear;
            $project->cpPhysicalProgress = $pTemp->cpPhysicalProgress;
            $project->cpDescription = $pTemp->cpDescription;
            $project->save();
        }

    }

    /////////////////////////////// temp ////////////////////////////////////////////

    public function registerApprovedAmendmentTemp(Request $request)
    {
        $old = CapitalAssetsApprovedPlan::find($request->capId);
        $cap = new CapitalAssetsApprovedPlanTemp;
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = $old->capCdtId;
        $cap->capFyId = $old->capFyId;
        $cap->capLetterNumber = $request->idNumber;
        $cap->capLetterDate = $request->date;
        $cap->capExchangeIdNumber = $old->capExchangeIdNumber;
        $cap->capExchangeDate = $old->capExchangeDate;
        $cap->capProvinceOrNational = $old->capProvinceOrNational;
        $cap->capDescription = $request->description;
        $cap->capCapId = $request->capId;
        $cap->save();

        $oldProject = CapitalAssetsProject::where('cpCapId' , '=' , $request->capId)->get();
        foreach ($oldProject as $item)
        {
            $capP = new CapitalAssetsProjectTemp;
            $capP->cpUId = $item->cpUId;
            $capP->cpCapId = $cap->id;
            $capP->cpCoId = $item->cpCoId;
            $capP->cpSubject = $item->cpSubject;
            $capP->cpCode = $item->cpCode;
            $capP->cpStartYear = $item->cpStartYear;
            $capP->cpEndOfYear = $item->cpEndOfYear;
            $capP->cpPhysicalProgress = $item->cpPhysicalProgress;
            $capP->cpDescription = $item->cpDescription;
            $capP->save();

            $oldCreditSource = CapCreditSource::where('ccsCapId' , '=' , $item->id)->get();
            foreach ($oldCreditSource as $csItem)
            {
                $capCs = new CapCreditSourceTemp;
                $capCs->ccsUId = $csItem->ccsUId;
                $capCs->ccsCdrId = $csItem->ccsCdrId;
                $capCs->ccsTsId = $csItem->ccsTsId;
                $capCs->ccsHtrId = $csItem->ccsHtrId;
                $capCs->ccsCapId = $capP->id;
                $capCs->ccsAmount = $csItem->ccsAmount;
                $capCs->ccsDescription = $csItem->ccsDescription;
                $capCs->save();
            }

        }

        return \response()->json($this->getAllTempProjectWithPlanId($cap->id));
    }

    public function registerAmendmentProjectTemp(Request $request)
    {
        $project = new CapitalAssetsProjectTemp;
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

        return \response()->json(
            $this->getAllTempProjectWithPlanId($request->pId)
        );
    }

    public function registerAmendmentProjectCreditSourceTemp(Request $request)
    {
        $apCs = new CapCreditSourceTemp;
        $apCs->ccsUId = Auth::user()->id;
        $apCs->ccsCapId = $request->capId;
        $apCs->ccsCdrId = $request->crId;
        $apCs->ccsTsId = $request->tsId;
        $apCs->ccsHtrId = $request->htrId;
        $apCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
        $apCs->ccsDescription = $request->description;
        $apCs->save();

        return \response()->json(
            $this->getAllTempProjectWithPlanId($request->pId)
        );
    }

    public function cancelApprovedAmendmentTemp(Request $request)
    {
        if (isset($request->capId))
        {
            return \response()->json(CapitalAssetsApprovedPlanTemp::find($request->capId)->delete());
        }else{
            return \response()->json(
                CapitalAssetsApprovedPlanTemp::where('capUId' , '=' , Auth::user()->id)->delete()
            );
        }
    }

    public function getAllTempProjectWithPlanId($pId)
    {
        return CapitalAssetsApprovedPlanTemp::where('id' , '=' , $pId)
            ->has('capitalAssetsProject')
            ->with('capitalAssetsProject')
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->with('capitalAssetsProject.creditSource')
            ->with('capitalAssetsProject.creditSource.creditDistributionRow')
            ->with('capitalAssetsProject.creditSource.tinySeason')
            ->with('capitalAssetsProject.creditSource.tinySeason.seasonTitle')
            ->with('capitalAssetsProject.creditSource.tinySeason.seasonTitle.season')
            ->with('capitalAssetsProject.creditSource.howToRun')
            ->with('capitalAssetsProject.county')->first();
    }

    /////////////////////////////// cost ////////////////////////////////////////////
    public function getAllCostAgreemrent($pOrN)
    {
        return CostAgreement::where('caFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('caProvinceOrNational' , '=' , $pOrN)
            ->with('caCreditSource')
            ->with('caCreditSource.tinySeason.seasonTitle.season')
            ->with('caCreditSource.creditDistributionRow')
            ->with('caCreditSource.creditDistributionTitle')
            ->paginate(20);
    }

    public function fetchCostAgreementData(Request $request)
    {
        return \response()->json(
            $this->getAllCostAgreemrent($request->pOrN)
        );
    }

    public function registerCostAgreement(Request $request)
    {
        $ca = new CostAgreement;
        $ca->caUId = Auth::user()->id;
        $ca->caFyId = Auth::user()->seFiscalYear;
        $ca->caProvinceOrNational = $request->pOrN;
        $ca->caLetterNumber = $request->idNumber;
        $ca->caLetterDate = $request->date;
        $ca->caExchangeIdNumber = $request->exIdNumber;
        $ca->caExchangeDate = $request->exDate;
        $ca->caDescription = $request->description;
        $ca->save();

        SystemLog::setBudgetSubSystemLog('ثبت موافقت نامه هزینه ای ');
        return \response()->json($this->getAllCostAgreemrent($request->pOrN));
    }

    public function registerCaCreditSource(Request $request)
    {
        $caCs = new CaCreditSource;
        $caCs->ccsUId = Auth::user()->id;
        $caCs->ccsCaId = $request->caId;
        $caCs->ccsCdrId = $request->crId;
        $caCs->ccsTsId = $request->tsId;
        $caCs->ccsCdtId = $request->cdtId;
        $caCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
        $caCs->ccsDescription = $request->description;
        $caCs->save();

        SystemLog::setBudgetSubSystemLog('ثبت تامین اعتبار هزینه ای ' . $request->subject);
        return \response()->json(
            $this->getAllCostAgreemrent($request->pOrN)
        );
    }

    public function getAllCaItems(Request $request)
    {
        return \response()->json(
            CostAgreement::where('caFyId' , '=' , Auth::user()->seFiscalYear)
                ->where('caProvinceOrNational' , '=' , $request->pOrN)
                ->get()
        );
    }
    public function getAllcaCreditSourceItems(Request $request)
    {
        return \response()->json(
            CaCreditSource::where('ccsCaId' , '=' , $request->caId)
                ->with('creditDistributionRow')
                ->with('creditDistributionTitle')
                ->with('tinySeason.seasonTitle.season')
                ->get()
        );
    }
}
