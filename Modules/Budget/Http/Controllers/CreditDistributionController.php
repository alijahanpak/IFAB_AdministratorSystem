<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\In;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\User;
use Modules\Budget\Entities\BudgetSeason;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;
use Modules\Budget\Entities\ProvincialBudgetProposal;

class CreditDistributionController extends Controller
{

    ///////////////////////// plans /////////////////////////////////
    public function fetchCreditDistributionPlan(Request $request)
    {
        return \response()->json(['byPlan' => $this->getAllCdPlans(),
            'byRow' => $this->getAllCdPlansOrderByRow(),
            'byBudget' => $this->getAllCdPlansOrderByBudget(),
            'byCounty' => $this->getAllCdPlansOrderByCounty()
            ]);
    }
    
    public function registerCreditDistributionPlan(Request $request)
    {
        if (CreditDistributionPlan::where('cdpCdtId' , '=' , $request->cdtId)
            ->where('cdpCdrId' , '=' , $request->cdrId)
            ->where('cdpCoId' , '=' , $request->coId)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $cdp = new CreditDistributionPlan;
            $cdp->cdpUId = Auth::user()->id;
            $cdp->cdpCdtId = $request->cdtId;
            $cdp->cdpCdrId = $request->cdrId;
            $cdp->cdpFyId = Auth::user()->seFiscalYear;
            $cdp->cdpCoId = $request->coId;
            $cdp->cdpCredit = AmountUnit::convertInputAmount($request->amount);
            $cdp->cdpDescription = $request->description;
            $cdp->save();

            SystemLog::setBudgetSubSystemLog('اضافه کردن طرح توزیع اعتبار با عنوان ' . $cdp->creditDistributionTitle->cdtSubject . ' در ' . $cdp->creditDistributionRow->cdrSubject);
            return \response()->json(['byPlan' => $this->getAllCdPlans(),
                'byRow' => $this->getAllCdPlansOrderByRow(),
                'byBudget' => $this->getAllCdPlansOrderByBudget(),
                'byCounty' => $this->getAllCdPlansOrderByCounty()
            ]);
        }
    }

    public function updateCreditDistributionPlan(Request $request)
    {
        if (CreditDistributionPlan::where('id' , '<>' , $request->id)
            ->where('cdpCdtId' , '=' , $request->cdtId)
            ->where('cdpCdrId' , '=' , $request->cdrId)
            ->where('cdpCoId' , '=' , $request->coId)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $cdp = CreditDistributionPlan::find($request->id);
            $cdp->cdpUId = Auth::user()->id;
            $cdp->cdpCdtId = $request->cdtId;
            $cdp->cdpCdrId = $request->cdrId;
            $cdp->cdpFyId = Auth::user()->seFiscalYear;
            $cdp->cdpCoId = $request->coId;
            $cdp->cdpCredit = AmountUnit::convertInputAmount($request->amount);
            $cdp->cdpDescription = $request->description;
            $cdp->save();

            SystemLog::setBudgetSubSystemLog('بروز رسانی طرح توزیع اعتبار تملک داریی های سرمایه ای استانی');
            return \response()->json(['byPlan' => $this->getAllCdPlans(),
                'byRow' => $this->getAllCdPlansOrderByRow(),
                'byBudget' => $this->getAllCdPlansOrderByBudget(),
                'byCounty' => $this->getAllCdPlansOrderByCounty()
            ]);
        }
    }

    public function deleteCreditDistributionPlan(Request $request)
    {
        try {
            CreditDistributionPlan::where('id' , '=' , $request->id)->delete();
            SystemLog::setBudgetSubSystemLog('حذف طرح توزیع اعتبار تملک دارییی های سرمایه ای استانی');
            return \response()->json(['byPlan' => $this->getAllCdPlans(),
                'byRow' => $this->getAllCdPlansOrderByRow(),
                'byBudget' => $this->getAllCdPlansOrderByBudget(),
                'byCounty' => $this->getAllCdPlansOrderByCounty()
            ]);
        }
        catch (\Illuminate\Database\QueryException $e) {

            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }

    }

    public function getAllCdPlans()
    {
        return CreditDistributionTitle::has('creditDistributionPlan')
            ->whereHas('creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlan.county')
            ->with('creditDistributionPlan.creditDistributionTitle')
            ->with('creditDistributionPlan.creditDistributionRow')
            ->paginate(5);
    }

    public function getAllCdPlansOrderByRow()
    {
        return CreditDistributionRow::has('creditDistributionPlan')
            ->whereHas('creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlan.county')
            ->with('creditDistributionPlan.creditDistributionTitle')
            ->paginate(5);
    }

