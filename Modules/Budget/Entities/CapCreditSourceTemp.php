<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CapCreditSourceTemp extends Model
{
    protected $table = 'tbl_cap_credit_source_temp';
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
        return $this->belongsTo(CapitalAssetsProjectTemp::class , 'ccsCapId' , 'id');
    }
}
