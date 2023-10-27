<?php

namespace App\Http\Factories;

use App\Dto\ProjectDTO;
use Illuminate\Http\Request;

class ProjectDTOFactory
{

    /**
     * @param Request $request
     * @return ProjectDTO
     */
    public static function fromRequest(Request $request): ProjectDTO
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        return self::fromArray($data);
    }

    /**
     * @param array $data
     * @return ProjectDTO
     */
    public static function fromArray(array $data): ProjectDTO
    {
        $projectDTO = new ProjectDTO();
        $projectDTO->name = $data['name'];
        $projectDTO->description = $data['description'];
        $projectDTO->user_id = $data['user_id'];
        return $projectDTO;
    }
}
