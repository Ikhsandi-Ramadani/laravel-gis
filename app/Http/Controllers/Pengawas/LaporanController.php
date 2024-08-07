<?php

namespace App\Http\Controllers\Pengawas;

use App\Models\Laporan;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($project_id)
    {
        $project = Projects::findorfail($project_id);
        $laporans = Laporan::where('project_id', $project->id)->get();
        return view('pengawas.laporan.index', compact('project', 'laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $project_id)
    {
        $request->validate([
            'catatan' => 'required',
            'tanggal' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $image = $request->file('foto');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('images');
        $image->move($destinationPath, $fileName);
        $url = asset('images/' . $fileName);

        $date = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        Laporan::create([
            'project_id' => $project_id,
            'foto'      => $url,
            'catatan'   => $request->catatan,
            'tanggal'   => $date
        ]);

        return redirect()->route('laporan.index', $project_id)->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $project_id, string $id)
    {
        $request->validate([
            'catatan' => 'required',
            'tanggal' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $laporan = Laporan::findorfail($id);

        $date = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        if ($request->has('foto')) {
            $path = public_path('images/' . $laporan->foto); 
            if (file_exists($path)) {
                unlink($path);
            }


            $image = $request->file('foto');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images');
            $image->move($destinationPath, $fileName);
            $url = asset('images/' . $fileName);

            $laporan->update([
                'project_id' => $project_id,
                'foto'      => $url,
                'catatan'   => $request->catatan,
                'tanggal'   => $date
            ]);
        } else {
            $laporan->update([
                'project_id' => $project_id,
                'catatan'   => $request->catatan,
                'tanggal'   => $date
            ]);
        }

        return redirect()->route('laporan.index', $project_id)->with('success', 'Laporan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($project_id, string $id)
    {
        $laporan = Laporan::findorfail($id);
        $path = public_path('images/' . $laporan->foto); 
        if (file_exists($path)) {
            unlink($path);
        }

        $laporan->delete();

        return redirect()->route('laporan.index', $project_id)->with('success', 'Laporan berhasil dihapus.');
    }
}
