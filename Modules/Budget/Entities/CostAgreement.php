<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostAgreement extends Model
{
    protected $table = 'tbl_cost_agreement';
    protected $fillable = [];

    public function caCreditSource()
    {
        return $this->hasMany(CaCreditSource::class , 'ccsCaId' , 'id');
    }
}
