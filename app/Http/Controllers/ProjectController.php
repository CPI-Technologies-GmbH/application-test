<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Projects;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create(Request $request, User $user) {
        // Create a new project
        $project = Projects::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id,
        ]);

        // Return the created project
        return new ProjectResource($project);
    }

    public function getAll(Request $request) {
        $user = $request->user();
        $projects = $user->projects;
        return ProjectResource::collection($projects);
    }

    public function getOne(string $id) {
        return new ProjectResource(Projects::get($id));
    }

    public function delete(string $id) {
        Projects::destroy($id);
        return response('', 204);
    }

    public function update(Request $request, string $id) {
        $project = Projects::get($id);
        foreach ($request->post() as $key => $value) {
            $project->{$key} = $value;
        }
        return new ProjectResource($project);
    }
}
