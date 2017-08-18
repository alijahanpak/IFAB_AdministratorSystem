<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\Village;
use Modules\Budget\Entities\DeprivedArea;

class BudgetAdminController extends Controller
{
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
        $deprivedArea->daUId = 1;
        $deprivedArea->daCoId = Input::get('daCounty');
        $deprivedArea->daReId = Input::get('daRegion');
        $deprivedArea->daRdId = Input::get('daRuralDistrict');
        $deprivedArea->daViId = Input::get('daVillage');
        $deprivedArea->daDescription = Input::get('daDescription');
        $deprivedArea->save();
        return Redirect::to(URL::previous());
    }

    public function fiscalYear()
    {
        return view('budget::pages.fiscal_year');
    }

    public function deleteDeprivedArea($dId)
    {
        $deprivedArea = DeprivedArea::find($dId);
        try {
            $deprivedArea->delete();
            return Redirect::to(URL::previous());
        }
        catch (\Illuminate\Database\QueryException $e) {

            if($e->getCode() == "23000"){ //23000 is sql code for integrity constraint violation
                return Redirect::to(URL::previous())->with('messageDialogPm', 'حذف رکورد مورد نظر در حال حاضر ممکن نیست!');
            }
        }
    }
}
