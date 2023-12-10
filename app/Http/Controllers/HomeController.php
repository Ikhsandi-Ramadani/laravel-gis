<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Projects;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $projects = Projects::all();
        $kecamatans = Kecamatan::withCount('projects')->get();
        return view('home', compact('projects', 'kecamatans'));
    }

    public function kecamatan($kecamatan_id)
    {
        $kecamatans = Kecamatan::all();
        $kecamatan = Kecamatan::findorfail($kecamatan_id);
        $projects = Projects::where('kecamatan_id', $kecamatan->id)->get();
        return view('kecamatan', compact('kecamatan', 'projects', 'kecamatans'));
    }

    public function detail($project_id)
    {
        $kecamatans = Kecamatan::all();
        $project = Projects::findorfail($project_id);
        return view('detail-project', compact('project', 'kecamatans'));
    }

    public function rumus()
    {
        $kecamatans = Kecamatan::all();
        $hasil = false;
        return view('rumus', compact('kecamatans', 'hasil'));
    }

    public function hitung(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $referencePoint = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];

        $distances = $this->calculateDistances($referencePoint);
        $hasil = true;
        return view('rumus', compact('kecamatans', 'distances', 'hasil', 'latitude', 'longitude'));
    }

    private function calculateDistances($referencePoint)
    {
        $projects = Projects::all();

        $distances = [];

        foreach ($projects as $project) {
            $distance = $this->euclideanDistance(
                $referencePoint['latitude'],
                $referencePoint['longitude'],
                $project->latitude,
                $project->longitude
            );

            $distances[$project->id] = $distance;
        }

        asort($distances);
        // dd($distances);

        return $distances;
    }

    private function euclideanDistance($x1, $y1, $x2, $y2)
    {
        $hasil = sqrt(pow(($x1 - $x2), 2) + pow(($y1 - $y2), 2));
        return  $hasil * 111.319; // 1 derajat dalam kilometer
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius bumi dalam kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}
