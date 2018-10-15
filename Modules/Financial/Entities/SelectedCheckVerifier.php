<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class SelectedCheckVerifier extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_selected_check_verifiers';

    public function verifier()
    {
        return $this->belongsTo(CheckVerifier::class , 'scvCvId' , 'id');
    }
}
