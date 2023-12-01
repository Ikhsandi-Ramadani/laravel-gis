<?php

namespace App\Http\Controllers\Pengawas;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Projects;
use Illuminate\Http\Request;

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

        $fileName = time() . '.' . $request->foto->extension();
        $request->foto->storeAs('public/foto', $fileName);

        Laporan::create([
            'project_id' => $project_id,
            'foto'      => $fileName,
            'catatan'   => $request->catatan,
            'tanggal'   => $request->tanggal
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

        if ($request->has('foto')) {
            $path = public_path() . '/storage/foto/' . $laporan->foto;
            unlink($path);

            $fileName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/foto', $fileName);

            $laporan->update([
                'project_id' => $project_id,
                'foto'      => $fileName,
                'catatan'   => $request->catatan,
                'tanggal'   => $request->tanggal
            ]);
        } else {
            $laporan->update([
                'project_id' => $project_id,
                'catatan'   => $request->catatan,
                'tanggal'   => $request->tanggal
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
        $path = public_path() . '/storage/foto/' . $laporan->foto;
        unlink($path);
        $laporan->delete();

        return redirect()->route('laporan.index', $project_id)->with('success', 'Laporan berhasil dihapus.');
    }
}
