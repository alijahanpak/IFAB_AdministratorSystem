<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    protected $table = 'tbl_fiscal_years';
    protected $fillable = [];

    public static function getFYStatus($status)
    {
        if ($status == 0)
        {
            return 'غیر فعال';
        }
        elseif ($status == 1)
        {
            return 'فعال';
        }
        elseif ($status == 2)
        {
            return 'بسته شده';
        }
    }

    public static function activate($fyId)
    {
        $fiscalYear = FiscalYear::find($fyId);
        $fiscalYear->fyStatus = 1;
        $fiscalYear->save();
    }
}
