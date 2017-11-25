<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\County;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;

class ChartController extends Controller
{
    public function capitalAssets(Request $request)
    {
        return \response()->json(
            County::all()
        );
    }
}
