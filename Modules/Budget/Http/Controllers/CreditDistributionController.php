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
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\User;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;

class CreditDistributionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function creditDistributionPlan()
    {
        $cdr = CreditDistributionRow::all();
        $cdt = CreditDistributionTitle::all();
        $counties = County::all();
        $cdPlans = CreditDistributionPlan::select(['cdpCdtId' , 'cdpCdrId' , 'cdpDescription'])->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->groupBy(['cdpCdtId' , 'cdpCdrId' , 'cdpDescription'])->get();
        $cdPlan_rows = CreditDistributionPlan::select(['cdpCdrId'])->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->groupBy(['cdpCdrId'])->get();
        $cdPlan_budgetSeasons = CreditDistributionPlan::join('tbl_credit_distribution_titles' , 'tbl_credit_distribution_titles.id' , '=' , 'cdpCdtId')
            ->join('tbl_budget_seasons' , 'tbl_budget_seasons.id' , '=' , 'tbl_credit_distribution_titles.cdtBsId')
            ->select('tbl_credit_distribution_titles.cdtBsId' , 'tbl_budget_seasons.bsSubject')
            ->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)
            ->groupBy(['tbl_credit_distribution_titles.cdtBsId' , 'tbl_budget_seasons.bsSubject'])
            ->get();
        $cdPlan_counties = CreditDistributionPlan::select(['cdpCoId'])->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->groupBy(['cdpCoId'])->get();
        
        return view('budget::pages.credit_distribution.main', ['pageTitle' => 'طرحهای توزیع اعتبار' ,
            'creditDRs' => $cdr,
            'creditDTs' => $cdt,
            'counties' => $counties,
            'cdPlans' => $cdPlans,
            'cdPlan_rows' => $cdPlan_rows,
            'cdPlan_budgetSeasons' => $cdPlan_budgetSeasons,
            'cdPlan_counties' => $cdPlan_counties,
            'requireJsFile' => 'credit_distribution_plan']);
    }

    public function registerCreditDistributionPlan(Request $request)
    {
        $counties = County::all();
        foreach ($counties as $county)
        {
            $cdp = new CreditDistributionPlan;
            $cdp->cdpUId = Auth::user()->id;
            $cdp->cdpCdtId = Input::get('cdpTitle');
            $cdp->cdpCdrId = Input::get('cdpRow');
            $cdp->cdpFyId = Auth::user()->seFiscalYear;
            $cdp->cdpCoId = $county->id;
            $cdp->cdpCredit = AmountUnit::convertInputAmount(Input::get('cdpCounty' . $county->id));
            $cdp->cdpDescription = Input::get('cdpDescription');
            $cdp->save();
        }

        SystemLog::setBudgetSubSystemLog('اضافه کردن طرح توزیع اعتبار با عنوان ' . $cdp->creditDistributionTitle->cdtSubject . ' در ' . $cdp->creditDistributionRow->cdrSubject);
        return Redirect::to(URL::previous());
    }

    public function deleteCreditDistributionPlan($cdtId , $cdrId)
    {
        echo "morteza";
/*        $cdp = CreditDistributionPlan::where('cdpCdtId' , '=' , $cdtId)
            ->where('cdpCdrId' , '=' , $cdrId)
            ->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
        $cdp->delete();

        SystemLog::setBudgetSubSystemLog('حذف طرح توزیع اعتبار تملک دارییی های سرمایه ای استانی');
        return Redirect::to(URL::previous());*/
    }

    public function CDPIsExist($cdtId , $cdrId)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (CreditDistributionPlan::where('cdpCdtId' , '=' , $cdtId)->where('cdpCdrId' , '=' , $cdrId)->exists())
                return \Illuminate\Support\Facades\Response::json(['exist' => true]);
            else
                return \Illuminate\Support\Facades\Response::json(['exist' => false]);
        }
    }

    public function updateCreditDistributionPlan(Request $request)
    {
        $counties = County::all();
        foreach ($counties as $county)
        {
            $cdp = CreditDistributionPlan::where('cdpCdtId' , '=' , Input::get('cdtId'))
                ->where('cdpCdrId' , '=' , Input::get('cdrId'))
                ->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)
                ->where('cdpCoId' , '=' , $county->id);
            if ($cdp->exists())
            {
                $cdp->update(['cdpCredit' => AmountUnit::convertInputAmount(Input::get('cdpCounty' . $county->id)) , 'cdpDescription' => Input::get('cdpDescription')]);
            }
            else{
                $cdp = new CreditDistributionPlan;
                $cdp->cdpUId = Auth::user()->id;
                $cdp->cdpCdtId = Input::get('cdtId');
                $cdp->cdpCdrId = Input::get('cdrId');
                $cdp->cdpFyId = Auth::user()->seFiscalYear;
                $cdp->cdpCoId = $county->id;
                $cdp->cdpCredit = AmountUnit::convertInputAmount(Input::get('cdpCounty' . $county->id));
                $cdp->cdpDescription = Input::get('cdpDescription');
                $cdp->save();
            }
        }

        SystemLog::setBudgetSubSystemLog('بروز رسانی طرح توزیع اعتبار تملک داریی های سرمایه ای استانی');
        return Redirect::to(URL::previous());
    }
}
