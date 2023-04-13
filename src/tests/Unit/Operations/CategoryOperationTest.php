<?php

namespace Tests\Unit\Operations;

use App\Models\Category;
use App\Operations\System\CategoryOperation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryOperationTest extends TestCase
{
    use DatabaseTransactions;

    public function testDelete()
    {
        /** @var CategoryOperation $categoryOperation */
        $categoryOperation = resolve(CategoryOperation::class);
        $category = new Category();

        $this->assertTrue($categoryOperation->delete($category,1));
    }
}
