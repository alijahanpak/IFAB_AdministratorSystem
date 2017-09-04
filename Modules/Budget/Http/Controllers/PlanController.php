<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;

class PlanController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function capitalAssetsApprovedPlan(){
        return view('budget::pages.capital_assets_approved_plan.main', ['pageTitle' => 'ثبت طرح های مصوب عمرانی']);
    }

    public function registerCapitalAssetsApprovedPlan(Request $request)
    {
        //$cap = new CapitalAssetsApprovedPlan;
        //$cap->
    }
}
