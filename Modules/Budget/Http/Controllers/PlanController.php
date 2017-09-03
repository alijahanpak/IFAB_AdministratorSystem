<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PlanController extends Controller
{

    public function capitalAssetsApprovedPlan(){
        return view('budget::pages.capital_assets_approved_plan.main', ['pageTitle' => 'ثبت طرح های مصوب عمرانی']);
    }
}
