<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Financial\Entities\Draft;
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
        $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
        return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
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
        $pdf->save('pdfFiles/temp' . Auth::user()->id . '.pdf', true);
        return url('pdfFiles/temp' . Auth::user()->id . '.pdf');
    }

    public static function digit_to_persain_letters($money)
    {
        $one = array(
            'صفر',
            'یک',
            'دو',
            'سه',
            'چهار',
            'پنج',
            'شش',
            'هفت',
            'هشت',
            'نه');
        $ten = array(
            '',
            'ده',
            'بیست',
            'سی',
            'چهل',
            'پنجاه',
            'شصت',
            'هفتاد',
            'هشتاد',
            'نود',
        );
        $hundred = array(
            '',
            'یکصد',
            'دویست',
            'سیصد',
            'چهارصد',
            'پانصد',
            'ششصد',
            'هفتصد',
            'هشتصد',
            'نهصد',
        );
        $categories = array(
            '',
            'هزار',
            'میلیون',
            'میلیارد',
            'بیلیون',
            'تریلیون',
            'تریلیارد',
            'کادریلیون',
        );
        $exceptions = array(
            '',
            'یازده',
            'دوازده',
            'سیزده',
            'چهارده',
            'پانزده',
            'شانزده',
            'هفده',
            'هجده',
            'نوزده',
        );

        if(strlen($money) > count($categories)*3){
            throw new Exception('number is longger!');
        }

        $letters_separator = ' و ';
        $money = (string)(int)$money;
        $money_len = strlen($money);
        $persian_letters = '';

        for($i=$money_len-1; $i>=0; $i-=3){
            $i_one = (int)isset($money[$i]) ? $money[$i] : -1;
            $i_ten = (int)isset($money[$i-1]) ? $money[$i-1] : -1;
            $i_hundred = (int)isset($money[$i-2]) ? $money[$i-2] : -1;

            $isset_one = false;
            $isset_ten = false;
            $isset_hundred = false;

            $letters = '';

            // zero
            if($i_one == 0 && $i_ten < 0 && $i_hundred < 0){
                $letters = $one[$i_one];
            }

            // one
            if(($i >= 0) && $i_one > 0 && $i_ten != 1 && isset($one[$i_one])){
                $letters = $one[$i_one];
                $isset_one = true;
            }

            // ten
            if(($i-1 >= 0) && $i_ten > 0 && isset($ten[$i_ten])){
                if($isset_one){
                    $letters = $letters_separator.$letters;
                }

                if($i_one == 0){
                    $letters = $ten[$i_ten];
                }
                elseif($i_ten == 1 && $i_one > 0){
                    $letters = $exceptions[$i_one];
                }
                else{
                    $letters = $ten[$i_ten].$letters;
                }

                $isset_ten = true;
            }

            // hundred
            if(($i-2 >= 0) && $i_hundred > 0 && isset($hundred[$i_hundred])){
                if($isset_ten || $isset_one){
                    $letters = $letters_separator.$letters;
                }

                $letters = $hundred[$i_hundred].$letters;
                $isset_hundred = true;
            }

            if($i_one < 1 && $i_ten < 1 && $i_hundred < 1){
                $letters = '';
            }
            else{
                $letters .= ' '.$categories[($money_len-$i-1)/3];
            }

            if(!empty($letters) && $i >= 3){
                $letters = $letters_separator.$letters;
            }

            $persian_letters = $letters.$persian_letters;
        }

        return $persian_letters;
    }

}
