<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Projects;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pengawas = User::where("role", "pengawas")->get()->count();
        $kecamatan = Kecamatan::count();
        $berjalan = Projects::where("status", 0)->get()->count();
        $selesai = Projects::where("status", 1)->get()->count();
        return view("admin.pages.dashboard.index", compact("pengawas", 'kecamatan', 'berjalan', 'selesai'));
    }
}
