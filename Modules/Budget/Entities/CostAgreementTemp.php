<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;

class CostAgreementTemp extends Model
{
    protected $table = 'tbl_cost_agreement_temp';
    protected $fillable = [];

    public function caCreditSource()
    {
        return $this->hasMany(CaCreditSourceTemp::class , 'ccsCaId' , 'id');
    }
}
