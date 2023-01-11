<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{

    public function index()
    {
        return view('projects.index', [
            'projects' => DB::table('projects')->paginate(16)
        ]);
    }

    public function show($id)
    {
        $project = Project::whereId($id)->first();
        $project->views++;
        $project->save();

        return view('projects.show', compact('project'));
    }
}
