<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class RequestVerifiers extends Model
{
    protected $fillable = ['rvSId' , 'rvRstId' , 'rvRId' , 'rvUId'];
    protected $table = 'tbl_request_verifiers';

    public function requestStep()
    {
        return $this->belongsTo(RequestStep::class , 'rvRstId' , 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'rvUId' , 'id')->select('id' , 'name' , 'rId');
    }
}
