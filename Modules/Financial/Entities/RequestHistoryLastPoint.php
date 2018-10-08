<?php

namespace Modules\Financial\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestHistoryLastPoint extends Model
{
    protected $fillable = ['rhlpRId' , 'rhlpRsId' , 'rhlpRlId' ,'rhlpPrId' , 'rhlpDescription'];
    protected $table = 'tbl_request_history_last_points';
}
