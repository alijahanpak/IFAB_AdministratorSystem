<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CostAgreement;
use Modules\Financial\Entities\_Check;
use Modules\Financial\Entities\_Request;
use Modules\Financial\Entities\CapitalAssetsFinancing;
use Modules\Financial\Entities\CheckFormat;
use Modules\Financial\Entities\CostFinancing;
use Modules\Financial\Entities\Draft;
use Modules\Financial\Entities\NumberToWord;
use Modules\Financial\Entities\PayRequest;

class ReportController extends Controller
{
    private function initA4Pdf()
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'a4');
        $pdf->setOption('title', 'report');
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOrientation('portrait');
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('lowquality', true);
        $pdf->setOption('zoom', 1.2);
        return $pdf;
    }

    private function initA5Pdf()
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'a5');
        $pdf->setOption('title', 'report');
        $pdf->setOption('margin-bottom', 25);
        $pdf->setOrientation('portrait');
        $pdf->setOption('margin-top', 20);
        $pdf->setOption('lowquality', true);
        $pdf->setOption('zoom', 1.2);
        return $pdf;
    }

    private function initCustomSize($width , $height)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('title', 'report');
        $pdf->setOption('page-width', $width);
        $pdf->setOption('page-height', $height);
        $pdf->setOrientation('portrait');
        $pdf->setOption('margin-top', 0);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('lowquality', true);
        $pdf->setOption('zoom', 1.2);
        return $pdf;
    }

    public function draft(Request $request)
    {
        $draft = Draft::where('id' , '=' , $request->dId)
            ->with('verifier')
            ->first();
        $verifierName = $draft['verifier'][0]['user']['name'];
        $verifierRole = $draft['verifier'][0]['user']['role']['rSubject'];
        $pdf = $this->initA5Pdf();
        $pdf->loadHTML(view('financial::reports.draft.draftAccept' , ['draftInfo' => $draft , 'verifierName' => $verifierName ,'verifierRole' => $verifierRole]));
        return $pdf->inline();
        //$pdf->save('pdfFiles/draft' . Auth::user()->id . '.pdf', true);
        //return url('pdfFiles/draft' . Auth::user()->id . '.pdf');
    }

    public function paymentRequest(Request $request)
    {
        $payRequestInfo = PayRequest::where('id' , '=' , $request->prId)
            ->with('contract.executor')
            ->with('verifiers.user.role.officeUnit')
            ->with('verifiers.signature')
            ->first();
        $pdf = $this->initA4Pdf();
        $pdf->loadHTML(view('financial::reports.payment_request.paymentRequestAccept' , ['payRequestInfo' => $payRequestInfo]));
        return $pdf->inline();
        //$pdf->save('pdfFiles/pay_request' . Auth::user()->id . '.pdf', true);
        //return url('pdfFiles/pay_request' . Auth::user()->id . '.pdf');
    }

    public static function digit_to_persain_letters($money)
    {
        $numToWord = new NumberToWord();
        return $numToWord->numberToWords($money);
    }

    public function document(Request $request)
    {
        $draft = Draft::where('id' , $request->dId)->with('payRequest')->first();
        //$req = _Request::where('id' , $draft->id)->first();
        $checks = _Check::where('cDId' , $draft->id)
            ->with('percentageDecrease')
            ->where('cPdId' , '<>' , null)
            ->get();

        $costAllocId = CostFinancing::where('cfRId' , $draft->dRId)
            ->where('cfDeleted' , false)
            ->where('cfAccepted' , true)
            ->pluck('cfCaId');
        $capAllocId = CapitalAssetsFinancing::where('cafRId' , $draft->dRId)
            ->where('cafDeleted' , false)
            ->where('cafAccepted' , true)
            ->pluck('cafCaaId');

        $cap = CapitalAssetsApprovedPlan::whereHas('capitalAssetsProject' , function ($q) use($capAllocId){
            $q->whereHas('creditSource' , function ($q1) use($capAllocId){
                $q1->whereHas('allocation' , function ($q2) use($capAllocId){
                    $q2->whereIn('id' , $capAllocId);
                });
            });
        })->with('creditDistributionTitle')->get();

        $cost = CaCreditSource::whereHas('allocation' , function ($q) use($costAllocId){
            return $q->whereIn('id' , $costAllocId);
        })->with('creditDistributionTitle')->get();

        $pdf = $this->initA4Pdf();
        $pdf->loadHTML(view('financial::reports.draft.document' , ['draft' => $draft ,
            'costFinancing' => $cost ,
            'capFinancing' => $cap ,
            'checks' => $checks]));
        return $pdf->inline();
        //$pdf->save('pdfFiles/document_' . Auth::user()->id . '.pdf', true);
        //return url('pdfFiles/document_' . Auth::user()->id . '.pdf');
    }

    public function check(Request $request)
    {
        $baseMargin=8;
        $checkFormat = CheckFormat::find($request->fId);
        $check = _Check::where('id' , $request->id)
            ->with('draft')
            ->with('percentageDecrease')
            ->with('selectedVerifiers.verifier.user')
            ->first();
        $check['amountText'] = self::digit_to_persain_letters($check->cAmount);
        $pdf = $this->initCustomSize($checkFormat->cfHeight * 10 , $checkFormat-> cfWidth* 10);
        $pdf->loadHTML(view('financial::reports.draft.check' , ['checkFormat' => $checkFormat , 'check' => $check , 'baseMargin' =>$baseMargin]));
        return $pdf->inline();
    }

}
