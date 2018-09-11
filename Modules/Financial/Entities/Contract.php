<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['cIsAccepted'];
    protected $table = 'tbl_contracts';
}
