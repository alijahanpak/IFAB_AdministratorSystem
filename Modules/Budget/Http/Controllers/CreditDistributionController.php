<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CreditDistributionController extends Controller
{
    public function creditDistributionPlan()
    {
        return view('budget::pages.credit_distribution.main', ['pageTitle' => 'طرحهای توزیع اعتبار']);
    }
}
