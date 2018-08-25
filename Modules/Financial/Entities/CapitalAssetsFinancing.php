<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class CapitalAssetsFinancing extends Model
{
    protected $fillable = ['cafAccepted'];
    protected $table = 'tbl_capital_assets_financing';
}
