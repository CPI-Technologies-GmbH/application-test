<?php

namespace Database\Seeders;

use App\Models\Projects;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Projects::factory()->create([
            'id' => 1,
            'name' => 'Project1',
            'user_id' => 1,
        ]);
        Projects::factory()->create([
            'id' => 2,
            'name' => 'Project1',
            'user_id' => 2,
        ]);
    }
}
