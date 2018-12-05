<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class ActionHistory extends Model
{
    protected $appends = ['ahShamsiDate' , 'ahShamsiTime'];
    protected $fillable = [];
    protected $table = 'tbl_action_history';

    public function getAhShamsiDateAttribute()
    {
        return jDate::forge($this->created_at)->format('Y/m/d');
    }

    public function getAhShamsiTimeAttribute()
    {
        return jDate::forge($this->created_at)->format('time');
    }
}
