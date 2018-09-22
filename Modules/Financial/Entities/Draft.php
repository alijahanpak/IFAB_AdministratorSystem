<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_drafts';

    function verifier()
    {
        return $this->hasMany(DraftVerifier::class , 'dvDId' , 'id')->orderBy('id', 'DESC');
    }

}
