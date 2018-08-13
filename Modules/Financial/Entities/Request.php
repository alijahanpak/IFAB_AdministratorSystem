<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Entities\User;

class _Request extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_requests';
    protected $appends = ['rLastRef' , 'rYouAreVerifiers'];

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
        return RequestHistory::with('sourceUserInfo.role.officeUnit')->find($lastHistoryId);
    }

    public function getRYouAreVerifiersAttribute()
    {
        $result = RequestVerifiers::where('rvRId' , '=' , $this->id)
            ->where('rvUId' , '=' , Auth::user()->id)
            ->where('rvSId' , '=' , null)
            ->with('requestStep')
            ->get();
        return $result;
    }

    public function creator()
    {
        return $this->belongsTo(User::class , 'rUId' , 'id')->select('name');
    }
}
