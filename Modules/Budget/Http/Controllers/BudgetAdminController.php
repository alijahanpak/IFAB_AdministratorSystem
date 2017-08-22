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
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\FiscalYear;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\Village;
use Modules\Budget\Entities\CreditDistributionRow;
use Modules\Budget\Entities\DeprivedArea;
use Modules\Budget\Entities\FyPermissionInBudget;

class BudgetAdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['only' => ['deprivedArea' , 'registerDeprivedArea' , 'updateDeprivedArea' , 'deleteDeprivedArea' , 'fiscalYear']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function deprivedArea()
    {
        $dAreas = DeprivedArea::all();
        return view('budget::pages.deprived_area' , ['pageTitle' => 'مناطق محروم' , 'dAreas' => $dAreas]);
    }

    public function registerDeprivedArea(Request $request)
    {

        $deprivedArea = new DeprivedArea;
        $deprivedArea->daUId = Auth::user()->id;
        $deprivedArea->daCoId = Input::get('daCounty');
        $deprivedArea->daReId = Input::get('daRegion');
        $deprivedArea->daRdId = Input::get('daRuralDistrict');
        $deprivedArea->daViId = Input::get('daVillage');
        $deprivedArea->daDescription = Input::get('daDescription');
        $deprivedArea->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف منطقه محروم ' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id));
        return Redirect::to(URL::previous());
    }

    public function fiscalYear()
    {
        return view('budget::pages.fiscal_year', ['pageTitle' => 'سال مالی']);
    }

    public function creditDistributionDef()
    {
        $creditDRs = CreditDistributionRow::all();
        return view('budget::pages.credit_distribution_def' , ['pageTitle' => 'تعاریف توزیع اعتبار' , 'creditDRs' => $creditDRs]);
    }

    public function registerCreditDistributionDef(Request $request)
    {
        $cdr = new CreditDistributionRow;
        $cdr->cdUId = Auth::user()->id;
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تعریف ردیف توزیع اعتبار ' . Input::get('cdrSubject'));
        return Redirect::to(URL::previous());
    }

    public function updateCreditDistributionDef(Request $request)
    {
        $old = CreditDistributionRow::find(Input::get('cdrId'));
        $cdr = CreditDistributionRow::find(Input::get('cdrId'));
        $cdr->cdSubject = Input::get('cdrSubject');
        $cdr->cdDescription = Input::get('cdrDescription');
        $cdr->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در عنوان ردیف توزیع اعتبار (' . $old->cdSubject . ') به (' . Input::get('cdrSubject') . ')');
        return Redirect::to(URL::previous());
    }

    public function deleteCreditDistributionDef($cdId)
    {
        $cdr = CreditDistributionRow::find($cdId);
        try {
            $logTemp = $cdr->cdSubject;
            $cdr->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف ردیف توزیع اعتبار ' . $logTemp);
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {
            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'حذف رکورد مورد نظر در حال حاضر ممکن نیست!');
            }
        }
    }

    public function fiscalYearActivation(Request $request)
    {
        FiscalYear::activation(Input::get('fyId'));
        SystemLog::setBudgetSubSystemAdminLog('فعالسازی سال مالی ' . FiscalYear::find(Input::get('fyId'))->fyLabel  );
        return Redirect::to(URL::previous());
    }

    public function deleteDeprivedArea($dId)
    {
        $deprivedArea = DeprivedArea::find($dId);
        try {
            $logTemp = DeprivedArea::getDeprivedAreaLabel($dId);
            $deprivedArea->delete();
            SystemLog::setBudgetSubSystemAdminLog('حذف منطقه محروم ' . $logTemp);
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {

            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'حذف رکورد مورد نظر در حال حاضر ممکن نیست!');
            }
        }
    }

    public function updateDeprivedArea(Request $request)
    {
        $old = DeprivedArea::getDeprivedAreaLabel(Input::get('daId'));
        $deprivedArea = DeprivedArea::find(Input::get('daId'));
        $deprivedArea->daCoId = Input::get('daCounty');
        $deprivedArea->daReId = Input::get('daRegion');
        $deprivedArea->daRdId = Input::get('daRuralDistrict');
        $deprivedArea->daViId = Input::get('daVillage');
        $deprivedArea->daDescription = Input::get('daDescription');
        $deprivedArea->save();

        SystemLog::setBudgetSubSystemAdminLog('تغییر در منطقه محروم (' . $old . ') به (' . DeprivedArea::getDeprivedAreaLabel($deprivedArea->id) . ')');
        return Redirect::to(URL::previous());
    }


    public function DAIsExist($coId , $reId = null , $rdId = null , $viId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (DeprivedArea::where('daCoId' , '=' , $coId)->where('daReId' , '=' , $reId)->where('daRdId' , '=' , $rdId)->where('daViId' , '=' , $viId)->exists())
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => true]);
            }
            else
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }
        }
    }

    public function DAIsExistForUpdate($daId , $coId , $reId = null , $rdId = null , $viId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if (DeprivedArea::where('id' , '<>' , $daId)->where('daCoId' , '=' , $coId)->where('daReId' , '=' , $reId)->where('daRdId' , '=' , $rdId)->where('daViId' , '=' , $viId)->exists())
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => true]);
            }
            else
            {
                return \Illuminate\Support\Facades\Response::json(['exist' => false]);
            }
        }
    }

    public function CDRIsExist($cdSubject , $cdId = null)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            if ($cdId == null)
            {
                if (CreditDistributionRow::where('cdSubject' , '=' , $cdSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
            else{
                if (CreditDistributionRow::where('id' , '<>' , $cdId)->where('cdSubject' , '=' , $cdSubject)->exists())
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => true]);
                }
                else
                {
                    return \Illuminate\Support\Facades\Response::json(['exist' => false]);
                }
            }
        }
    }

    function changeBudgetItemPermissionState($pbId , $state)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            $fyBudgetPermission = FyPermissionInBudget::find($pbId);
            $fyBudgetPermission->pbStatus = $state;
            $fyBudgetPermission->save();
            return \Illuminate\Support\Facades\Response::json(['state' => true]);
        }
    }


}
