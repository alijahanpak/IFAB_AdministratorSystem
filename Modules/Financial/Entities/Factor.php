<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_factors';

    public function seller()
    {
        return $this->belongsTo(Seller::class , 'fSId' , 'id');
    }
}
