<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;
use Morilog\Jalali\Facades\jDate;

class RequestHistory extends Model
{
    protected $appends = ['rhShamsiDate' , 'rhShamsiTime'];
    protected $fillable = ['rhRsId' , 'rhDescription'];
    protected $table = 'tbl_request_history';

    public function sourceUserInfo()
    {
        return $this->belongsTo(User::class , 'rhSrcUId' , 'id')->select('name' , 'rId' , 'id' , 'avatarPath');
    }

    public function destinationUserInfo()
    {
        return $this->belongsTo(User::class , 'rhDestUId' , 'id')->select('name' , 'rId' , 'id' , 'avatarPath');
    }

    public function requestState()
    {
        return $this->belongsTo(RequestState::class , 'rhRsId' , 'id');
    }

    public function getRhShamsiDateAttribute()
    {
        return jDate::forge($this->created_at)->format('Y/m/d');
    }

    public function getRhShamsiTimeAttribute()
    {
        return jDate::forge($this->created_at)->format('time');
    }
}
