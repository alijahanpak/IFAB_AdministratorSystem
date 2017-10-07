<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\County;
use Modules\Admin\Entities\Region;
use Modules\Admin\Entities\RuralDistrict;
use Modules\Admin\Entities\Season;
use Modules\Admin\Entities\Village;

class AdminController extends Controller
{
    public function getRegionsByCountyId(Request $request)
    {
            $region = Region::where('reCoId' , '=' , $request->coId)->get();
            return \response()->json($region);
    }

    public function getRuralDistrictByRegionId(Request $request)
    {
        $ruralDistricts = RuralDistrict::where('rdReId' , '=' , $request->reId)->get();
        return \response()->json($ruralDistricts);
    }

    public function getVillagesByRuralDistrictId(Request $request)
    {
        $ruralDistricts = Village::where('viRdId' , '=' , $request->rdId)->get();
        return \response()->json($ruralDistricts);
    }

    public function getAllCounties()
    {
        return \response()->json(County::all());
    }

    public function getAllSeasons()
    {
        return \response()->json(Season::all());
    }
}
