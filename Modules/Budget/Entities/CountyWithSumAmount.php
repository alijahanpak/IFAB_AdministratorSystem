<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CountyWithSumAmount extends Model
{
    protected $table = 'tbl_counties';
    protected $fillable = [];
    protected $appends = ['coSumOfApprovedAmount' ,
        'coSumOfAllocationAmount' ,
        'coSumOfProposalAmount' ,
        'coSumOfNatApprovedAmount' ,
        'coSumOfNatAllocationAmount'];

    public function creditDistributionPlanHasProposal()
    {
        return $this->hasMany(CreditDistributionPlan::class , 'cdpCoId' , 'id')->has('proposal')->orderBy('id', 'DESC');
    }

    public function creditDistributionTitle()
    {

        return $this->hasMany(CreditDistributionTitle::class , 'cdtCoId' , 'id')->orderBy('id', 'DESC');
    }

    public function capitalAssetsProject()
    {

        return $this->hasMany(CapitalAssetsProject::class , 'cpCoId' , 'id')->orderBy('id', 'DESC');
    }

    public function getCoSumOfApprovedAmountAttribute()
    {
        $tList = $this->creditDistributionTitle()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::whereIn('capCdtId' , $tList)->where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 0)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $sum = CapCreditSource::whereIn('ccsCapId' , $pList)->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfProposalAmountAttribute()
    {
        $tList = $this->creditDistributionPlanHasProposal()->pluck('id')->toArray();
        $sum = ProvincialBudgetProposal::whereIn('pbpCdpId' , $tList)->where('pbpFyId' , '=' , Auth::user()->seFiscalYear)->sum('pbpAmount');
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
        $tList = $this->capitalAssetsProject()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 1)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('id' , $tList)->whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $sum = CapCreditSource::whereIn('ccsCapId' , $pList)->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfNatAllocationAmountAttribute()
    {
        $tList = $this->capitalAssetsProject()->pluck('id')->toArray();
        $apList = CapitalAssetsApprovedPlan::where('capFyId' , '=' , Auth::user()->seFiscalYear)->where('capProvinceOrNational' , '=' , 1)->pluck('id')->toArray();
        $pList = CapitalAssetsProject::whereIn('id' , $tList)->whereIn('cpCapId' , $apList)->pluck('id')->toArray();
        $csList = CapCreditSource::whereIn('ccsCapId' , $pList)->pluck('id')->toArray();
        $sum = CapitalAssetsAllocation::whereIn('caaCcsId' , $csList)->sum('caaAmount');
        return $sum;
    }
}
