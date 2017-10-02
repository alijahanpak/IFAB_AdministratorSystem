<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CdrCp extends Model
{
    protected $table = 'tbl_cdr_cp';
    protected $fillable = [];

    public function creditDistributionRow()
    {
        return $this->belongsTo(CreditDistributionRow::class , 'ccCdrId' , 'id');
    }
}
