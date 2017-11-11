<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class BudgetReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    private function initPdf($options)
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'a4');
        $pdf->setOption('title', 'report');
        $pdf->setOption('footer-center', '[page]/[topage]');
        $pdf->setOption('margin-bottom', 20);
        $pdf->setOrientation($options->orientation == true ? 'landscape' : 'portrait');
        $pdf->setOption('margin-top',5);
        $pdf->setOption('lowquality', true);
        $pdf->setOption('zoom', 1.2);
        return $pdf;
    }

    public function approvedPlan(Request $request)
    {
        $options = json_decode($request->get('options'));
        $pdf = $this->initPdf($options);
        if ($request->pOrN == 0)
            $pdf->loadHTML(view('budget::reports.approved.plan_provincial' , ['options' => $options , 'items' => $request->get('selectedItems')]));
        else
            $pdf->loadHTML(view('budget::reports.approved.plan_national' , ['options' => $options , 'items' => $request->get('selectedItems')]));
        $pdf->save('pdfFiles/temp' . Auth::user()->id .'.pdf' , true);
        return url('pdfFiles/temp' . Auth::user()->id .'.pdf');
    }

    public function approvedProject(Request $request)
    {
        $options = json_decode($request->get('options'));
        $pdf = $this->initPdf($options);
        if ($request->pOrN == 0)
            $pdf->loadHTML(view('budget::reports.approved.project_provincial' , ['options' => $options , 'items' => $request->get('selectedItems')]));
        else
            $pdf->loadHTML(view('budget::reports.approved.project_national' , ['options' => $options , 'items' => $request->get('selectedItems')]));
        $pdf->save('pdfFiles/temp' . Auth::user()->id .'.pdf' , true);
        return url('pdfFiles/temp' . Auth::user()->id .'.pdf');
    }
}
