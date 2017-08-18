<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'tbl_system_log';
    protected $fillable = [];

    public static function setBudgetSubSystemAdminLog($log)
    {
        $systemLog = new SystemLog;
        $systemLog->slUId = 1;
        $systemLog->slSubSystem = 'مدیریت زیر سیستم بودجه';
        $systemLog->slLogText = $log;
        $systemLog->save();
    }

    public static function setBudgetSubSystemLog($log)
    {
        $systemLog = new SystemLog;
        $systemLog->slUId = 1;
        $systemLog->slSubSystem = 'زیر سیستم بودجه';
        $systemLog->slLogText = $log;
        $systemLog->save();
    }
}
