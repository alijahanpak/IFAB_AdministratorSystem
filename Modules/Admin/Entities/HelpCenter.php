<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    protected $table = 'tbl_help_center';
    protected $fillable = [];

    public function helpCategory()
    {
        return $this->belongsTo(HelpCategory::class , 'hceHcId' , 'id');
    }
}
