<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Financial\Entities\DepositPercentage;
use Modules\Financial\Entities\DepositPercentageCategory;

class DepositController extends Controller
{
    public function getDepositPercentage(Request $request)
    {
        return \response()->json(
            DepositPercentageCategory::where('dpcState' , true)
                ->with('depositPercentage')
                ->get()
        );
    }
}
