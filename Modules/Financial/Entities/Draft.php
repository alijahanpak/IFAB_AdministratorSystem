<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Draft extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_drafts';
    protected $appends = ['dYouAreVerifier'];

    function verifier()
    {
        return $this->hasMany(DraftVerifier::class , 'dvDId' , 'id')->orderBy('id', 'DESC');
    }


    public function getDYouAreVerifierAttribute()
    {
        return DraftVerifier::where('dvDId' , '=' , $this->id)->value('dvUId') == Auth::user()->id ? true : false;
    }

}
