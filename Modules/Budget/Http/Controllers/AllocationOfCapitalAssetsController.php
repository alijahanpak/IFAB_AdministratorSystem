<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AllocationOfCapitalAssetsController extends Controller
{
    public function register_of_credit_allocation_assets(){
        return view('budget::pages.register_of_credit_allocation_assets.main',
            ['pageTitle' => 'ثبت تخصیص اعتبار- تملک دارایی و سرمایه ای',
                'requireJsFile' => 'register_of_credit_allocation_assets']);
    }
}
