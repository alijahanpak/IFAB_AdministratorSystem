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
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CdrCap;
use Modules\Budget\Entities\CostAgreement;
use Modules\Budget\Entities\CreditDistributionRow;

class PlanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
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
/*        if ($request->pOrN == 0)
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
        }*/
    }

    /////////////////////////////// cost ////////////////////////////////////////////
    public function getAllCostAgreemrent($pOrN)
    {
        return CostAgreement::where('caFyId' , '=' , Auth::user()->seFiscalYear)
            ->where('caProvinceOrNational' , '=' , $pOrN)
            ->with('caCreditSource')
            ->paginate(5);
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
}
