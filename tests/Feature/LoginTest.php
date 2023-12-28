<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Perform a login test.
     */
    public function test_do_register_and_then_login(): void
    {
        $email = 'user+' . time() . '@nice.local';
        $password = 'password' . (rand(0, 3) == 0 ? '1' : '0');

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => $email,
            'password' => $password,
            //'password_confirmation' => 'password0', looks like a mistake
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(200);

        // Do login
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $response->assertContent(json_encode([
            'token' => $response->json()['token'],
        ]));
    }
}
