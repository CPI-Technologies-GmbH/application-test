<?php

namespace App\Http\Repositories;

use App\Dto\ProjectDTO;
use App\Models\Projects;
use App\Models\User;
use Illuminate\Support\Collection;

class ProjectRepository
{
    /**
     * Get the list of Projects for current user
     *
     * @param User $user
     * @return Collection
     */
    public function getUserProjects(User $user): Collection
    {
        return Projects::where('user_id', $user->id)->get();
    }

    /**
     * Create new Project
     *
     * @param ProjectDTO $dto
     * @return mixed
     */
    public function createProject(ProjectDTO $dto): Projects
    {
        return Projects::create([
            'name' => $dto->name,
            'description' => $dto->description,
            'user_id' => $dto->user_id,
        ]);
    }

    /**
     * Get user Project by Id
     *
     * @param User $user
     * @param int $id
     * @return Projects|null
     */
    public function getUserProjectById(User $user, int $id): Projects|null
    {
        return Projects::where('user_id', $user->id)->where('id', $id)->first();
    }

    /**
     * Update user Project
     *
     * @param User $user
     * @param int $id
     * @param ProjectDTO $dto
     * @return Projects|null
     */
    public function updateProject(User $user, int $id, ProjectDTO $dto): Projects|null
    {
        Projects::where('id',$id)->where('user_id', $user->id)->update(['name' => $dto->name, 'description' => $dto->description]);
        return $this->getUserProjectById($user, $id);
    }

    /**
     * Delete user Project
     *
     * @param User $user
     * @param int $id
     * @return int
     */
    public function deleteProject(User $user, int $id): int
    {
        return Projects::where('id',$id)->where('user_id',$user->id)->delete();
    }

}
