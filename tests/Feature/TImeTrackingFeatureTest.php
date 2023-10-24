<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\TimeTracking;
use App\Models\User;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TImeTrackingFeatureTest extends TestCase
{
    /**
     * @var User|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    protected ?User $user;

    const NOT_EXISTING_PROJECT_ID = 999999999;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user, ['*']);
    }

    public function testStartTimer(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->postJson(route('projects.time_tracking.start', $project->id));
        $response->assertOk();
    }

    public function testStartTimerTwoTimes(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->postJson(route('projects.time_tracking.start', $project->id));
        $response->assertOk();
        $response = $this->postJson(route('projects.time_tracking.start', $project->id));
        $response->assertUnprocessable();
    }

    public function testStopTimer(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        TimeTracking::factory(1)->create([
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'start_time' => Carbon::now()->subDay(),
        ]);
        $response = $this->postJson(route('projects.time_tracking.stop', $project->id));
        $response->assertOk();
    }

    public function testStopTimerTwoTimes(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        TimeTracking::factory(1)->create([
            'user_id' => $this->user->id,
            'project_id' => $project->id,
            'start_time' => Carbon::now()->subDay(),
        ]);
        $response = $this->postJson(route('projects.time_tracking.stop', $project->id));
        $response->assertOk();

        $response = $this->postJson(route('projects.time_tracking.stop', $project->id));
        $response->assertUnprocessable();
    }

    public function testStopTimerForNotStartedTimer(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->postJson(route('projects.time_tracking.stop', $project->id));
        $response->assertUnprocessable();
    }
}
