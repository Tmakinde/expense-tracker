<?php

namespace Tmakinde\ExpenseTracker\Tests\Unit;

use Tmakinde\ExpenseTracker\Tests\AppTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tmakinde\ExpenseTracker\Enum\CategoryStatus;
use Tmakinde\ExpenseTracker\Enum\LimitType;
use Tmakinde\ExpenseTracker\Exceptions\InvalidModelException;
use Tmakinde\ExpenseTracker\Tests\Model\User;
use Tmakinde\ExpenseTracker\Facade\CategoryRequest;
use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Model\UsersLimits;

class CategoriesTestCase extends AppTestCase
{
    //  any records added to the database by test cases that do not use this trait may still exist in the database
    use RefreshDatabase;

    protected $testUser;

    public function setUp() : void
    {
        parent::setUp();
        $this->testUser = User::first();
    }

    public function testItFetchAllUserCategories() : void
    {
        $categories = CategoryRequest::for($this->testUser)->get();
        $this->assertTrue($categories->contains('id', $this->testUser->id));
    }

    public function testItFetchesActiveCategories() : void
    {
        $categories = Category::active()->get();
        $this->assertTrue($categories->contains('is_active', 1));
    }

    public function testItFetchesInactiveCategories() : void
    {
        $categories = Category::inactive()->get();
        $this->assertTrue($categories->contains('is_active', 0));
    }

    public function testItUserCanCreateCategoryLimit() : void
    {
        $userLimit = $this->testUser->createCategoryLimit(LimitType::YEARLY, '10000', function(Category $category) {
            return $category->where('is_active', 1)->first();
        });

        $this->assertInstanceOf(UsersLimits::class, $userLimit);
    }

    public function testThatCategoryCanCreateLimit() : void
    {
        $category = Category::first();
        $categoryLimit = $category->createLimit(LimitType::DAILY, '10000')->for($this->testUser);
        $this->assertInstanceOf(UsersLimits::class, $categoryLimit);    
    }

    public function testItCanReturnInvalidModelException() : void
    {
        $this->expectException(InvalidModelException::class);
        $category = Category::first();
        $category->for($this->testUser);
    }

    public function testItCanMarkCategoryAsInactive() : void
    {
        $category = Category::first();
        Category::markAsInactive($category->id);
        $category = Category::find($category->id);
        $this->assertEquals(0, $category->is_active);
    }

    public function testItCanMarkCategoryAsActive() : void
    {
        $category = Category::first();
        Category::markAsActive($category->id);
        $category = Category::find($category->id);
        $this->assertEquals(1, $category->is_active);
    }

    public function testItCanReturnCategoryStatusExceeded() : void
    {
        $category = Category::first();
        $category->createLimit(LimitType::DAILY, '10000')->for($this->testUser);
        $category->expenses()->create([
            'amount' => 20000,
            'user_id' => $this->testUser->id,
            'user_type' => (new \ReflectionClass($this->testUser))->getName(),
            'category_id' => $category->id,
            'currency' => 'NGN'
        ]);
        $this->assertEquals(CategoryStatus::EXCEEDED, $category->getCategoryStatus($this->testUser));
    }

    public function testItCanReturnCategoryStatusNoLimit() : void
    {
        $category = Category::first();
        $this->assertEquals(CategoryStatus::NO_LIMIT, $category->getCategoryStatus($this->testUser));
    }

}
