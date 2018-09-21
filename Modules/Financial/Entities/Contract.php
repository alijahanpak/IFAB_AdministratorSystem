<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['cIsAccepted'];
    protected $table = 'tbl_contracts';

    public function executor()
    {
        return $this->belongsTo(Executor::class , 'cEId' , 'id');
    }
}
