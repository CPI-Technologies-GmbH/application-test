<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ProjectsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TheTimeTrackControllerTest extends TestCase
{
    use RefreshDatabase;

    // Before each test, create a user account
    protected function setUp(): void {
        parent::setUp();
        $this->seed([
            UsersTableSeeder::class,
            ProjectsTableSeeder::class
        ]);
    }


    public function test_tometrack_can_be_start(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );

        $response = $this->post('/timetrack/start', ['project_id'=>1]);
        $response->assertStatus(200);
    }

    public function test_tometrack_can_be_stop(): void
    {
        Sanctum::actingAs(
            User::find(1),
            []
        );
        $response = $this->post('/timetrack/start', ['project_id'=>1]);
        $response->assertStatus(200);
        $response = $this->post('/timetrack/stop', ['project_id'=>1]);
        $response->assertStatus(200);
    }

}
