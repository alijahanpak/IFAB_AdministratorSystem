<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Mockery\Container;
use Modules\Admin\Entities\PublicSetting;
use Modules\Admin\Entities\SystemLog;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\Contract;

class ContractController extends Controller
{
    function addNewContract(Request $request)
    {
        DB::transaction(function () use($request){
            $contract = new Contract();
            $contract->cRId = $request->rId;
            $contract->cSubject = PublicSetting::checkPersianCharacters($request->subject);
            $contract->cAmount = $request->amount;
            $contract->cPercentInAndDec = $request->percentIncAndDec;
            $contract->cLetterNumber = $request->letterNumber;
            $contract->cLetterDate = $request->letterDate;
            $contract->cStartDate = $request->startDate;
            $contract->cEndDate = $request->endDate;
            $contract->cDescription = PublicSetting::checkPersianCharacters($request->description);
            $contract->save();

            SystemLog::setFinancialSubSystemLog('ثبت قرارداد ' . $request->subject . ' برای درخواست ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function accept(Request $request)
    {
        DB::transaction(function () use($request){
            Contract::where('cRId' , '=' , $request->rId)
                ->update(['cIsAccepted' => true]);

            SystemLog::setFinancialSubSystemLog('تایید قرارداد های ' . _Request::find($request->rId)->rSubject);
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        );
    }

    function delete(Request $request)
    {
        $resultCode = DB::transaction(function () use($request){
            $contract = Contract::where('id' , '=' , $request->cId)->first();
            if ($contract->cIsAccepted == false)
            {
                $contract->delete();
                return 200;
            }else{
                return 207; //cannot delete contract
            }
        });

        $rController = new RequestController();
        return \response()->json(
            $rController->getAllReceivedRequests($rController->getLastReceivedRequestIdList())
        , $resultCode);
    }
}
