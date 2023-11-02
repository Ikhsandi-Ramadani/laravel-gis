<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kecamatans = Kecamatan::all();
        return view('pages.kecamatan.index', compact('kecamatans'));
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
    public function store(Request $request)
    {
        Kecamatan::create($request->all());
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
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
    public function update(Request $request, string $id)
    {
        $kecamatan = Kecamatan::findorfail($id);
        $kecamatan->update($request->all());
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kecamatan = Kecamatan::findorfail($id);
        $kecamatan->delete();
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
