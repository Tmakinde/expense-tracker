<?php
namespace Tmakinde\ExpenseTracker\Tests\Unit;

use DateTime;
use Tmakinde\ExpenseTracker\Tests\AppTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tmakinde\ExpenseTracker\Facade\ExpenseRequest;
use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Tests\Model\User;

use function PHPUnit\Framework\assertTrue;

class ExpensesTestCase extends AppTestCase
{
    //  any records added to the database by test cases that do not use this trait may still exist in the database
    use RefreshDatabase;

    protected $testUser;

    public function setUp() : void
    {
        parent::setUp();
        $this->testUser = User::first();
    }

    public function testItFetchAllUserExpenses() : void
    {
        $expense = ExpenseRequest::for($this->testUser)->get();
        $this->assertTrue($expense->contains('id', $this->testUser->id));
    }

    public function testItFetchesUserExpensesWithinADateRange() : void
    {
        $from = (new Datetime)->setTimestamp(now()->setYear(now()->year - 2)->timestamp);
        $to = (new Datetime)->setTimestamp(now()->timestamp);
        $expense = ExpenseRequest::for($this->testUser)->between($from, $to)->get();
        $this->assertNotEmpty($expense->whereBetween('created_at', [$from, $to]));
    }

    public function testItFetchesUserExpensesByCategory() : void
    {
        $category = Category::first();
        $expense = ExpenseRequest::for($this->testUser)->whereCategory($category)->get();
        $this->assertTrue($expense->contains('category_id', $category->id));
    }

    public function testItFetchesUserExpensesGroupedByCategory() : void
    {
        $expense = ExpenseRequest::for($this->testUser)->groupByCategory();
        $this->assertNotEmpty($expense);
    }
}
