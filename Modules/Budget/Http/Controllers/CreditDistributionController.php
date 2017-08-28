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
use Modules\Admin\Entities\User;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\CreditDistributionTitle;

class CreditDistributionController extends Controller
{
    public function creditDistributionPlan()
    {
        $cdr = CreditDistributionRow::all();
        $cdt = CreditDistributionTitle::all();
        $counties = County::all();
        //$cdPlans = CreditDistributionPlan::where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->get();
        $cdPlans = CreditDistributionPlan::select(['cdpCdtId' , 'cdpCdrId'])->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->groupBy(['cdpCdtId' , 'cdpCdrId'])->get();
        return view('budget::pages.credit_distribution.main', ['pageTitle' => 'طرحهای توزیع اعتبار' ,
            'creditDRs' => $cdr,
            'creditDTs' => $cdt,
            'counties' => $counties,
            'cdPlans' => $cdPlans,
            'requireJsFile' => 'credit_distribution_plan']);
    }

    public function registerCreditDistributionPlan(Request $request)
    {
        $counties = County::all();
        foreach ($counties as $county)
        {
            $cdp = new CreditDistributionPlan;
            $cdp->cdpUId = Auth::user()->id;
            $cdp->cdpCdtId = Input::get('cdpPlanTitle');
            $cdp->cdpCdrId = Input::get('cdpRowTitle');
            $cdp->cdpFyId = Auth::user()->seFiscalYear;
            $cdp->cdpCoId = $county->id;
            $cdp->cdpCredit = AmountUnit::convertInputAmount(Input::get('cdpCounty' . $county->id));
            $cdp->cdpDescription = Input::get('cdpDescription');
            $cdp->save();
        }

        return Redirect::to(URL::previous());
    }

    public function deleteCreditDistributionPlan($cdtId , $cdrId)
    {
        $cdp = CreditDistributionPlan::where('cdpCdtId' , '=' , $cdtId)
            ->where('cdpCdrId' , '=' , $cdrId)
            ->where('cdpFyId' , '=' , Auth::user()->seFiscalYear);
        $cdp->delete();
        return Redirect::to(URL::previous());
    }

    public function CDPIsExist($cdtId , $cdpId)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {

        }
    }
}
