<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $fillable = ['fFsId'];
    protected $table = 'tbl_factors';

    public function seller()
    {
        return $this->belongsTo(Seller::class , 'fSId' , 'id');
    }

    public function factorState()
    {
        return $this->belongsTo(FactorState::class , 'fFsId' , 'id');
    }

    public function refundFactor()
    {
        return $this->hasMany(RefundFactor::class , 'rfFId' , 'id');
    }

    public function request()
    {
        return $this->belongsTo(_Request::class , 'fRId' , 'id');
    }
}
