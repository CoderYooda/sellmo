<?php

namespace Tests\Unit\Operations;

use App\Exceptions\Operations\Category\CategoryNotFoundException;
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

        $this->assertThrows(function() use ($categoryOperation) {
            $categoryOperation->delete(21,1);
        }, CategoryNotFoundException::class);

    }
}
