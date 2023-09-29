<?php

namespace App\Http\Controllers;

use App\Models\Pengawas;
use App\Models\User;
use Illuminate\Http\Request;

class PengawasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengawass = User::where('role', 'pengawas')->get();
        return view('pages.pengawas.index', compact('pengawass'));
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
        Pengawas::create($request->all());
        return redirect()->route('pengawas.index')->with('success', 'Pengawas berhasil ditambahkan.');
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
        $pengawas = Pengawas::findorfail($id);
        $pengawas->update($request->all());
        return redirect()->route('pengawas.index')->with('success', 'Pengawas berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengawas = Pengawas::findorfail($id);
        $pengawas->delete();
        return redirect()->route('pengawas.index')->with('success', 'Pengawas berhasil dihapus.');
    }
}
