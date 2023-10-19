<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $projects = $user->projects;

        return ProjectResource::collection($projects);
    }

    // TODO: Add validation
    public function store() {
        // Create a new project
        $project = Projects::create([
            'name' => request()->name,
            'description' => request()->description,
            'user_id' => auth()->user()->id,
        ]);

        // Return the created project
        return new ProjectResource($project);
    }

    // TODO: Add validation
    public function update(Projects $project) {
        $this->authorize('update', $project);

        // Update the project
        $project->update([
            'name' => request()->name,
            'description' => request()->description,
        ]);

        // Return the updated project
        return new ProjectResource($project);
    }

    // TODO: Add validation
    public function destroy(Projects $project) {
        $this->authorize('delete', $project);

        // Delete the project
        $project->delete();

        // Return the successful response
        return response()->json(['project deleted successfully']);
    }

    // TODO: Add validation
    public function show(Projects $project) {
        $this->authorize('view', $project);

        // Return the project
        return new ProjectResource($project);
    }
}
