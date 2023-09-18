<?php

namespace App\Http\Controllers;

use App\Models\Type;
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
        $projects = Projects::all();
        return view('pages.project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengawass = Pengawas::all();
        $types = Type::all();
        return view('pages.project.create', compact('pengawass', 'types'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Projects::findorfail($id);
        $pengawass = Pengawas::all();
        $types = Type::all();
        return view('pages.project.edit', compact('pengawass', 'types', 'project'));
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
}