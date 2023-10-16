<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Projects;
use App\Models\User;

class TheProjectTest extends TestCase
{
    protected $email;
    protected $password = 'password';
    protected $authCode;

    // Before each test, create a user account
    protected function setUp(): void {
        parent::setUp();
        $this->create_user_account();
    }

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

    public function test_create_project(): void
    {
        // Create project + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post('/projects', [
            'name' => 'test',
            'description' => 'test',
        ]);
        $response->assertStatus(201);
    }

    // TODO: we can also check database in these tests

    public function test_index_project(): void
    {
        // Index projects + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->get('/projects', [
            'name' => 'test',
            'description' => 'test',
        ]);

        $response->assertStatus(200);
    }

    public function test_update_project(): void
    {
        $user = User::where('email', $this->email)->first();

        // TODO: use factory
        $project = Projects::create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user->id,
        ]);

        // Create project + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->put("/projects/{$project->id}", [
            'name' => 'test',
            'description' => 'test',
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_project(): void
    {
        $user = User::where('email', $this->email)->first();

        // TODO: use factory
        $project = Projects::create([
            'name' => 'test',
            'description' => 'test',
            'user_id' => $user->id,
        ]);

        // Create project + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->delete("/projects/{$project->id}", []);

        $response->assertStatus(200);
    }

    // Write tests for checking the authorization
}
