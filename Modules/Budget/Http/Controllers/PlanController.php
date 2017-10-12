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
        $provinceCaps = CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 0)->get();
        $nationalCaps = CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 1)->get();
        return view('budget::pages.capital_assets_approved_plan.main',
            ['provinceCaps' => $provinceCaps ,
                'nationalCaps' => $nationalCaps ,
                'pageTitle' => 'ثبت طرح های مصوب عمرانی',
                'requireJsFile' => 'capital_assets_approved_plan']);
    }

    public function registerCapitalAssetsApprovedPlan(Request $request)
    {
        $cap = new CapitalAssetsApprovedPlan;
        $cap->capUId = Auth::user()->id;
        $cap->capCdtId = Input::get('capPtitle');
        $cap->capFyId = Auth::user()->seFiscalYear;
        $cap->capLetterNumber = Input::get('capLetterNumber');
        $cap->capLetterDate = Input::get('capLetterDate');
        $cap->capExchangeDate = Input::get('capExchangeDate');
        $cap->capExchangeIdNumber = Input::get('capExchangeDate');
        $cap->capProvinceOrNational = Input::get('capProvinceOrNational');
        $cap->capDescription = Input::get('capDescription');
        $cap->save();

        SystemLog::setBudgetSubSystemLog('ثبت طرح تملک داریی های سرمایه ای استانی');
        return \response()->json([]);
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
        if ($request->pOrN == 0)
        {
            return \response()->json(CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
                ->where('capProvinceOrNational' , '=' , $request->pOrN)
                ->with(['creditDistributionTitle' => function($query){
                    return $query->where('cdtCoId' , '<>' , null);
                }])
                ->with('creditDistributionTitle.county')
                ->get());
        }
        else{
            return \response()->json(CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)
                ->where('capProvinceOrNational' , '=' , $request->pOrN)
                ->with(['creditDistributionTitle' => function($query){
                    return $query->where('cdtCoId' , '=' , null);
                }])
                ->with('creditDistributionTitle.county')
                ->get());
        }
    }
}
