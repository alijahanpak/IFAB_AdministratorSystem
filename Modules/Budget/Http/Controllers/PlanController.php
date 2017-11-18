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
use Modules\Budget\Entities\CaCreditSourceTemp;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapCreditSourceTemp;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsApprovedPlanTemp;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CapitalAssetsProjectTemp;
use Modules\Budget\Entities\CdrCap;
use Modules\Budget\Entities\CostAgreement;
use Modules\Budget\Entities\CostAgreementTemp;
use Modules\Budget\Entities\CostAllocation;
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
            ->where('capActive' , '=' , true)
            ->where('capProvinceOrNational' , '=' , $pOrN)
            ->with('creditDistributionTitle')
            ->with('creditDistributionTitle.county')
            ->with('amendments.creditDistributionTitle')
            ->with('amendments.creditDistributionTitle.county')
            ->with('amendments.capitalAssetsProject.creditSource.creditDistributionRow')
            ->with('amendments.capitalAssetsProject.creditSource.tinySeason.seasonTitle.season')
            ->with('amendments.capitalAssetsProject.creditSource.howToRun')
            ->with('amendments.capitalAssetsProject.county')
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
            ->where('capActive' , '=' , true)
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
        $cap->save();

        CapitalAssetsApprovedPlan::where('id' , '=' , $request->parentId)
            ->orWhere('capCapId' , '=' , $request->parentId)
            ->update(['capActive' => 0 , 'capCapId' => $cap->id]);

        $pTemps = CapitalAssetsProjectTemp::where('cpCapId' , '=' , $temp->id)->get();
        foreach ($pTemps as $pTemp)
        {
            if ($pTemp->cpDeleted == 0)
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

                if ($pTemp->cpCpId != null)
                {
                    CapitalAssetsProject::where('id' , '=' , $pTemp->cpCpId)
                        ->orWhere('cpCpId' , '=' , $pTemp->cpCpId)
                        ->update(['cpActive' => 0 , 'cpCpId' => $project->id]);
                }

                $csTemps = CapCreditSourceTemp::where('ccsCapId' , '=' , $pTemp->id)->get();
                foreach ($csTemps as $csTemp) {
                    if ($csTemp->ccsDeleted == 0)
                    {
                        $cs = new CapCreditSource;
                        $cs->ccsUId = $csTemp->ccsUId;
                        $cs->ccsCdrId = $csTemp->ccsCdrId;
                        $cs->ccsTsId = $csTemp->ccsTsId;
                        $cs->ccsHtrId = $csTemp->ccsHtrId;
                        $cs->ccsCapId = $project->id;
                        $cs->ccsAmount = $csTemp->ccsAmount;
                        $cs->ccsDescription = $csTemp->ccsDescription;
                        $cs->save();

                        CapitalAssetsAllocation::where('caaCcsId' , '=' , $csTemp->ccsCcsId)
                            ->update(['caaCcsId' => $cs->id]);
                    }elseif ($csTemp->ccsCcsId != null){
                        CapCreditSource::where('id' , '=' , $csTemp->ccsCcsId)->update(['ccsDeleted' => 1]);
                        CapitalAssetsAllocation::where('caaCcsId' , $csTemp->ccsCcsId)->update(['caaAmount' => 0]);
                    }
                }
            }elseif ($pTemp->cpCpId != null){
                CapitalAssetsProject::where('id' , '=' , $pTemp->cpCpId)->update(['cpDeleted' => 1 , 'cpActive' => 0]);
                CapCreditSource::where('ccsCapId' , '=' , $pTemp->cpCpId)->update(['ccsDeleted' => 1]);
                CapitalAssetsAllocation::whereIn('caaCcsId' , CapCreditSource::where('ccsCapId' , '=' , $pTemp->cpCpId)->pluck('id'))->update(['caaAmount' => 0]);
            }
        }

        CapitalAssetsApprovedPlanTemp::find($request->capId)->delete();
        return \response()->json($this->getAllPlans($temp->capProvinceOrNational));

    }

    /////////////////////////////// capital assets temp ////////////////////////////////////////////

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
        $cap->save();

        $oldProject = CapitalAssetsProject::where('cpCapId' , '=' , $request->capId)->get();
        foreach ($oldProject as $item)
        {
            $capP = new CapitalAssetsProjectTemp;
            $capP->cpUId = $item->cpUId;
            $capP->cpCapId = $cap->id;
            $capP->cpCpId = $item->id;
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
                $capCs->ccsCcsId = $csItem->id;
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

    public function updateAmendmentProjectTemp(Request $request)
    {
        $project = CapitalAssetsProjectTemp::find($request->cpId);
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

    public function deleteAmendmentProjectTemp(Request $request)
    {
        CapCreditSourceTemp::where('ccsCapId' , '=' , $request->pId)
            ->update(['ccsDeleted' => 1]);
        CapitalAssetsProjectTemp::where('id' , '=' , $request->pId)
            ->update(['cpDeleted' => 1]);
        return \response()->json(
            $this->getAllTempProjectWithPlanId($request->capId)
        );
    }

    public function deleteAmendmentProjectCreditSourceTemp(Request $request)
    {
        CapCreditSourceTemp::where('id' , '=' , $request->csId)
            ->update(['ccsDeleted' => 1]);
        return \response()->json(
            $this->getAllTempProjectWithPlanId($request->capId)
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

    public function updateAmendmentProjectCreditSourceTemp(Request $request)
    {
        $apCs = CapCreditSourceTemp::find($request->csId);
        $apCs->ccsUId = Auth::user()->id;
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
            ->where('caActive' , '=' , true)
            ->where('caProvinceOrNational' , '=' , $pOrN)
            ->with('caCreditSource')
            ->with('caCreditSource.tinySeason.seasonTitle.season')
            ->with('caCreditSource.creditDistributionRow')
            ->with('caCreditSource.creditDistributionTitle')
            ->with('amendments')
            ->with('amendments.caCreditSource.tinySeason.seasonTitle.season')
            ->with('amendments.caCreditSource.creditDistributionRow')
            ->with('amendments.caCreditSource.creditDistributionTitle')
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
        if (CostAgreement::where('caLetterNumber' , '=' , $request->idNumber)->exists())
        {
            return \response()->json([] , 409);
        }else{
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
    }

    public function updateCostAgreement(Request $request)
    {
        if (CostAgreement::where('id' , '<>' , $request->id)
            ->where('caLetterNumber' , '=' , $request->idNumber)->exists())
        {
            return \response()->json([] , 409);
        }else{
            $ca = CostAgreement::find($request->id);
            $ca->caUId = Auth::user()->id;
            $ca->caLetterNumber = $request->idNumber;
            $ca->caLetterDate = $request->date;
            $ca->caExchangeIdNumber = $request->exIdNumber;
            $ca->caExchangeDate = $request->exDate;
            $ca->caDescription = $request->description;
            $ca->save();

            SystemLog::setBudgetSubSystemLog('تغییر موافقت نامه هزینه ای ');
            return \response()->json($this->getAllCostAgreemrent($request->pOrN));
        }
    }

    public function deleteCostAgreement(Request $request)
    {
        $ca = CostAgreement::find($request->id);
        try {
            $ca->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف موافقت نامه هزینه ای');
            return \response()->json($this->getAllCostAgreemrent($request->pOrN));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }

    public function registerCaCreditSource(Request $request)
    {
        if (CaCreditSource::where('ccsCdrId' , '=' , $request->crId)
            ->where('ccsCaId' , '=' , $request->caId)
            ->where('ccsTsId' , '=' , $request->tsId)
            ->where('ccsCdtId' , '=' , $request->cdtId)->exists())
        {
            return \response()->json([] , 409);
        }else{
            $caCs = new CaCreditSource;
            $caCs->ccsUId = Auth::user()->id;
            $caCs->ccsCaId = $request->caId;
            $caCs->ccsCdrId = $request->crId;
            $caCs->ccsTsId = $request->tsId;
            $caCs->ccsCdtId = $request->cdtId;
            $caCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
            $caCs->ccsDescription = $request->description;
            $caCs->save();

            SystemLog::setBudgetSubSystemLog('ثبت تامین اعتبار هزینه ای');
            return \response()->json(
                $this->getAllCostAgreemrent($request->pOrN)
            );
        }
    }

    public function updateCaCreditSource(Request $request)
    {
        if (CaCreditSource::where('id' , '<>' , $request->id)
                ->where('ccsCdrId' , '=' , $request->crId)
                ->where('ccsTsId' , '=' , $request->tsId)
                ->where('ccsCdtId' , '=' , $request->cdtId)->exists())
        {
            return \response()->json([] , 409);
        }else{
            $caCs = CaCreditSource::find($request->id);
            $caCs->ccsUId = Auth::user()->id;
            $caCs->ccsCdrId = $request->crId;
            $caCs->ccsTsId = $request->tsId;
            $caCs->ccsCdtId = $request->cdtId;
            $caCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
            $caCs->ccsDescription = $request->description;
            $caCs->save();

            SystemLog::setBudgetSubSystemLog('تغییر تامین اعتبار هزینه ای');
            return \response()->json(
                $this->getAllCostAgreemrent($request->pOrN)
            );
        }
    }

    public function deleteCostCaCreditSource(Request $request)
    {
        $cs = CaCreditSource::find($request->id);
        try {
            $cs->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف تامین اعتبار هزینه ای');
            return \response()->json($this->getAllCostAgreemrent($request->pOrN));
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }

    public function getAllCaItems(Request $request)
    {
        return \response()->json(
            CostAgreement::where('caFyId' , '=' , Auth::user()->seFiscalYear)
                ->where('caActive' , '=' , true)
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

    public function acceptCostAmendment(Request $request)
    {
        $newCa = new CostAgreement;
        $temp = CostAgreementTemp::find($request->caId);
        $newCa->caUId = Auth::user()->id;
        $newCa->caFyId = $temp->caFyId;
        $newCa->caProvinceOrNational = $temp->caProvinceOrNational;
        $newCa->caLetterNumber = $temp->caLetterNumber;
        $newCa->caLetterDate = $temp->caLetterDate;
        $newCa->caExchangeIdNumber = $temp->caExchangeIdNumber;
        $newCa->caExchangeDate = $temp->caExchangeDate;
        $newCa->caDescription = $temp->caDescription;
        $newCa->save();

        CostAgreement::where('id' , '=' , $request->parentId)
            ->orWhere('caCaId' , '=' , $request->parentId)
            ->update(['caActive' => 0 , 'caCaId' => $newCa->id]);

        $csTemps = CaCreditSourceTemp::where('ccsCaId' , '=' , $temp->id)->get();
        foreach ($csTemps as $csTemp) {
            if ($csTemp->ccsDeleted == 0)
            {
                $cs = new CaCreditSource;
                $cs->ccsUId = $csTemp->ccsUId;
                $cs->ccsCdrId = $csTemp->ccsCdrId;
                $cs->ccsTsId = $csTemp->ccsTsId;
                $cs->ccsCdtId = $csTemp->ccsCdtId;
                $cs->ccsCaId = $newCa->id;
                $cs->ccsAmount = $csTemp->ccsAmount;
                $cs->ccsDescription = $csTemp->ccsDescription;
                $cs->save();

                CostAllocation::where('caCcsId' , '=' , $csTemp->ccsCcsId)
                    ->update(['caCcsId' => $cs->id]);
            }elseif ($csTemp->ccsCcsId != null){
                CaCreditSource::where('id' , '=' , $csTemp->ccsCcsId)->update(['ccsDeleted' => 1]);
                CostAllocation::where('caCcsId' , $csTemp->ccsCcsId)->update(['caAmount' => 0]);
            }
        }

        CostAgreementTemp::find($request->caId)->delete();
        return \response()->json(
            $this->getAllCostAgreemrent($temp->caProvinceOrNational)
        );
    }

    /////////////////////////////// cost temp /////////////////////////////
    public function registerCostAmendmentTemp(Request $request)
    {
        $old = CostAgreement::find($request->caId);
        $ca = new CostAgreementTemp;
        $ca->caUId = Auth::user()->id;
        $ca->caFyId = $old->caFyId;
        $ca->caProvinceOrNational = $old->caProvinceOrNational;
        $ca->caLetterNumber = $request->idNumber;
        $ca->caLetterDate = $request->date;
        $ca->caExchangeIdNumber = $old->caExchangeIdNumber;
        $ca->caExchangeDate = $old->caExchangeDate;
        $ca->caDescription = $request->description;
        $ca->save();

        $caCreditSources = CaCreditSource::where('ccsCaId' , '=' , $request->caId)->get();
        foreach ($caCreditSources as $item)
        {
            $newCa = new CaCreditSourceTemp;
            $newCa->ccsUId = Auth::user()->id;
            $newCa->ccsCdrId = $item->ccsCdrId;
            $newCa->ccsCcsId = $item->id;
            $newCa->ccsTsId = $item->ccsTsId;
            $newCa->ccsCaId = $ca->id;
            $newCa->ccsCdtId = $item->ccsCdtId;
            $newCa->ccsAmount = $item->ccsAmount;
            $newCa->ccsDescription = $item->ccsDescription;
            $newCa->save();
        }

        return \response()->json($this->getAllCaTempItems($ca->id));
    }

    public function cancelCostAmendmentTemp(Request $request)
    {
        if (isset($request->caId))
        {
            return \response()->json(CostAgreementTemp::find($request->caId)->delete());
        }else{
            return \response()->json(
                CostAgreementTemp::where('caUId' , '=' , Auth::user()->id)->delete()
            );
        }
    }

    public function getAllCaTempItems($caId)
    {
        return CostAgreementTemp::where('id' , '=' , $caId)
                ->with('caCreditSource')
                ->with('caCreditSource.creditDistributionTitle')
                ->with('caCreditSource.creditDistributionRow')
                ->with('caCreditSource.tinySeason')
                ->with('caCreditSource.tinySeason.seasonTitle')
                ->with('caCreditSource.tinySeason.seasonTitle.season')
                ->first();
    }

    public function registerCostAmendmentCreditSourceTemp(Request $request)
    {
        $caCs = new CaCreditSourceTemp;
        $caCs->ccsUId = Auth::user()->id;
        $caCs->ccsCaId = $request->caId;
        $caCs->ccsCdrId = $request->crId;
        $caCs->ccsTsId = $request->tsId;
        $caCs->ccsCdtId = $request->cdtId;
        $caCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
        $caCs->ccsDescription = $request->description;
        $caCs->save();

        return \response()->json($this->getAllCaTempItems($request->caId));
    }

    public function deleteCostAmendmentCreditSourceTemp(Request $request)
    {
        CaCreditSourceTemp::where('id' , '=' , $request->csId)
            ->update(['ccsDeleted' => 1]);
        return \response()->json(
            $this->getAllCaTempItems($request->caId)
        );
    }

    public function updateCostAmendmentCreditSourceTemp(Request $request)
    {
        $caCs = CaCreditSourceTemp::find($request->csId);
        $caCs->ccsUId = Auth::user()->id;
        $caCs->ccsCdrId = $request->crId;
        $caCs->ccsTsId = $request->tsId;
        $caCs->ccsCdtId = $request->cdtId;
        $caCs->ccsAmount = AmountUnit::convertInputAmount($request->amount);
        $caCs->ccsDescription = $request->description;
        $caCs->save();

        return \response()->json($this->getAllCaTempItems($request->caId));
    }

}
