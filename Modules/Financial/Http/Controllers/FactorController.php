<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\Factor;
use Modules\Financial\Entities\RefundCosts;

class FactorController extends Controller
{
    function addNewFactor(Request $request)
    {
        DB::transaction(function () use($request){
            $factor = new Factor();
            $factor->fRId = $request->rId;
            $factor->fSubject = PublicSetting::checkPersianCharacters($request->subject);
            $factor->fAmount = $request->amount;
            $factor->fDescription = PublicSetting::checkPersianCharacters($request->description);
            $factor->save();

            if ($request->refundCostsId)
            {
                $refundCost = new RefundCosts();
                $refundCost->rcFId = $factor->id;
                $refundCost->rcRId = $request->refundCostsId;
                $refundCost->save();
            }

            SystemLog::setFinancialSubSystemLog('ثبت فاکتور ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
        });

        return \response()->json(
            $this->getAllFactor($request->rId)
        );
    }

    function getAllFactor($rId)
    {
        return Factor::where('fRId' , '=' , $rId)
            ->get();
    }

    function accept(Request $request)
    {
        DB::transaction(function () use($request){
            Factor::where('fRId' , '=' , $request->rId)
                ->update(['fIsAccepted' => true]);

            SystemLog::setFinancialSubSystemLog('تایید فاکتور های ' . _Request::find($request->rId)->rSubject);
        });

        return \response()->json(
            $this->getAllFactor($request->rId)
        );
    }

    function delete(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $factor = Factor::where('id' , '=' , $request->fId)->first();
            if ($factor->fIsAccepted == false)
            {
                $factor->delete();
                return 200;
            }else{
                return 204; //cannot delete contract
            }
        });

        return \response()->json(
            $this->getAllFactor($request->rId)
            , $resultCode);
    }
}
