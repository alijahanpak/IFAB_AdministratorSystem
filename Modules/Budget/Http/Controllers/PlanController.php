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
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CdrCap;
use Modules\Budget\Entities\CreditDistributionRow;

class PlanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function capitalAssetsApprovedPlan(){
        $caps = CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->get();
        return view('budget::pages.capital_assets_approved_plan.main',
            ['caps' => $caps ,
                'pageTitle' => 'ثبت طرح های مصوب عمرانی',
                'requireJsFile' => 'capital_assets_approved_plan']);
    }

    public function registerProvincialCapitalAssetsApprovedPlan(Request $request)
    {
        $cap = new CapitalAssetsApprovedPlan;
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = Input::get('capPtitle');
        $cap->capFyId = Auth::user()->seFiscalYear;
        $cap->capPtId = Input::get('capPlanType');
        $cap->capLetterNumber = Input::get('capLetterNumber');

        $cap->capLetterDate = Input::get('capLetterDate');
        $cap->capExchangeDate = Input::get('capExchangeDate');
        $cap->capDescription = Input::get('capDescription');
        $cap->save();

        foreach (CreditDistributionRow::all() as $cdRow)
        {
            $cdrCap = new CdrCap;
            $cdrCap->ccUId = Auth::user()->id;
            $cdrCap->ccCdrId = $cdRow->id;
            $cdrCap->ccCapId = $cap->id;
            $cdrCap->ccAmount = AmountUnit::convertInputAmount(Input::get('capCdRow' . $cdRow->id));
            $cdrCap->save();
        }

        SystemLog::setBudgetSubSystemLog('ثبت طرح تملک داریی های سرمایه ای استانی');
        return Redirect::to(URL::previous() . '#provincial');
    }

    public function deleteProvincialCapitalAssetsApprovedPlan($capId)
    {
        $cap = CapitalAssetsApprovedPlan::find($capId);
        try {
            CdrCap::where('ccCapId' , '=' , $capId)->delete();
            $logTemp = $cap->creditDistributionTitle->cdtSubject;
            $cap->delete();
            SystemLog::setBudgetSubSystemLog('حذف طرح مصوب استانی ' . $logTemp);
            return Redirect::to(URL::previous() . '#provincial');
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous() . '#provincial')->with('messageDialogPm', 'با توجه به وابستگی اطلاعات، حذف رکورد مورد نظر ممکن نیست!');
            }
        }
    }

    public function PCAPIsExist(Request $request)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (!isset($request->capId)){
                if ((CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capCdtId' , '=' , $request->cdtId)->exists()) || (CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->Where('capLetterNumber' , '=' , $request->letterNumber)->exists()))
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                else
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }
            else{
                if ((CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('id' , '<>' , $request->capId)->where('capCdtId' , '=' , $request->cdtId)->exists()) || (CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('id' , '<>' , $request->capId)->Where('capLetterNumber' , '=' , $request->letterNumber)->exists()))
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                else
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }

        }
    }

    public function updateProvincialCapitalAssetsApprovedPlan(Request $request)
    {
        $cap = CapitalAssetsApprovedPlan::find(Input::get('capId'));
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = Input::get('capPtitle');
        $cap->capPtId = Input::get('capPlanType');
        $cap->capLetterNumber = Input::get('capLetterNumber');

        $cap->capLetterDate = Input::get('capLetterDate');
        $cap->capExchangeDate = Input::get('capExchangeDate');
        $cap->capDescription = Input::get('capDescription');
        $cap->save();

        foreach (CreditDistributionRow::all() as $cdRow)
        {
            CdrCap::where('ccCapId' , '=' , Input::get('capId'))->where('ccCdrId' , '=' , $cdRow->id)
                ->update(['ccAmount' => AmountUnit::convertInputAmount(Input::get('capCdRow' . $cdRow->id)) ,
                    'ccUId' => Auth::user()->id]);
        }

        SystemLog::setBudgetSubSystemLog('تغییر در طرح تملک داریی های سرمایه ای استانی');
        return Redirect::to(URL::previous() . '#provincial');
    }
}
