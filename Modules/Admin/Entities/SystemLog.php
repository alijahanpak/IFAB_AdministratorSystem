<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SystemLog extends Model
{
    protected $table = 'tbl_system_log';
    protected $fillable = [];

    public static function setBudgetSubSystemAdminLog($log)
    {
        $systemLog = new SystemLog;
        $systemLog->slUId = Auth::user()->id;
        $systemLog->slSubSystem = 'مدیریت زیر سیستم بودجه';
        $systemLog->slLogText = $log;
        $systemLog->save();
    }

    public static function setBudgetSubSystemLog($log)
    {
        $systemLog = new SystemLog;
        $systemLog->slUId = Auth::user()->id;
        $systemLog->slSubSystem = 'زیر سیستم بودجه';
        $systemLog->slLogText = $log;
        $systemLog->save();
    }

    public static function setFinancialSubSystemLog($log)
    {
        $systemLog = new SystemLog;
        $systemLog->slUId = Auth::user()->id;
        $systemLog->slSubSystem = 'زیر سیستم مالی';
        $systemLog->slLogText = $log;
        $systemLog->save();
    }
}
