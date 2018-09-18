<?php

namespace Modules\Financial\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Financial\Entities\Executor;

class ExecutorController extends Controller
{
    function fetchAllExecutors(Request $request)
    {
        return Executor::all();
    }
}
