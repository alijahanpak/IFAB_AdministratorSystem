<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Financial\Entities\Draft;

class ReportController extends Controller
{
    private function initA4Pdf($options)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'a4');
        $pdf->setOption('title', 'report');
        $pdf->setOption('footer-center', '[page]/[topage]');
        $pdf->setOption('margin-bottom', 25);
        $pdf->setOrientation($options['orientation'] == true ? 'landscape' : 'portrait');
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
        $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
        return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
    }

}
