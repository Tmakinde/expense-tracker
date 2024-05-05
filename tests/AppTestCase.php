<?php
namespace Tmakinde\ExpenseTracker\Tests;

use CreateCategoriesTable;
use CreateExpensesTable;
use Tmakinde\ExpenseTracker\Tests\Database\Migrations\CreateUsersTestTable;
use Tmakinde\ExpenseTracker\Model\Expense;
use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Tests\Model\User;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Illuminate\Contracts\Config\Repository;


class AppTestCase extends TestbenchTestCase
{
    protected function setUp() : void
    {
        parent::setUp();
        self::runMigrationsUp('up');
        $this->executeFixtures();
        $user = User::first();
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass() : void
    {
        parent::tearDownAfterClass();
        self::runMigrationsUp('down');
    }

    public static function runMigrationsUp($switch) : void
    {
        require_once dirname(__DIR__) . '/database/migrations/create_categories_table.php';
        require_once dirname(__DIR__) . '/database/migrations/create_expenses_table.php';
        require_once __DIR__ . '/database/migrations/create_users_test_table.php';
        if ($switch == 'up') {
            (new CreateUsersTestTable())->up();
            (new CreateExpensesTable)->up();
            (new CreateCategoriesTable)->up();
        } else {
            (new CreateUsersTestTable)->down();
            (new CreateExpensesTable)->down();
            (new CreateCategoriesTable)->down();
        }
        return;
    }

    protected function executeFixtures()
    {
        User::create($this->getUsersFixtureData());
        Category::create($this->getCategoriesFixtureData());
        foreach ($this->getExpensesFixtureData() as $expense) {
            Expense::create($expense);
        }
    }

    protected function getCategoriesFixtureData()
    {
        return [
                'id' => fake()->randomNumber(1),
                'name' => fake()->word,
                'is_active' => 1
            ];
    }

    protected function getExpensesFixtureData()
    {
        $expenses = [];
        $categories = Category::all();
        $user = User::first();
        foreach ($categories as $category) {
            $time = fake()->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null);
            $expenses[] = [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'amount' => fake()->randomNumber(4),
                'currency' => fake()->currencyCode,
                'created_at' => $time,
                'updated_at' => $time
            ];
        }
        return $expenses;
    }

    protected function getUsersFixtureData()
    {
        return
            [
                'id' => fake()->randomNumber(1),
                'name' => fake()->userName
            ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app->make('config'), function (Repository $config) {
            $config->set('database.default', 'testbench');
            $config->set('database.connections.testbench', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        });
    }
}
