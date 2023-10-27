<?php

namespace Tests\Feature;

use App\Models\Projects;
use App\Models\User;
use Database\Seeders\ProjectsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TheProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    // Before each test, create a user account
    protected function setUp(): void {
        parent::setUp();
        //$this->seed();
        $this->seed([
            UsersTableSeeder::class,
            ProjectsTableSeeder::class
        ]);
    }

    public function test_project_can_be_index(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );

        $response = $this->get('/projects');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'description'
                ]
            ],
        ]);
    }

    public function test_project_can_be_store(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );

        $project = Projects::factory()->create([
            'id' => 100,
            'name' => 'Project3',
            'user_id' => 1,
        ]);

        $response = $this->post('/projects', $project->toArray());
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                    'id', 'name', 'description'
            ],
        ]);
    }

    public function test_project_can_be_show(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );

        $project = Projects::factory()->create([
            'id' => 100,
            'name' => 'Project3',
            'user_id' => 1,
        ]);

        $response = $this->get('/projects/1');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description'
            ],
        ]);
    }

    public function test_project_can_be_update(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );

        $response = $this->put('/projects/1', ['name' => 'update1', 'description' => 'some desription']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description'
            ],
        ]);
        $response->assertJsonPath('data.name', 'update1');
    }

    public function test_project_can_be_destroy(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );

        $response = $this->delete('/projects/1');
        $response->assertStatus(204);
    }

}
