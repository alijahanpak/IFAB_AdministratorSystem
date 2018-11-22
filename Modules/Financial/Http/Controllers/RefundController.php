<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Financial\Entities\_Request;

class RefundController extends Controller
{
    public function fetchAllRefund(Request $request)
    {
        $refund = _Request::where('rFyId' ,'=' , Auth::user()->seFiscalYear)
            ->whereHas('requestType' , function ($q){
                return $q->where('rtType' , '=' , 'FUND');
            })
            ->get()
            ->where('rIsPaid' , true);

        return \response()->json($refund);
    }

    public function fetchAllRefundData()
    {
        return \response()->json($this->getAllRefundData());
    }

    function getAllRefundData()
    {
        return _Request::where('rFyId' ,'=' , Auth::user()->seFiscalYear)
            ->whereHas('requestType' , function ($q){
                return $q->where('rtType' , '=' , 'FUND');
            })
            ->with('factor.factorState')
            ->with('factor.seller')
            ->orderBy('id' , 'DESC')
            ->get()
            ->where('rIsPaid' , true);
    }
}
