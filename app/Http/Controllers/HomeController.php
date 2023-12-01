<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $projects = Projects::all();
        return view('home', compact('projects'));
    }
}
