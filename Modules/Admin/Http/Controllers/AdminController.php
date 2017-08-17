<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Region;
use Modules\Admin\Entities\RuralDistrict;
use Modules\Admin\Entities\Village;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

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
}
