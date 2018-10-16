<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $pdf->setOption('margin-bottom', 25);
        $pdf->setOrientation('portrait');
        $pdf->setOption('margin-top', 20);
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

    public function draft(Request $request)
    {
        $draft = Draft::where('id' , '=' , $request->dId)
            ->with('verifier')
            ->first();
        $verifierName = $draft['verifier'][0]['user']['name'];
        $verifierRole = $draft['verifier'][0]['user']['role']['rSubject'];
        $pdf = $this->initA5Pdf();
        $pdf->loadHTML(view('financial::reports.draft.draftAccept' , ['draftInfo' => $draft , 'verifierName' => $verifierName ,'verifierRole' => $verifierRole]));
        $pdf->save('pdfFiles/draft' . Auth::user()->id . '.pdf', true);
        return url('pdfFiles/draft' . Auth::user()->id . '.pdf');
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
        $pdf->save('pdfFiles/pay_request' . Auth::user()->id . '.pdf', true);
        return url('pdfFiles/pay_request' . Auth::user()->id . '.pdf');
    }

    public static function digit_to_persain_letters($money)
    {
        $numToWord = new NumberToWord();
        return $numToWord->numberToWords($money);
    }

}
