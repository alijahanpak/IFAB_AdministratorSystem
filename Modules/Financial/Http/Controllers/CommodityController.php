<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Financial\Entities\Commodity;
use Modules\Financial\Entities\RequestCommodity;

class CommodityController extends Controller
{
    public function fetchAllCommodities()
    {
        $comm = Commodity::all();
        return \response()->json($comm);
    }
}
