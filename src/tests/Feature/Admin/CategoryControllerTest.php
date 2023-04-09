<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Company;
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
    protected User $siblingsUser;
    protected Category $rootCategory;
    protected Company $ownCompany;
    protected Company $siblingsCompany;

    public function setUp(): void
    {
        parent::setUp();
        Category::query()->delete();

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
        $this->siblingsUser = $companyOperation->create(
            'Тестовая компания 2',
            'Тестер2',
            'Тестеров2',
            'Тестерович2',
            'ТестерИмя',
            'tester2@gmail.com',
            'testPassword',
        );

        $this->ownCompany = $this->user->getCompany();
        $this->siblingsCompany = $this->siblingsUser->getCompany();

        $this->rootCatgory = Category::create([
            'name' => 'Главная категория',
            'type' => Category::TYPE_SYSTEM,
            'children' => [
                [
                    'name' => 'Своя главная подкатегория',
                    'type' => Category::TYPE_PUBLIC,
                    'company_id' => $this->ownCompany->id,
                ],
                [
                    'name' => 'Чужая главная подкатегория',
                    'type' => Category::TYPE_PUBLIC,
                    'company_id' => $this->siblingsCompany->id,
                    'children' => [
                        [
                            'name' => 'Чужая дочерняя категория',
                            'type' => Category::TYPE_PUBLIC,
                            'company_id' => $this->siblingsCompany->id,
                        ],
                    ],
                ],
            ],
        ]);
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function testCreateSuccess(): void
    {
        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories/create', [
            'parent_id' => $this->rootCatgory->id,
            'name' => 'Новая категория компании',
            'company_id' => $this->ownCompany->id,
        ]);

        $responseArray = json_decode($response->getContent(), true);

        $this->assertEquals('novayakategoriyakompanii', $responseArray['category']['slug']);
        $this->assertEquals($this->ownCompany->id, $responseArray['category']['company_id']);
        $this->assertEquals($this->rootCatgory->id, $responseArray['category']['parent_id']);
        $this->assertEquals(Category::TYPE_PUBLIC, $responseArray['category']['type']);
        $this->assertEquals('Новая категория компании', $responseArray['category']['name']);
    }

    public function testCreateCategoryToSiblingsError()
    {
        $targetCategory = Category::where('name', 'Чужая главная подкатегория')->first();
        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories/create', [
            'parent_id' => $targetCategory->id,
            'name' => 'Новая неверная компании',
            'company_id' => $this->ownCompany->id,
        ]);

        $response->assertStatus(403);
    }

    public function testUpdateSuccess(): void
    {
        $targetCategory = Category::where('name', 'Своя главная подкатегория')->first();
        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories/update', [
            'parent_id' => $this->rootCatgory->id,
            'name' => 'Новая категория компании',
            'category_id' => $targetCategory->id,
        ]);

        $responseArray = json_decode($response->getContent(), true);

        $this->assertEquals('novayakategoriyakompanii', $responseArray['category']['slug']);
        $this->assertEquals($this->ownCompany->id, $responseArray['category']['company_id']);
        $this->assertEquals($this->rootCatgory->id, $responseArray['category']['parent_id']);
        $this->assertEquals(Category::TYPE_PUBLIC, $responseArray['category']['type']);
        $this->assertEquals('Новая категория компании', $responseArray['category']['name']);
    }

    public function testUpdateWrongCategory(): void
    {
        $targetCategory = Category::where('name', 'Чужая главная подкатегория')->first();
        $response = $this->actingAs($this->user)->withHeaders([
            'Accept' => 'application/json'
        ])->post('/categories/update', [
            'parent_id' => $this->rootCatgory->id,
            'name' => 'Новая категория компании',
            'category_id' => $targetCategory->id,
        ]);

        $response->assertStatus(403);
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
