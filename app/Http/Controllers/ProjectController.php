<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Type;
use App\Models\User;
use App\Models\Pengawas;
use App\Models\Projects;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Projects::where('status', 0)->get();
        return view('pages.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengawass = User::where('role', 'pengawas')->get();
        $kecamatans = Kecamatan::all();
        return view('pages.project.create', compact('pengawass', 'kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Projects::create($request->all());
        return redirect()->route('project.index')->with('success', 'Project berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Projects::findorfail($id);
        return view('pages.project.detail', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Projects::findorfail($id);
        $pengawass = User::where('role', 'pengawas')->get();
        $kecamatans = Kecamatan::all();
        return view('pages.project.edit', compact('pengawass', 'project', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Projects::findorfail($id);
        $project->update($request->all());
        return redirect()->route('project.index')->with('success', 'Project berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Projects::destroy($id);
        return redirect()->route('project.index')->with('success', 'Project berhasil dihapus.');
    }

    // Monitoring
    public function monitoring()
    {
        $projects = Projects::where('status', 1)->get();
        return view('pages.monitoring.index', compact('projects'));
    }
}
