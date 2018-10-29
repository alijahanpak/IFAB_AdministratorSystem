<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestCommodity extends Model
{
    protected $fillable = ['rcExistCount' , 'rcIsExist' , 'rcRId' , 'rcCId' , 'rcCostEstimation' , 'rcCount' , 'rcCostEstimation' , 'rcDescription'];
    protected $table = 'tbl_request_commodities';

    public function commodity()
    {
        return $this->belongsTo(Commodity::class , 'rcCId' , 'id');
    }
}
