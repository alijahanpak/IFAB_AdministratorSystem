<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class PrintHistory extends Model
{
    protected $fillable = [];
    protected $table = 'tbl_print_history';
    protected $appends = ['pShamsiPrintDate'];

    public function getPShamsiPrintDateAttribute()
    {
        return jDate::forge($this->created_at)->format('h:m:s - Y/m/d');
    }
}
