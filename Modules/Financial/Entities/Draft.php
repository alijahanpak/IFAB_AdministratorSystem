<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_drafts';
    protected $appends = ['dAmount'];

    function verifier()
    {
        return $this->hasMany(DraftVerifier::class , 'dvDId' , 'id')->orderBy('id', 'DESC');
    }

    function getDAmountAttribute()
    {
        $increases = IncreaseDraftAmount::where('idaPiId' , '=' , $this->id)->sum('idaAmount');
        return $increases + $this->dBaseAmount;
    }
}
