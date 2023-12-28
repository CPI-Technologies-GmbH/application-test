<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create()
    {
        // Create a new project
        $project = Projects::create([
            'name' => request()->name,
            'description' => request()->description,
            'user_id' => auth()->user()->id,
        ]);

        // Return the created project
        return new ProjectResource($project);
    }

    public function show($id)
    {
        // Find the project by ID
        $project = Projects::findOrFail($id);

        // Return the project
        return new ProjectResource($project);
    }

    public function update(Request $request, $id)
    {
        // Find the project by ID
        $project = Projects::findOrFail($id);

        // Update the project
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Return the updated project
        return new ProjectResource($project);
    }

    public function destroy($id)
    {
        // Find the project by ID
        $project = Projects::findOrFail($id);

        // Delete the project
        $project->delete();

        // Return a success response
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function index()
    {
        // Get all projects
        $projects = Projects::all();

        // Return the projects
        return ProjectResource::collection($projects);
    }
}

