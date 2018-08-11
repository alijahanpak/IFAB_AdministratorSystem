<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\User;

class _Request extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_requests';
    protected $appends = ['rLastRef'];

    public function requestState()
    {
        return $this->belongsTo(RequestState::class , 'rRsId' , 'id');
    }

    public function requestType()
    {
        return $this->belongsTo(RequestType::class , 'rRtId' , 'id');
    }

    public function requestCommodity()
    {
        return $this->hasMany(RequestCommodity::class , 'rcRId' , 'id')->orderBy('id', 'DESC');
    }

    public function history()
    {
        return $this->hasMany(RequestHistory::class , 'rhRId' , 'id');
    }

    public function getRLastRefAttribute()
    {
        $lastHistoryId = RequestHistory::where('rhRId' , '=' , $this->id)->max('id');
        return RequestHistory::with('destinationUserInfo.role.officeUnit')->find($lastHistoryId);
    }
}
