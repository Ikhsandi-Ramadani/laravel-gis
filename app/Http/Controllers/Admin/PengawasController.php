<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Pengawas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PengawasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengawass = User::where('role', 'pengawas')->get();
        return view('admin.pages.pengawas.index', compact('pengawass'));
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
        User::create([
            'name' => $request->name,
            'username' => Str::lower(str_replace(' ', '', $request->name)),
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pengawas'
        ]);
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
        // $pengawas = Pengawas::findorfail($id);
        // $pengawas->update($request->all());
        $pengawas = User::findorfail($id);
        $pengawas->update([
            'name' => $request->name,
            'username' => Str::lower(str_replace(' ', '', $request->name)),
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $pengawas->password,
            'role' => 'pengawas'
        ]);
        return redirect()->route('pengawas.index')->with('success', 'Pengawas berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengawas = User::findorfail($id);
        $pengawas->delete();
        return redirect()->route('pengawas.index')->with('success', 'Pengawas berhasil dihapus.');
    }
}
