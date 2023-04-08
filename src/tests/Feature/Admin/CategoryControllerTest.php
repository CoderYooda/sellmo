<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testCategoriesTreeNoCompany()
    {
        /** @var User $user */
        $user = User::factory(null, [
            'email' => 'test@mail.com',
            'password' => bcrypt('test')
        ])->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories', [
            'root_category_id' => 0,
        ]);

        $response->assertStatus(422);
    }
}