    public function getAllCdPlansOrderByBudget()
    {
        return BudgetSeason::has('cdpTitleHasCreditDistributionPlan')
            ->whereHas('cdpTitleHasCreditDistributionPlan.creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('cdpTitleHasCreditDistributionPlan.creditDistributionPlan.county')
            ->with('cdpTitleHasCreditDistributionPlan.creditDistributionPlan.creditDistributionTitle')
            ->with('cdpTitleHasCreditDistributionPlan.creditDistributionPlan.creditDistributionRow')
            ->paginate(5);
    }

    public function getAllCdPlansOrderByCounty()
    {
        return County::has('creditDistributionPlan')
            ->whereHas('creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlan.creditDistributionTitle')
            ->with('creditDistributionPlan.creditDistributionRow')
            ->paginate(5);
    }

    public function getPlansWithCountyId(Request $request)
    {
        $temp =CreditDistributionPlan::with(['creditDistributionTitle' , 'creditDistributionRow' , 'creditDistributionTitle.budgetSeason'])
            ->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('cdpCoId' , '=' , $request->coId)->get();
        return \response()->json($temp);
    }

    public function getPlanRemainingAmount(Request $request)
    {
        $proposedAmount = ProvincialBudgetProposal::where('pbpFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('pbpCdpId' , '=' , $request->cdpId)
            ->sum('pbpAmount');
        $cdpAmount = CreditDistributionPlan::where('id' , '=' , $request->cdpId)
            ->first()->cdpCredit;
        return \response()->json(['remainingAmount' => AmountUnit::convertDispAmount($cdpAmount - $proposedAmount)]);
    }

    ///////////////////////// proposal ///////////////////////////
    public function fetchProvincialBudgetProposalData(){

        return \response()->json($this->getAllProvincialBudgetProposal());
    }

    public function getAllProvincialBudgetProposal()
    {
        return County::has('creditDistributionPlanHasProposal')
            ->whereHas('creditDistributionPlanHasProposal' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlanHasProposal.creditDistributionTitle')
            ->with('creditDistributionPlanHasProposal.creditDistributionRow')
            ->with('creditDistributionPlanHasProposal.proposal')
            ->paginate(5);

    }

    public function registerProvincialBudgetProposal(Request $request)
    {
        if (ProvincialBudgetProposal::where('pbpCode' , '=' , $request->pCode)->exists()){
            return \response()->json([] , 409);
        }
        else{
            $pbp = new ProvincialBudgetProposal;
            $pbp->pbpUId = Auth::user()->id;
            $pbp->pbpCdpId = $request->cdpId;
            $pbp->pbpFyId = Auth::user()->seFiscalYear;
            $pbp->pbpAmount = AmountUnit::convertInputAmount($request->pAmount);
            $pbp->pbpSubject = $request->pSubject;
            $pbp->pbpCode = $request->pCode;
            $pbp->pbpDescription = $request->pDescription;
            $pbp->save();

            SystemLog::setBudgetSubSystemLog('ثبت پیشنهاد بودجه تملک داریی های سرمایه ای استانی برای پروژه ' . $pbp->pbpSubject);
            return \response()->json($this->getAllProvincialBudgetProposal());
        }

    }

    public function updateProvincialBudgetProposal(Request $request)
    {
        if (ProvincialBudgetProposal::where('id' , '<>' , $request->id)
            ->where('pbpCode' , '=' , $request->pCode)->exists())
        {
            return \response()->json([] , 409);
        }
        else
        {
            $old = ProvincialBudgetProposal::find($request->id);
            $pbp = ProvincialBudgetProposal::find($request->id);
            $pbp->pbpUId = Auth::user()->id;
            $pbp->pbpCdpId = $request->cdpId;
            $pbp->pbpAmount = AmountUnit::convertInputAmount($request->pAmount);
            $pbp->pbpSubject = $request->pSubject;
            $pbp->pbpCode = $request->pCode;
            $pbp->pbpDescription = $request->pDescription;
            $pbp->save();

            SystemLog::setBudgetSubSystemLog('تغییر در پیشنهاد بودجه تملک داریی های سرمایه ای استانی برای پروژه ' . $old->pbpSubject);
            return \response()->json($this->getAllProvincialBudgetProposal());
        }
    }

    public function deleteProvincialBudgetProposal(Request $request)
    {
        try {
            $cdp = ProvincialBudgetProposal::find($request->id);
            $cdp->delete();

            SystemLog::setBudgetSubSystemLog('حذف پیشنهاد بودجه تملک داریی های سرمایه ای استانی');
            return \response()->json($this->getAllProvincialBudgetProposal());
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return \response()->json([] , 204);
            }
        }
    }
}
