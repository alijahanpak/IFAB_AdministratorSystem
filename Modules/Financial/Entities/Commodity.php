<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = ['cSubject'];
    protected $table = 'tbl_commodities';
}
