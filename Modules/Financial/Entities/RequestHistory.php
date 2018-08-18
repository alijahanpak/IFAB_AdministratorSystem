<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class RequestHistory extends Model
{
    protected $fillable = ['rhRsId' , 'rhDescription'];
    protected $table = 'tbl_request_history';

    public function sourceUserInfo()
    {
        return $this->belongsTo(User::class , 'rhSrcUId' , 'id')->select('name' , 'rId' , 'id');
    }

    public function destinationUserInfo()
    {
        return $this->belongsTo(User::class , 'rhDestUId' , 'id')->select('name' , 'rId' , 'id');
    }

    public function requestState()
    {
        return $this->belongsTo(RequestState::class , 'rhRsId' , 'id');
    }
}
