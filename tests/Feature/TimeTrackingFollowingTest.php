<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Projects;
use App\Models\TimeTrackingFollowing;
use App\Models\User;

class TimeTrackingFollowingTest extends TestCase
{
    protected $email;
    protected $password = 'password';
    protected $authCode;

    // Before each test, create a user account
    protected function setUp(): void {
        parent::setUp();
        $this->create_user_account();
    }

    // TODO: we can also check database in these tests

    public function create_user_account(): void {
        $this->email = 'user' . rand(0, 10000) . '+' . time() . '@nice.local';

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);

        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->authCode = $response->json()['token'];
    }

    /**
     * test starting time tracking following record.
     */
    public function test_start_time_tracking_following(): void
    {
        $user = User::where('email', $this->email)->first();

        $project = Projects::create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user->id,
        ]);

        // Create time tracking following + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post("/projects/{$project->id}/time-tracking-followings/start", []);

        $response->assertStatus(201);
    }

    /**
     * test ending time tracking following record.
     */
    public function test_end_time_tracking_following(): void
    {
        $user = User::where('email', $this->email)->first();

        // TODO: use factory
        $project = Projects::create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user->id,
        ]);

        // TODO: use factory
        $timeTrackingFollowing = TimeTrackingFollowing::create([
            'project_id' => $project->getKey(),
            'start_time' => now(),
        ]);

        // Create time tracking following + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post("/projects/{$project->id}/time-tracking-followings/{$timeTrackingFollowing->id}/end", []);

        $response->assertStatus(200);
    }

    /**
     * test ending time tracking following record for a different project.
     */
    public function test_end_time_tracking_following_for_different_project(): void
    {
        $user = User::where('email', $this->email)->first();

        // TODO: use factory
        $project = Projects::create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user->id,
        ]);

        $projects = Projects::create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user->id,
        ]);

        // TODO: use factory
        $timeTrackingFollowing = TimeTrackingFollowing::create([
            'project_id' => $projects->getKey(),
            'start_time' => now(),
        ]);

        // Create time tracking following + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post("/projects/{$project->id}/time-tracking-followings/{$timeTrackingFollowing->id}/end", []);

        $response->assertStatus(404);
    }
}
