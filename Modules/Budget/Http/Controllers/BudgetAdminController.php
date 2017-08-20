<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\FiscalYear;
use Modules\Admin\Entities\SystemLog;
use Modules\Admin\Entities\Village;
use Modules\Budget\Entities\DeprivedArea;

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
        return view('budget::pages.deprived_area' , ['dAreas' => $dAreas]);
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
        return view('budget::pages.fiscal_year');
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
}
