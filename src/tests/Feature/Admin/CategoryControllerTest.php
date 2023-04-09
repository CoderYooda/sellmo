<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\User;
use App\Operations\Company\CompanyOperation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $companyOperation = resolve(CompanyOperation::class);
        $this->user = $companyOperation->create(
            'Тестовая компания',
            'Тестер',
            'Тестеров',
            'Тестерович',
            'ТестерИмя',
            'tester@gmail.com',
            'testPassword',
        );
    }

    public function testCategoriesTreeSuccess(): void
    {
        $company = $this->user->getCompany();

        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories', [
            'root_category_id' => 0,
            'company_id' => $company->id,
        ]);

        $response->assertStatus(200);
    }

    public function testCategoriesTreeForceFailed(): void
    {
        $company = $this->user->getCompany();

        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories', [
            'root_category_id' => 0,
            'force' => 1,
            'company_id' => $company->id,
        ]);

        $response->assertStatus(403);
    }

    public function testCategoriesTreeForceSuccess(): void
    {
        $company = $this->user->getCompany();

        $this->user->givePermissionTo(Permission::CAN_VIEW_CATEGORY_TREE_FORCE);

        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories', [
            'root_category_id' => 0,
            'force' => 1,
            'company_id' => $company->id,
        ]);

        $response->assertStatus(200);
    }
}
