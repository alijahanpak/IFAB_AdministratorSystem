<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CapCreditSource;
use Modules\Budget\Entities\CapitalAssetsAllocation;
use Modules\Budget\Entities\CapitalAssetsApprovedPlan;
use Modules\Budget\Entities\CapitalAssetsProject;
use Modules\Budget\Entities\CreditDistributionPlan;
use Modules\Budget\Entities\CreditDistributionTitle;
use Modules\Budget\Entities\DeprivedArea;

class County extends Model
{
    protected $table = 'tbl_counties';
    protected $fillable = [];
    protected $appends = ['coSumOfApprovedAmount' , 'coSumOfAllocationAmount' , 'coSumOfNatApprovedAmount' , 'coSumOfNatAllocationAmount'];

    public function creditDistributionPlan()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCoId' , 'id');
    }

    public function creditDistributionPlanHasProposal()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCoId' , 'id')->has('proposal');
    }

    public function creditDistributionTitle()
    {

        return $this->hasMany(CreditDistributionTitle::class , 'cdtCoId' , 'id');
    }

    public function getCoSumOfApprovedAmountAttribute()
    {
        $tList = $this->creditDistributionTitle()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::whereIn('capCdtId' , $tList)->where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 0)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $sum = CapCreditSource::whereIn('ccsCapId' , $pList)->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfAllocationAmountAttribute()
    {
        $tList = $this->creditDistributionTitle()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::whereIn('capCdtId' , $tList)->where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 0)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $csList = CapCreditSource::whereIn('ccsCapId' , $pList)->pluck('id')->toArray();
        $sum = CapitalAssetsAllocation::whereIn('caaCcsId' , $csList)->sum('caaAmount');
        return $sum;
    }

    public function getCoSumOfNatApprovedAmountAttribute()
    {
        $tList = $this->creditDistributionTitle()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::where('capProvinceOrNational' , '=' , 1)->whereIn('capCdtId' , $tList)->where('capFyId' , '=' , Auth::user()->seFiscalYear)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $sum = CapCreditSource::whereIn('ccsCapId' , $pList)->sum('ccsAmount');
        return count($apList);
    }

    public function getCoSumOfNatAllocationAmountAttribute()
    {
        $tList = $this->creditDistributionTitle()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::whereIn('capCdtId' , $tList)->where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 1)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $csList = CapCreditSource::whereIn('ccsCapId' , $pList)->pluck('id')->toArray();
        $sum = CapitalAssetsAllocation::whereIn('caaCcsId' , $csList)->sum('caaAmount');
        return $sum;
    }
}
