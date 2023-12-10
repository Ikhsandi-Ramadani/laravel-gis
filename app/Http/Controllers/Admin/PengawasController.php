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
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $foto = $request->foto;
        $destinationPath = 'foto/';
        $profileImage = date('YmdHis') . "." . $foto->getClientOriginalExtension();
        $foto->move($destinationPath, $profileImage);

        User::create([
            'name' => $request->name,
            'username' => Str::lower(str_replace(' ', '', $request->name)),
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pengawas',
            'foto' => $profileImage
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
        $pengawas = User::findorfail($id);

        if ($request->has('foto')) {
            $foto = $request->foto;
            $destinationPath = 'foto/';
            $profileImage = date('YmdHis') . "." . $foto->getClientOriginalExtension();
            $foto->move($destinationPath, $profileImage);
        } else {
            $profileImage = $pengawas->foto;
        }

        $pengawas->update([
            'name' => $request->name,
            'username' => Str::lower(str_replace(' ', '', $request->name)),
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $pengawas->password,
            'role' => 'pengawas',
            'foto' => $profileImage
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
