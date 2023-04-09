<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testSuccessRegister(): void
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/register', [
            'name' => 'Sally',
            'email' => 'TestEmail@email.com',
            'password' => '315405',
            'password_confirmation' => '315405',
            'first_name' => 'Тестер',
            'last_name' => 'Тестеров',
            'middle_name' => 'Тестерович',
            'company_name' => 'Тестовая компания',
        ]);

        $user = User::where('email', 'TestEmail@email.com')->first();

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
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

    /**
     * @return string[][]
     */
    public function invalidRegisterDataProvider(): array
    {
        return [
            ['Sally', 'TestEmailTestEmailTestEmailTestEmailTest@email.com', '313131', '313131', 'Тестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['Sally', 'TestEmail@email.com', '313131', '', 'Тестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['Sally', 'TestEmail@email.com', '', '313131', 'Тестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['', 'TestEmail@email.com', '313131', '313131', 'Тестер', 'ТестеровТестерТестерТестерТестерТестер', 'Тестерович', 'МКК Монетка'],
            ['Sally', 'email.com', '313131', '313131', 'Тестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['Sally', 'TestEmail@email.com', '123456789012345', '123456789012345', 'Тестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['Sellmo', 'TestEmail@email.com', '313131', '313131', 'ТестерТестерТестерТестерТестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['Sellmo', '', '313131', '313131', 'Тестер', 'Тестеров', 'Тестерович', 'МКК Монетка'],
            ['Sellmo', 'TestEmail@email.com', '313131', '313131', 'Тестер', 'Тестеров', 'Тестерович', 'Длинное Название Компании Длинное Название Компании Длинное Название Компании'],
        ];
    }

    /**
     * @param string|null $userName
     * @param string|null $email
     * @param string|null $password
     * @param string|null $confirmation
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $middleName
     * @param string|null $companyName
     * @return void
     * @dataProvider invalidRegisterDataProvider
     */
    public function testInvalidParamsRegister(
        ?string $userName,
        ?string $email,
        ?string $password,
        ?string $confirmation,
        ?string $firstName,
        ?string $lastName,
        ?string $middleName,
        ?string $companyName,
    ): void {
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/register', [
            'name' => $userName,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmation,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'middle_name' => $middleName,
            'company_name' => $companyName,
        ]);

        $response->assertStatus(422);
    }
}
