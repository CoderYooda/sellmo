<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;
    public function testSuccessRegister(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/register', [
            'name' => 'Sally',
            'email' => 'TestEmail@email.com',
            'password' => '315405',
            'password_confirmation' => '315405'
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated($guard = null);
        $this->assertDatabaseHas('users', [
            'email' => 'TestEmail@email.com',
        ]);
    }

    public function testSuccessLogin(): void
    {
        /** @var User $user */
        $user = User::factory(null, [
            'email' => 'test@mail.com',
            'password' => bcrypt('test')
        ])->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/login', [
            'email' => $user->getEmail(),
            'password' => 'test',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user, $guard = null);
    }

    public function testSuccessLogout(): void
    {
        /** @var User $user */
        $user = User::factory(null, [
            'email' => 'test@mail.com',
            'password' => bcrypt('test')
        ])->create();

        $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/login', [
            'email' => $user->getEmail(),
            'password' => 'test',
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/logout');

        $response->assertStatus(200);
        $this->assertGuest('web');
    }

    public function testInvalidParamsRegister(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/register', [
            'name' => 'Sally',
            'email' => 'VeryLongEmailVeryLongEmailVeryLongEmailVeryLongEmail@email.com',
            'password' => '315405',
            'password_confirmation' => '315405'
        ]);

        $response->assertStatus(422);
    }

    public function testInvalidParamsRegister1(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/register', [
            'name' => '',
            'email' => 'VeryLongEmail@email.com',
            'password' => '315405',
            'password_confirmation' => '315405'
        ]);

        $response->assertStatus(422);
    }

    public function testInvalidParamsRegister2(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/register', [
            'name' => 'Sally',
            'email' => 'VeryLongEmail@email.com',
            'password' => '315405',
            'password_confirmation' => ''
        ]);

        $response->assertStatus(422);
    }
}
