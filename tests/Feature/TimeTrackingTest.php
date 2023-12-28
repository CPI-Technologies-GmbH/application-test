<?php

namespace Tests\Feature;

use App\Models\TimeTracking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeTrackingTest extends TestCase
{
    protected $email = "arvid24@example.org";
    protected $password = 'password';
    protected $authCode;

    protected function setUp(): void {
        parent::setUp();
        $this->login_user();
    }

    public function login_user(): void {
        $response = $this->post('/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->authCode = $response->json()['token'];
    }

    public function test_can_create_time_tracking() : void
    {
        $data = [
            'project_id' => 1,
            'user_id' => 5,
            'start_time' => '2022-01-01 10:00:00',
            'end_time' => '2022-01-01 18:00:00',
            'tracked' => '0'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post('/timetrackingsstore', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('timetracking', $data);
    }

    public function test_can_get_time_tracking() : void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->get('/timetrackingsindex');

        $response->assertStatus(200);
    }

    public function test_can_show_time_tracking() : void
    {
        $id = 3;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->get("/timetrackingsshow/{$id}");

        $response->assertStatus(200);
    }

    public function test_can_update_time_tracking() : void
    {
        $id = 3;
        $data = [
            'start_time' => '2022-01-01 10:00:00',
            'end_time' => '2022-01-01 18:00:00',
        ];       

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post("/timetrackingsupdate/{$id})", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('timetracking', $data);
    }

    public function test_can_delete_time_tracking() : void
    {
        $timeTracking = TimeTracking::orderBy('id','desc')->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->delete("/timetrackingsdestroy/{$timeTracking->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('timetracking', ['id' => $timeTracking->id]);
    }

    public function test_can_start_time_tracking() : void 
    {
        $id = 3;                
        $data =[
            'start_time' => date('Y-m-d H:i:s'),
            'description' => 'Starting time tracking',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post("/timetrackingsstart/{$id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('timetracking', $data);
    }
}

