<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SeasonWithSumAmount extends Model
{
    protected $table = 'tbl_seasons';
    protected $fillable = [];
    protected $appends = ['coSumOfApprovedAmount' , 'coSumOfAllocationAmount' , 'coSumOfNatApprovedAmount' , 'coSumOfNatAllocationAmount'];

    public function capitalAssetsSeasonTitle()
    {
        return $this->hasMany(CapitalAssetsSeasonTitle::class , 'castSId' , 'id');
    }

    public function costSeasonTitle()
    {
        return $this->hasMany(CostSeasonTitle::class , 'cstSId' , 'id');
    }

    public function getCoSumOfApprovedAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $sum = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 0)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])
            ->whereHas('costAgreement' , function($query){
                return $query->where('caProvinceOrNational' , '=' , 0)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            })->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfAllocationAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $ccsList = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 0)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])
            ->whereHas('costAgreement' , function($query){
                return $query->where('caProvinceOrNational' , '=' , 0)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            })->pluck('id')->toArray();
        $sum = CostAllocation::whereIn('caCcsId' , $ccsList)->sum('caAmount');
        return $sum;
    }

    public function getCoSumOfNatApprovedAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $sum = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 1)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])
            ->whereHas('costAgreement' , function($query){
                return $query->where('caProvinceOrNational' , '=' , 1)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            })->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfNatAllocationAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $ccsList = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 1)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])
            ->whereHas('costAgreement' , function($query){
                return $query->where('caProvinceOrNational' , '=' , 1)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            })->pluck('id')->toArray();
        $sum = CostAllocation::whereIn('caCcsId' , $ccsList)->sum('caAmount');
        return $sum;
    }
}
