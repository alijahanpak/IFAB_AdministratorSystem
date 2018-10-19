<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\AmountUnit;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
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
        return \response()->json(
            $this->getAllCdPlans($request->searchValue , $request->itemInPage)
        );
    }

    public function fetchCreditDistributionPlanByRow(Request $request)
    {
        return \response()->json(
            $this->getAllCdPlansOrderByRow($request->searchValue , $request->itemInPage)
        );
    }

    public function fetchCreditDistributionPlanByBudgetSeason(Request $request)
    {
        return \response()->json(
            $this->getAllCdPlansOrderByBudget($request->searchValue , $request->itemInPage)
        );
    }

    public function fetchCreditDistributionPlanByCounty(Request $request)
    {
        return \response()->json(
            $this->getAllCdPlansOrderByCounty($request->searchValue , $request->itemInPage)
        );
    }
    
    public function registerCreditDistributionPlan(Request $request)
    {
        $result = DB::transaction(function () use($request){
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
                $cdp->cdpDescription = PublicSetting::checkPersianCharacters($request->description);
                $cdp->save();

                SystemLog::setBudgetSubSystemLog('اضافه کردن طرح توزیع اعتبار با عنوان ' . $cdp->creditDistributionTitle->cdtSubject . ' در ' . $cdp->creditDistributionRow->cdrSubject);
                return \response()->json(
                    $this->getAllCdPlans($request->searchValue , $request->itemInPage)
                );
            }
        });
        return $result;
    }

    public function updateCreditDistributionPlan(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (CreditDistributionPlan::where('id', '<>', $request->id)
                ->where('cdpCdtId', '=', $request->cdtId)
                ->where('cdpCdrId', '=', $request->cdrId)
                ->where('cdpCoId', '=', $request->coId)->exists()) {
                return \response()->json([], 409);
            } else {
                $cdp = CreditDistributionPlan::find($request->id);
                $cdp->cdpUId = Auth::user()->id;
                $cdp->cdpCdtId = $request->cdtId;
                $cdp->cdpCdrId = $request->cdrId;
                $cdp->cdpFyId = Auth::user()->seFiscalYear;
                $cdp->cdpCoId = $request->coId;
                $cdp->cdpCredit = AmountUnit::convertInputAmount($request->amount);
                $cdp->cdpDescription = PublicSetting::checkPersianCharacters($request->description);
                $cdp->save();

                SystemLog::setBudgetSubSystemLog('بروز رسانی طرح توزیع اعتبار تملک داریی های سرمایه ای استانی');
                return \response()->json(
                    $this->getAllCdPlans($request->searchValue, $request->itemInPage)
                );
            }
        });
        return $result;
    }

    public function deleteCreditDistributionPlan(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            try {
                CreditDistributionPlan::where('id', '=', $request->id)->delete();
                SystemLog::setBudgetSubSystemLog('حذف طرح توزیع اعتبار تملک دارییی های سرمایه ای استانی');
                return \response()->json(
                    $this->getAllCdPlans($request->searchValue, $request->itemInPage)
                );
            } catch (\Illuminate\Database\QueryException $e) {

                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;

    }

    public function getAllCdPlans($searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return CreditDistributionTitle::has('creditDistributionPlan')
            ->where(function($query) use($searchValue){
                return $query->where('cdtIdNumber' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('cdtSubject' , '%' . $searchValue . '%');
            })
            ->whereHas('creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlan.county')
            ->with('creditDistributionPlan.creditDistributionTitle')
            ->with('creditDistributionPlan.creditDistributionRow')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function getAllCdPlansOrderByRow($searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return CreditDistributionRow::has('creditDistributionPlan')
            ->where(function($query) use($searchValue){
                return $query->where('cdSubject' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->whereHas('creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlan.county')
            ->with('creditDistributionPlan.creditDistributionTitle')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function getAllCdPlansOrderByBudget($searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return BudgetSeason::has('cdpTitleHasCreditDistributionPlan')
            ->where(function($query) use($searchValue){
                return $query->where('bsSubject' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->whereHas('cdpTitleHasCreditDistributionPlan.creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('cdpTitleHasCreditDistributionPlan.creditDistributionPlan.county')
            ->with('cdpTitleHasCreditDistributionPlan.creditDistributionPlan.creditDistributionTitle')
            ->with('cdpTitleHasCreditDistributionPlan.creditDistributionPlan.creditDistributionRow')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function getAllCdPlansOrderByCounty($searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return County::has('creditDistributionPlan')
            ->where(function($query) use($searchValue){
                return $query->where('coName' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->whereHas('creditDistributionPlan' , function($q){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlan.creditDistributionTitle')
            ->with('creditDistributionPlan.creditDistributionRow')
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);
    }

    public function getPlansWithCountyId(Request $request)
    {
        $temp = CreditDistributionPlan::with(['creditDistributionTitle' , 'creditDistributionRow' , 'creditDistributionTitle.budgetSeason'])
            ->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('cdpCoId' , '=' , $request->coId)
            ->orderBy('id', 'DESC')->get();
        return \response()->json($temp);
    }

    public function getPlanRemainingAmount(Request $request)
    {
        $proposedAmount = ProvincialBudgetProposal::where('pbpFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('pbpCdpId' , '=' , $request->cdpId)
            ->sum('pbpAmount');
        $cdpAmount = CreditDistributionPlan::where('id' , '=' , $request->cdpId)
            ->first()->cdpCredit;
        return \response()->json(['remainingAmount' => $cdpAmount - $proposedAmount]);
    }

    ///////////////////////// proposal ///////////////////////////
    public function fetchProvincialBudgetProposalData(Request $request){

        return \response()->json($this->getAllProvincialBudgetProposal($request->searchValue , $request->itemInPage));
    }

    public function getAllProvincialBudgetProposal($searchValue , $itemInPage)
    {
        $searchValue = PublicSetting::checkPersianCharacters($searchValue);
        return County::has('creditDistributionPlanHasProposal')
            ->whereHas('creditDistributionPlanHasProposal' , function($q) use($searchValue){
                return $q->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
            })
            ->with('creditDistributionPlanHasProposal.creditDistributionTitle')
            ->with('creditDistributionPlanHasProposal.creditDistributionRow')
            ->with('creditDistributionPlanHasProposal.proposal')
            ->whereHas('creditDistributionPlanHasProposal.proposal' , function ($query) use($searchValue){
                return $query->where('pbpCode' , 'LIKE' , '%' . $searchValue . '%')
                    ->orWhere('pbpSubject' , 'LIKE' , '%' . $searchValue . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate($itemInPage);

    }

    public function registerProvincialBudgetProposal(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (ProvincialBudgetProposal::where('pbpCode', '=', $request->pCode)->exists()) {
                return \response()->json([], 409);
            } else {
                $pbp = new ProvincialBudgetProposal;
                $pbp->pbpUId = Auth::user()->id;
                $pbp->pbpCdpId = $request->cdpId;
                $pbp->pbpFyId = Auth::user()->seFiscalYear;
                $pbp->pbpAmount = AmountUnit::convertInputAmount($request->pAmount);
                $pbp->pbpSubject = PublicSetting::checkPersianCharacters($request->pSubject);
                $pbp->pbpCode = $request->pCode;
                $pbp->pbpDescription = PublicSetting::checkPersianCharacters($request->pDescription);
                $pbp->save();

                SystemLog::setBudgetSubSystemLog('ثبت پیشنهاد بودجه تملک داریی های سرمایه ای استانی برای پروژه ' . $pbp->pbpSubject);
                return \response()->json($this->getAllProvincialBudgetProposal($request->searchValue, $request->itemInPage));
            }
        });
        return $result;
    }

    public function updateProvincialBudgetProposal(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            if (ProvincialBudgetProposal::where('id', '<>', $request->id)
                ->where('pbpCode', '=', $request->pCode)->exists()) {
                return \response()->json([], 409);
            } else {
                $old = ProvincialBudgetProposal::find($request->id);
                $pbp = ProvincialBudgetProposal::find($request->id);
                $pbp->pbpUId = Auth::user()->id;
                $pbp->pbpCdpId = $request->cdpId;
                $pbp->pbpAmount = AmountUnit::convertInputAmount($request->pAmount);
                $pbp->pbpSubject = PublicSetting::checkPersianCharacters($request->pSubject);
                $pbp->pbpCode = $request->pCode;
                $pbp->pbpDescription = PublicSetting::checkPersianCharacters($request->pDescription);
                $pbp->save();

                SystemLog::setBudgetSubSystemLog('تغییر در پیشنهاد بودجه تملک داریی های سرمایه ای استانی برای پروژه ' . $old->pbpSubject);
                return \response()->json($this->getAllProvincialBudgetProposal($request->searchValue, $request->itemInPage));
            }
        });
        return $result;
    }

    public function deleteProvincialBudgetProposal(Request $request)
    {
        $result = DB::transaction(function () use($request) {
            try {
                $cdp = ProvincialBudgetProposal::find($request->id);
                $cdp->delete();

                SystemLog::setBudgetSubSystemLog('حذف پیشنهاد بودجه تملک داریی های سرمایه ای استانی');
                return \response()->json($this->getAllProvincialBudgetProposal($request->searchValue, $request->itemInPage));
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == "23000") { //23000 is sql code for integrity constraint violation
                    return \response()->json([], 204);
                }
            }
        });
        return $result;
    }
}
