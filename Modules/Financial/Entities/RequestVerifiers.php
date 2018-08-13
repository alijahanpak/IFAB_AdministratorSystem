<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestVerifiers extends Model
{
    protected $fillable = ['rvSId' , 'rvRstId' , 'rvRId' , 'rvUId'];
    protected $table = 'tbl_request_verifiers';

    public function requestStep()
    {
        return $this->belongsTo(RequestStep::class , 'rvRstId' , 'id');
    }
}
