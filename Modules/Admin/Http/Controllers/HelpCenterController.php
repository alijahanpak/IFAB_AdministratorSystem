<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\HelpCategory;
use Modules\Admin\Entities\HelpCenter;
use Modules\Admin\Entities\SubSystem;

class HelpCenterController extends Controller
{
    public function getAllSubSystem()
    {
        return \response()->json(
            SubSystem::all()
        );
    }

    public function getHelpCategory(Request $request)
    {
        return \response()->json(
            HelpCategory::where('hcSSId' , '=' , $request->ssId)->get()
        );
    }

    public function getHelpCenter(Request $request)
    {
        return \response()->json(
            HelpCenter::with('helpCategory')->where('hceHcId' , '=' , $request->hcId)->get()
        );
    }
}
