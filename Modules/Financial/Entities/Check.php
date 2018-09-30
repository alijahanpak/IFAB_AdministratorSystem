<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class _Check extends Model
{
    protected $fillable = ['cDId' , 'cPdId' , 'cAmount'];
    protected $table = 'tbl_checks';

    public function percentageDecrease()
    {
        return $this->belongsTo(PercentageDecrease::class , 'cPdId' , 'id');
    }
}
