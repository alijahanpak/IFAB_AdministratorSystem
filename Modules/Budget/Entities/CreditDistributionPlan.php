<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\County;

class CreditDistributionPlan extends Model
{
    protected $table = 'tbl_credit_distribution_plans';
    protected $fillable = [];

    public function creditDistributionTitle()
    {
        return $this->belongsTo(CreditDistributionTitle::class , 'cdpCdtId' , 'id');
    }

    public function county()
    {
        return $this->belongsTo(County::class , 'cdpCoId' , 'id');
    }

    public function creditDistributionRow()
    {
        return $this->belongsTo(CreditDistributionRow::class , 'cdpCdrId' , 'id');
    }

    public static function getAllPlan($cdtId , $cdrId)
    {
        return CreditDistributionPlan::where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->where('cdpCdtId' , '=' , $cdtId)->where('cdpCdrId' , '=' , $cdrId)->get();
    }

    public static function getAllPlan_rows($cdrId)
    {

        return CreditDistributionPlan::select(['cdpCdtId' , 'cdpCdrId' , 'cdpDescription'])->where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->groupBy(['cdpCdtId' , 'cdpCdrId' , 'cdpDescription'])->having([''])->get();
    }

    public static function getSumPlanAmount($cdtId , $cdrId)
    {
        return CreditDistributionPlan::where('cdpFyId' , '=' , Auth::user()->seFiscalYear)->where('cdpCdtId' , '=' , $cdtId)->where('cdpCdrId' , '=' , $cdrId)->sum('cdpCredit');
    }
}
