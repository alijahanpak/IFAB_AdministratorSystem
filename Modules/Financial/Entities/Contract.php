<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['cIsAccepted'];
    protected $table = 'tbl_contracts';
    protected $appends = ['cAmount'];

    public function executor()
    {
        return $this->belongsTo(Executor::class , 'cEId' , 'id');
    }

    public function increaseAmount()
    {
        return $this->hasMany(IncreaseContractAmount::class , 'icaCId' , 'id');
    }

    function getCAmountAttribute()
    {
        $increases = IncreaseContractAmount::where('icaCId' , '=' , $this->id)->get()->sum('icaAmount');
        return $increases + $this->cBaseAmount;
    }
}
