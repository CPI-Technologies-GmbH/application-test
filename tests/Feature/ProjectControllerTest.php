<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    //TODO generally test should use data providers to minimalist number of code duplication

    protected string $email;

    protected string $password = 'password';

    protected string $authCode;

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

    public function testCreateUserAccount(): void
    {
        $this->email = 'user'.rand(0, 10000).'+'.time().'@nice.local';

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

    public function testProjectIndex(): void
    {
        $response = $this->getJson(route('projects.index'));
        $response->assertOk();
    }

    public function testCreateProject(): void
    {
        $response = $this->postJson(route('projects.create'), [
            'name' => 'test',
            'description' => 'test',
        ]);
        $response->assertStatus(201);
    }

    public function testCreateProjectNameToShort(): void
    {
        $response = $this->postJson(route('projects.create'), [
            'name' => static::generateRandomString(1),
            'description' => 'test',
        ]);
        $response->assertUnprocessable();
    }

    public function testCreateProjectNameToLong(): void
    {
        $response = $this->postJson(route('projects.create'), [
            'name' => static::generateRandomString(1203),
            'description' => 'test',
        ]);
        $response->assertUnprocessable();
    }

    public function testCreateProjectDescriptionToLong(): void
    {
        $response = $this->postJson(route('projects.create'), [
            'name' => static::generateRandomString(5),
            'description' => static::generateRandomString(13434),
        ]);
        $response->assertUnprocessable();
    }

    public function testCreateProjectDescriptionToShort(): void
    {
        $response = $this->postJson(route('projects.create'), [
            'name' => static::generateRandomString(5),
            'description' => static::generateRandomString(1),
        ]);
        $response->assertUnprocessable();
    }

    public function testUpdateProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->putJson(route('projects.update', $project->id), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'test Update',
            'description' => 'test Update',
        ]);
        $response->assertOk();
    }

    public function testUpdateNameToShortProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->putJson(route('projects.update', $project->id), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'te',
            'description' => 'test Update',
        ]);
        $response->assertUnprocessable();
    }

    public function testUpdateNameToLongProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->putJson(route('projects.update', $project->id), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => static::generateRandomString(1000),
            'description' => 'test Update',
        ]);
        $response->assertUnprocessable();
    }

    public function testUpdateDescriptionToLongProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->putJson(route('projects.update', $project->id), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'test',
            'description' => static::generateRandomString(1000),
        ]);
        $response->assertUnprocessable();
    }

    public function testUpdateDescriptionToShortProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->putJson(route('projects.update', $project->id), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'test',
            'description' => static::generateRandomString(1),
        ]);
        $response->assertUnprocessable();
    }

    public function testUpdateProjectAnotherUser(): void
    {
        $project = Project::factory(1)->create(['user_id' => User::factory()->create()->first()->id])->first();

        $response = $this->putJson(route('projects.update', $project->id), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'test Update',
            'description' => 'test Update',
        ]);
        $response->assertForbidden();
    }

    public function testUpdateNotExistingProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => User::factory()->create()->first()->id])->first();

        $response = $this->putJson(route('projects.update', self::NOT_EXISTING_PROJECT_ID), [
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'name' => 'test Update',
            'description' => 'test Update',
        ]);
        $response->assertNotFound();
    }

    public function testRemoveProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();
        $response = $this->deleteJson(route('projects.delete', $project->id));
        $response->assertNoContent();
    }

    public function testRemoveFromAnotherUserProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => User::factory()->create()->first()->id])->first();
        $response = $this->deleteJson(route('projects.delete', $project->id));
        $response->assertForbidden();
    }

    public function testRemoveNotExistingProject(): void
    {
        $response = $this->deleteJson(route('projects.delete', self::NOT_EXISTING_PROJECT_ID));
        $response->assertNotFound();
    }

    public function tesShowProject(): void
    {
        $project = Project::factory(1)->create(['user_id' => $this->user->id])->first();

        $response = $this->deleteJson(route('projects.show', $project->id));
        $response->assertOk();
    }

    public function tesShowNotExistingProject(): void
    {
        $response = $this->deleteJson(route('projects.show', self::NOT_EXISTING_PROJECT_ID));
        $response->assertNotFound();
    }

    public function tesShowProjectForDifferentUser(): void
    {
        $project = Project::factory(1)->create(['user_id' => User::factory()->create(1)->first()->id])->first();

        $response = $this->deleteJson(route('projects.show', $project->id));
        $response->assertForbidden();
    }

    /**
     * @return string
     */
    private static function generateRandomString($length)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
