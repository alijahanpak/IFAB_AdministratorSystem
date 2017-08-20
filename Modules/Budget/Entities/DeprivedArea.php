<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\Region;
use Modules\Admin\Entities\RuralDistrict;
use Modules\Admin\Entities\Village;

class DeprivedArea extends Model
{
    protected $table = 'tbl_deprived_areas';
    protected $fillable = [];

    public static function getDeprivedAreaLabel($daId)
    {
        $dArea = DeprivedArea::find($daId);
        return County::find($dArea->daCoId)->coName .
        ($dArea->daReId == '' ? '' : ' - ' . Region::find($dArea->daReId)->reName) .
        ($dArea->daRdId == '' ? '' : ' - ' . RuralDistrict::find($dArea->daRdId)->rdName) .
        ($dArea->daViId == '' ? '' : ' - ' . Village::find($dArea->daViId)->viName);
    }
}