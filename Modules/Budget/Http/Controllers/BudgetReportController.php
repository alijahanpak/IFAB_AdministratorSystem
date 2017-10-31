<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class BudgetReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function approvedPlanProv()
    {
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->setOption('encoding', 'UTF-8');
        $pdf->setOption('page-size', 'a4');
        $pdf->setOption('title', 'report');
        $pdf->setOption('footer-center', '[page]/[topage]');
        $pdf->setOption('margin-bottom', 20);
        $pdf->setOrientation('landscape');
        $pdf->setOption('margin-top',5);
        $pdf->setOption('lowquality', true);
        $pdf->setOption('zoom', 1.2);
        $pdf->loadHTML(view('budget::reports.approved.plan_provincial'));
        return $pdf->inline();
        //return view('budget::reports.approved.plan_provincial');
    }
}
