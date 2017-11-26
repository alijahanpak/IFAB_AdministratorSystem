<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Budget\Entities\CaCreditSource;
use Modules\Budget\Entities\CapitalAssetsSeasonTitle;
use Modules\Budget\Entities\CapitalAssetsTinySeason;
use Modules\Budget\Entities\CostAllocation;
use Modules\Budget\Entities\CostSeasonTitle;
use Modules\Budget\Entities\CostTinySeason;

class Season extends Model
{
    protected $table = 'tbl_seasons';
    protected $fillable = [];
    protected $appends = ['coSumOfApprovedAmount' , 'coSumOfAllocationAmount' , 'coSumOfNatApprovedAmount' , 'coSumOfNatAllocationAmount'];

    public function capitalAssetsSeasonTitle()
    {
        return $this->hasMany(CapitalAssetsSeasonTitle::class , 'castSId' , 'id')->has('capitalAssetsTinySeason');
    }

    public function costSeasonTitle()
    {
        return $this->hasMany(CostSeasonTitle::class , 'cstSId' , 'id')->has('costTinySeason');
    }

    public function getCoSumOfApprovedAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $sum = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 0)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfAllocationAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $ccsList = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 0)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])->pluck('id')->toArray();
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
            }])->sum('ccsAmount');
        return $sum;
    }

    public function getCoSumOfNatAllocationAmountAttribute()
    {
        $stList = $this->costSeasonTitle()->pluck('id')->toArray();
        $tsList = CostTinySeason::whereIn('ctsCstId' , $stList)->pluck('id')->toArray();
        $ccsList = CaCreditSource::whereIn('ccsTsId' , $tsList)
            ->with(['costAgreement' => function($query){
                return $query->where('caProvinceOrNational' , '=' , 1)->where('caFyId' , '=' , Auth::user()->seFiscalYear);
            }])->pluck('id')->toArray();
        $sum = CostAllocation::whereIn('caCcsId' , $ccsList)->sum('caAmount');
        return $sum;
    }
}
