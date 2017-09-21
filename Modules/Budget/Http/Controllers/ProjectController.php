<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ProjectController extends Controller
{
    public function approved_Projects(){
        return view('budget::pages.approved_projects.main',
            ['pageTitle' => 'ثبت پروژه های مصوب',
                'requireJsFile' => 'approved_projects']);
    }
}
