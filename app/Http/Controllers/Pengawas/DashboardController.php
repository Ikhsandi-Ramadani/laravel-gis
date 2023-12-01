<?php

namespace App\Http\Controllers\Pengawas;

use App\Models\User;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pengawas = User::findorfail(auth()->user()->id);
        $projects = Projects::where('status', 0)->where('pengawas_id', $pengawas->id)->get();
        return view('pengawas.dashboard.index', compact('projects'));
    }
}
