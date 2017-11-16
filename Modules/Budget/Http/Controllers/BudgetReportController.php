<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        $pdf->setOrientation($options['orientation'] == true ? 'landscape' : 'portrait');
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('lowquality', true);
        $pdf->setOption('zoom', 1.2);
        return $pdf;
    }

    public function approvedPlan(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            if ($request->pOrN == 0)
                $pdf->loadHTML(view('budget::reports.approved.plan_provincial', ['options' => $options, 'items' => $request->get('selectedItems')]));
            else
                $pdf->loadHTML(view('budget::reports.approved.plan_national', ['options' => $options, 'items' => $request->get('selectedItems')]));
            $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    if ($request->pOrN == 0) {
                        $sheet->appendRow(array($options['title']));
                        $sheet->mergeCells('A1:G1');
                        $sheet->getStyle('A1:G1')->getAlignment()->applyFromArray(
                            array('horizontal' => 'center')
                        );
                        $sheet->appendRow(array('عنوان',
                            'شماره مبادله',
                            'تاریخ مبادله',
                            'شماره ابلاغ',
                            'تاریخ ابلاغ',
                            'شهرستان',
                            'شرح'));
                        $sheet->cells('A2:G2', function ($cells) {
                            $cells->setBackground('#34B7A3');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setAlignment('center');
                        });
                        foreach ($request->get('selectedItems') as $tempItem) {
                            $sheet->appendRow(array(
                                $tempItem['credit_distribution_title']['cdtIdNumber'] . ' - ' . $tempItem['credit_distribution_title']['cdtSubject'],
                                $tempItem['capExchangeIdNumber'],
                                $tempItem['capLetterDate'],
                                $tempItem['capLetterNumber'],
                                $tempItem['capLetterDate'],
                                $tempItem['credit_distribution_title']['county']['coName'],
                                $tempItem['capDescription']
                            ));
                        }
                    } else {
                        $sheet->appendRow(array($options['title']));
                        $sheet->mergeCells('A1:F1');
                        $sheet->getStyle('A1:F1')->getAlignment()->applyFromArray(
                            array('horizontal' => 'center')
                        );
                        $sheet->appendRow(array('عنوان',
                            'شماره مبادله',
                            'تاریخ مبادله',
                            'شماره ابلاغ',
                            'تاریخ ابلاغ',
                            'شرح'));
                        $sheet->cells('A2:F2', function ($cells) {
                            $cells->setBackground('#34B7A3');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setAlignment('center');
                        });
                        foreach ($request->get('selectedItems') as $tempItem) {
                            $sheet->appendRow(array(
                                $tempItem['credit_distribution_title']['cdtIdNumber'] . ' - ' . $tempItem['credit_distribution_title']['cdtSubject'],
                                $tempItem['capExchangeIdNumber'],
                                $tempItem['capLetterDate'],
                                $tempItem['capLetterNumber'],
                                $tempItem['capLetterDate'],
                                $tempItem['capDescription']
                            ));
                        }
                    }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function approvedProject(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            if ($request->pOrN == 0)
                $pdf->loadHTML(view('budget::reports.approved.project_provincial', ['options' => $options, 'items' => $request->get('selectedItems')]));
            else
                $pdf->loadHTML(view('budget::reports.approved.project_national', ['options' => $options, 'items' => $request->get('selectedItems')]));
            $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    if ($request->pOrN == 0) {
                        $sheet->appendRow(array($options['title']));
                        $sheet->mergeCells('A1:P1');
                        $sheet->getStyle('A1:P1')->getAlignment()->applyFromArray(
                            array('horizontal' => 'center')
                        );
                        $sheet->appendRow(array('طرح',
                            'کد',
                            'عنوان',
                            'شهرستان',
                            'سال شروع',
                            'سال خاتمه',
                            'پیشرفت فیزیکی',
                            'ردیف',
                            'متوازن',
                            'فصل',
                            'عنوان فصل',
                            'ریز فصل',
                            'نحوه اجرا',
                            'مبلغ',
                            'توضیحات',
                            'شرح'));
                        $sheet->cells('A2:P2', function ($cells) {
                            $cells->setBackground('#34B7A3');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setAlignment('center');
                        });
                        foreach($request->get('selectedItems') as $plan) {
                            foreach ($plan['capital_assets_project'] as $project) {
                                foreach ($project['credit_source'] as $creditSource) {
                                    if ($project['checked'] == true) {
                                        $sheet->appendRow(array(
                                            $plan['credit_distribution_title']['cdtIdNumber'] . ' - ' . $plan['credit_distribution_title']['cdtSubject'],
                                            $project['cpCode'],
                                            $project['cpSubject'],
                                            $project['county']['coName'],
                                            $project['cpStartYear'],
                                            $project['cpEndOfYear'],
                                            $project['cpPhysicalProgress'],

                                            $project['cpDescription'],
                                            $creditSource['credit_distribution_row']['cdSubject'],
                                            $creditSource['tiny_season']['season_title']['season']['sSubject'],
                                            $creditSource['tiny_season']['season_title']['castSubject'],
                                            $creditSource['tiny_season']['catsSubject'],
                                            $creditSource['how_to_run']['htrSubject'],
                                            $creditSource['ccsAmount'],
                                            $creditSource['ccsDescription']
                                        ));
                                    }
                                }
                            }
                        }
                    } else {
                        $sheet->appendRow(array($options['title']));
                        $sheet->mergeCells('A1:P1');
                        $sheet->getStyle('A1:P1')->getAlignment()->applyFromArray(
                            array('horizontal' => 'center')
                        );
                        $sheet->appendRow(array('طرح',
                            'کد',
                            'عنوان',
                            'شهرستان',
                            'سال شروع',
                            'سال خاتمه',
                            'پیشرفت فیزیکی',
                            'ردیف',
                            'متوازن',
                            'فصل',
                            'عنوان فصل',
                            'ریز فصل',
                            'نحوه اجرا',
                            'مبلغ',
                            'توضیحات',
                            'شرح'));
                        $sheet->cells('A2:P2', function ($cells) {
                            $cells->setBackground('#34B7A3');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setAlignment('center');
                        });
                        foreach($request->get('selectedItems') as $plan) {
                            foreach ($plan['capital_assets_project'] as $project) {
                                foreach ($project['credit_source'] as $creditSource) {
                                    if ($project['checked'] == true) {
                                        $sheet->appendRow(array(
                                            $plan['credit_distribution_title']['cdtIdNumber'] . ' - ' . $plan['credit_distribution_title']['cdtSubject'],
                                            $project['cpCode'],
                                            $project['cpSubject'],
                                            $project['county']['coName'],
                                            $project['cpStartYear'],
                                            $project['cpEndOfYear'],
                                            $project['cpPhysicalProgress'],

                                            $project['cpDescription'],
                                            $creditSource['credit_distribution_row']['cdSubject'],
                                            $creditSource['tiny_season']['season_title']['season']['sSubject'],
                                            $creditSource['tiny_season']['season_title']['castSubject'],
                                            $creditSource['tiny_season']['catsSubject'],
                                            $creditSource['how_to_run']['htrSubject'],
                                            $creditSource['ccsAmount'],
                                            $creditSource['ccsDescription']
                                        ));
                                    }
                                }
                            }
                        }

                    }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function planOrCostTitle(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.admin.plan_cost_title', ['options' => $options, 'items' => $request->get('selectedItems')]));
            $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                        $sheet->appendRow(array($options['title']));
                        $sheet->mergeCells('A1:G1');
                        $sheet->getStyle('A1:H1')->getAlignment()->applyFromArray(
                            array('horizontal' => 'center')
                        );
                        $sheet->appendRow(array('شماره',
                            'عنوان',
                            'فصل بودجه',
                            'شرح',
                            'شهرستان',
                            'کد',
                            'شرح'));
                        $sheet->cells('A2:G2', function ($cells) {
                            $cells->setBackground('#34B7A3');
                            $cells->setFontColor('#FFFFFF');
                            $cells->setAlignment('center');
                        });
                        foreach($request->get('selectedItems') as $plan) {
                            foreach ($plan['capital_assets_project'] as $project) {
                                foreach ($project['credit_source'] as $creditSource) {
                                    if ($project['checked'] == true) {
                                        $sheet->appendRow(array(
                                            $plan['credit_distribution_title']['cdtIdNumber'] . ' - ' . $plan['credit_distribution_title']['cdtSubject'],
                                            $project['cpCode'],
                                            $project['cpSubject'],
                                            $project['county']['coName'],
                                            $project['cpStartYear'],
                                            $project['cpEndOfYear'],
                                            $project['cpPhysicalProgress'],

                                            $project['cpDescription'],
                                            $creditSource['credit_distribution_row']['cdSubject'],
                                            $creditSource['tiny_season']['season_title']['season']['sSubject'],
                                            $creditSource['tiny_season']['season_title']['castSubject'],
                                            $creditSource['tiny_season']['catsSubject'],
                                            $creditSource['how_to_run']['htrSubject'],
                                            $creditSource['ccsAmount'],
                                            $creditSource['ccsDescription']
                                        ));
                                    }
                                }
                            }
                        }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

}
