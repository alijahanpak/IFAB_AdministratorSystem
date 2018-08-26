<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Budget\Entities\CapitalAssetsAllocation;

class CapitalAssetsFinancing extends Model
{
    protected $fillable = ['cafAccepted' , 'cafCaaId' , 'cafRId' , 'cafAmount'];
    protected $table = 'tbl_capital_assets_financing';

    public function allocation()
    {
        return $this->belongsTo(CapitalAssetsAllocation::class , 'cafCaaId' , 'id');
    }
}
