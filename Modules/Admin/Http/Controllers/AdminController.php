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
    public function getRegionsByCountyId($cId)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            $region = Region::where('reCoId' , '=' , $cId)->get();
            return \Illuminate\Support\Facades\Response::json($region);
        }

    }

    public function getRuralDistrictByRegionId($rId)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            $ruralDistricts = RuralDistrict::where('rdReId' , '=' , $rId)->get();
            return \Illuminate\Support\Facades\Response::json($ruralDistricts);
        }

    }

    public function getVillagesByRuralDistrictId($rId)
    {
        if (\Illuminate\Support\Facades\Request::ajax())
        {
            $ruralDistricts = Village::where('viRdId' , '=' , $rId)->get();
            return \Illuminate\Support\Facades\Response::json($ruralDistricts);
        }

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
