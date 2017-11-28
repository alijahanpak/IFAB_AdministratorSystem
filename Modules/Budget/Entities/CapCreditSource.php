<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapCreditSource extends Model
{
    protected $table = 'tbl_cap_credit_source';
    protected $fillable = [];

    public function creditDistributionRow()
    {
        return $this->belongsTo(CreditDistributionRow::class , 'ccsCdrId' , 'id');
    }

    public function tinySeason()
    {
        return $this->belongsTo(CapitalAssetsTinySeason::class , 'ccsTsId' , 'id');
    }

    public function howToRun()
    {
        return $this->belongsTo(HowToRun::class , 'ccsHtrId' , 'id');
    }

    public function capitalAssetsProject()
    {
        return $this->belongsTo(CapitalAssetsProject::class , 'ccsCapId' , 'id');
    }

    public function allocation()
    {
        return $this->hasMany(CapitalAssetsAllocation::class , 'caaCcsId' , 'id')->orderBy('id', 'DESC');
    }

    public static function sumOfCreditSource($pId){
        return CapCreditSource::where('ccsCapId','=',$pId)->sum('ccsAmount');
    }
}
