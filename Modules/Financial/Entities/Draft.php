<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Draft extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_drafts';
    protected $appends = ['dYouAreVerifier', 'dLastRef'];

    function verifier()
    {
        return $this->hasMany(DraftVerifier::class, 'dvDId', 'id')->orderBy('id', 'DESC');
    }

    public function getDYouAreVerifierAttribute()
    {
        return DraftVerifier::where('dvDId', '=', $this->id)->value('dvUId') == Auth::user()->id ? true : false;
    }

    function check()
    {
        return $this->hasMany(_Check::class, 'cDId', 'id')->orderBy('id', 'DESC');
    }

    function draftState()
    {
        return $this->belongsTo(DraftState::class, 'dDsId', 'id');
    }

    function getDLastRefAttribute()
    {
        $lastHistoryId = RequestHistory::where('rhDId', '=', $this->id)->max('id');
        return RequestHistory::with('sourceUserInfo.role.officeUnit')->find($lastHistoryId);
    }
}
