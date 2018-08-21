<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;
use Morilog\Jalali\Facades\jDate;

class RequestVerifiers extends Model
{
    protected $appends = ['rvShamsiDate' , 'rvShamsiTime'];
    protected $fillable = ['rvSId' , 'rvRstId' , 'rvRId' , 'rvUId'];
    protected $table = 'tbl_request_verifiers';

    public function requestStep()
    {
        return $this->belongsTo(RequestStep::class , 'rvRstId' , 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'rvUId' , 'id')->select('id' , 'name' , 'rId' , 'avatarPath');
    }

    public function getRvShamsiDateAttribute()
    {
        return jDate::forge($this->update_at)->format('Y/m/d');
    }

    public function getRvShamsiTimeAttribute()
    {
        return jDate::forge($this->update_at)->format('time');
    }
}
