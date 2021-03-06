<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Entities\AmountUnit;

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
        $pdf->setOption('margin-bottom', 25);
        $pdf->setOrientation($options['orientation'] == true ? 'landscape' : 'portrait');
        $pdf->setOption('margin-top', 20);
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
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
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
            return $pdf->inline();
/*            $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            return url('pdfFiles/temp' . Auth::user()->id . '.pdf');*/
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
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
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
                            foreach ($plan['c_d_t_in_county'] as $cdtInCounty) {

                                $sheet->appendRow(array(
                                    $plan['cdtIdNumber'],
                                    $plan['cdtSubject'],
                                    $plan['budget_season']['bsSubject'],
                                    $plan['cdtDescription'],
                                    $cdtInCounty['county']['coName'],
                                    $cdtInCounty['cdtIdNumber'],
                                    $cdtInCounty['cdtDescription']
                                ));
                            }
                        }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function deprivedAreaProv(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.admin.deprived_area_prov', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:E1');
                    $sheet->getStyle('A1:E1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('شهرستان',
                        'بخش',
                        'دهستان',
                        'روستا',
                        'شرح'));
                    $sheet->cells('A2:E2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $deprived_area){

                        $sheet->appendRow(array(
                        $deprived_area['county']['coName'],
                        $deprived_area['region']['reName'],
                        $deprived_area['rural_district']['rdName'],
                        $deprived_area['village']['viName'],
                        $deprived_area['daDescription'],

                            ));
                    }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function capitalAssetsAllocation(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.allocation.capital_assets', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
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
                    $sheet->getStyle('A1:G1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('طرح',
                        'پروژه',
                        'ردیف اعتبار',
                        'شماره',
                        'تاریخ',
                        'مبلغ'));
                    $sheet->cells('A2:G2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $plan){
                        foreach($plan['capital_assets_project_has_credit_source'] as $project){
                            foreach($project['credit_source_has_allocation'] as $credit_source){
                                foreach($credit_source['allocation'] as $alloc){
                                    if($alloc['checked']==true){
                                        $sheet->appendRow(array(

                                              $plan['credit_distribution_title']['cdtIdNumber'] .' - '. $plan['credit_distribution_title']['cdtSubject'],
                                              $project['cpCode']  . ' - ' .$project['cpSubject'],
                                              $credit_source['credit_distribution_row']['cdSubject'],
                                              $alloc['caaLetterNumber'] ,
                                              $alloc['caaLetterDate'],
                                              AmountUnit::convertDispAmount($alloc[ 'caaAmount'])  ,



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

    public function planProvincial(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.creditDistribution.plan', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:E1');
                    $sheet->getStyle('A1:E1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('طرح',
                        'ردیف',
                        'شهرستان',
                        'مبلغ اعتبار',
                        'شرح'));
                    $sheet->cells('A2:E2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                        foreach($request->get('selectedItems') as $plan){
                            foreach($plan['credit_distribution_plan'] as $cdPlan){
                                if($cdPlan['checked']==true)
                                {
                                    $sheet->appendRow(array(
                                        $plan['cdtIdNumber'] .'-'. $plan['cdtSubject'],
                                        $cdPlan['credit_distribution_row']['cdSubject'],
                                        $cdPlan['county']['coName'],
                                        AmountUnit::convertDispAmount($cdPlan['cdpCredit']),
                                        $cdPlan['cdpDescription']
                                    ));
                                }
                            }
                        }
                    });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function proposalProvincial(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.creditDistribution.proposal', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:F1');
                    $sheet->getStyle('A1:F1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('شهرستان',
                        'طرح',
                        'کد پروژه',
                        'عنوان',
                        'اعتبار',
                        'شرح'));
                    $sheet->cells('A2:F2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $county){
                        foreach($county['credit_distribution_plan_has_proposal'] as $plan){
                            foreach($plan['proposal'] as $proposal){
                                if($proposal['checked']==true){
                                    $sheet->appendRow(array(
                                        $county['coName'],
                                        $plan['credit_distribution_title']['cdtIdNumber']. ' - ' . $plan['credit_distribution_title']['cdtSubject'],
                                        $proposal['pbpCode'],
                                        $proposal['pbpSubject'],
                                        AmountUnit::convertDispAmount($proposal['pbpAmount']),
                                        $proposal['pbpDescription'],
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

    public function costAllocation(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.allocation.cost', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:F1');
                    $sheet->getStyle('A1:F1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('موافقتنامه',
                        'برنامه',
                        'ردیف اعتبار',
                        'شماره',
                        'تاریخ',
                        'مبلغ'));
                    $sheet->cells('A2:F2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $plan){
                        foreach($plan['ca_credit_source_has_allocation'] as $credit_source){
                            foreach($credit_source['allocation'] as $alloc){
                                if($alloc['checked']==true){
                                    $sheet->appendRow(array(
                                        $plan['caLetterNumber'],
                                        $credit_source['credit_distribution_title']['cdtIdNumber'] . ' - '. $credit_source['credit_distribution_title']['cdtSubject'],
                                        $credit_source['credit_distribution_row']['cdSubject'],
                                        $alloc['caLetterNumber'],
                                        $alloc['caLetterDate'],
                                        AmountUnit::convertDispAmount($alloc['caAmount']),
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

    public function costFoundProvincial(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.allocation.found_provincial', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:E1');
                    $sheet->getStyle('A1:E1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('تاریخ',
                        'مبلغ',
                        'هزینه',
                        'تبدیل شده به تخصیص',
                        'شرح'));
                    $sheet->cells('A2:E2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $found){

                        $sheet->appendRow(array(
                            $found['caLetterDate'],
                            AmountUnit::convertDispAmount($found['caAmount']),
                            AmountUnit::convertDispAmount($found['caSumOfCost']),
                            AmountUnit::convertDispAmount($found['caConvertedAllocAmount']),
                            $found['caDescription'],

                        ));

                    }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function capitalFoundProvincial(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.allocation.capital_found_provincial', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:E1');
                    $sheet->getStyle('A1:E1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('تاریخ',
                        'مبلغ',
                        'هزینه',
                        'تبدیل شده به تخصیص',
                        'شرح'));
                    $sheet->cells('A2:E2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $found){

                        $sheet->appendRow(array(
                            $found['caaLetterDate'],
                            AmountUnit::convertDispAmount($found['caaAmount']),
                            AmountUnit::convertDispAmount($found['caaSumOfCost']),
                            AmountUnit::convertDispAmount($found['caaConvertedAllocAmount']),
                            $found['caaDescription'],

                        ));

                    }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }

    public function approvedProgram(Request $request)
    {
        if ($request->type == 'pdf') {
            $options = $request->get('options');
            $pdf = $this->initPdf($options);
            $pdf->loadHTML(view('budget::reports.approved.program', ['options' => $options, 'items' => $request->get('selectedItems')]));
            return $pdf->inline();
            //$pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
            //return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
        } else if ($request->type == 'excel') {
            Excel::create('temp' . Auth::user()->id, function ($excel) use ($request) {
                $excel->getDefaultStyle()
                    ->getAlignment()
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->sheet('sheet1', function ($sheet) use ($request) {
                    $options = $request->get('options');
                    $sheet->setRightToLeft(true);
                    $sheet->appendRow(array($options['title']));
                    $sheet->mergeCells('A1:M1');
                    $sheet->getStyle('A1:M1')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->appendRow(array('شماره مبادله',
                        'تاریخ مبادله',
                        'شماره ابلاغ',
                        'تاریخ ابلاغ',
                        'اعتبار',
                        'برنامه',
                        'ردیف',
                        'فصل',
                        'عنوان فصل',
                        'ریز فصل',
                        'مبلغ',
                        'توضیحات',
                        'شرح'));
                    $sheet->cells('A2:M2', function ($cells) {
                        $cells->setBackground('#34B7A3');
                        $cells->setFontColor('#FFFFFF');
                        $cells->setAlignment('center');
                    });
                    foreach($request->get('selectedItems') as $tempItem){
                        if(count($tempItem['ca_credit_source']) >0) {
                            foreach($tempItem['ca_credit_source'] as $creditSource) {
                                $sheet->appendRow(array(
                                    $tempItem['caLetterNumber'],
                                    $tempItem['caLetterDate'],
                                    $tempItem['caExchangeIdNumber'],
                                    $tempItem['caExchangeDate'],
                                    0,
                                    $tempItem['caDescription'],

                                    $creditSource['credit_distribution_title']['cdtIdNumber'] .'-'.$creditSource['credit_distribution_title']['cdtSubject'],
                                    $creditSource['credit_distribution_row']['cdSubject'],
                                    $creditSource['tiny_season']['season_title']['season']['sSubject'],
                                    $creditSource['tiny_season']['season_title']['cstSubject'],
                                    $creditSource['tiny_season']['ctsSubject'],
                                    AmountUnit::convertDispAmount($creditSource['ccsAmount']),
                                    $creditSource['ccsDescription'],
                                ));
                            }
                        }
                    }
                });
            })->store('xls', public_path('xlsFiles'));
            return url('xlsFiles/temp' . Auth::user()->id . '.xls');
        }
    }
}
