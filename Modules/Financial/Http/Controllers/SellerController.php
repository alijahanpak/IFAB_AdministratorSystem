<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Financial\Entities\Seller;

class SellerController extends Controller
{
    function fetchAllSellers(Request $request)
    {
        return Seller::all();
    }
}
