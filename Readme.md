# Tools for managing users expenses

The package `Tmakinde/expensetracker` for anyone building a banking/fintech application in Laravel to be able to seamlessly integrate an expense manager feature into their application. it allows easy management of users expenses based on categories and also provides a way to track expenses based on categories and time periods.

## Features
Key packages features include:
- Ability to create different categories for users selection. Categories could be:
    - Food
    - Transportation
    - Rent
    - Entertainment
    - Health
    - Education
    - Shopping
    - Others
- Ability for users to add expenses to their selected category.
- Statistics
    - Ability to view all expenses within a particular category for a particular period of time
    - Ability to even see all expenses within a particular period of time but grouped by category
- Define limits for a category for a particular time period so as to know when the expense has been exceeded for that time period
    - daily limit
    - weekly limit
    - monthly limit
    - yearly limit

## Requirements
- PHP 8 or higher
- Laravel 8 or higher

## Installation
You can install the package via composer:

```bash
composer require tmakinde/expense-tracker
```

## Configuration
Publish the configuration file using the following command:

Migration:

```bash
php artisan vendor:publish --provider="Tmakinde\ExpenseTracker\ExpenseServiceProvider --tag="expenses-migrations"
```

Config:

```bash
php artisan vendor:publish --provider="Tmakinde\ExpenseTracker\ExpenseServiceProvider --tag="expenses-config"
```

Execute migration
```bash
php artisan migrate --path=/database/migrations/expenses
```
## Usage

### Users
Users are the actual users that can add expenses to their expense list.

To be able to use certain methods in the users model, you need to add trait `UserLimitInteraction`, `UserCategoryInteraction`  to the user model.

```php
use Tmakinde\ExpenseTracker\Trait\UserCategoryInteraction;
use Tmakinde\ExpenseTracker\Trait\UserLimitInteraction;

class User extends Model
{
    use UserLimitInteraction, UserCategoryInteraction;
}
```

### Category
Category are the different types of expenses that a user can add to their expense list. You can create a category using the following command:

```php
use Tmakinde\Expensetracker\Model\Category;
Category::create([
    'name' => 'Food'
]);
```
This will create a category with the name `Food` and set field `is_active` to `true` by default.

#### Mark category as inactive
```php
use Tmakinde\Expensetracker\Model\Category;
Category::markAsInactive($categoryId);
```

#### Mark category as active
```php
use Tmakinde\Expensetracker\Model\Category;
Category::markAsActive($categoryId);
```

`Use category facade to access the below methods`

####
```php
use Tmakinde\ExpenseTracker\Facade\CategoryRequest;

// fetch categories of a user
CategoryRequest::for($user)->get();

// fetch categories of a user based on limit type
CategoryRequest::for($user)->whereLimitType('daily')->get();

// fetch categories of a user based on limit amount
CategoryRequest::for($user)->whereLimitAmountBetween(1000, 3000)->get();

// fetch categories of a user based on limit type and limit amount
CategoryRequest::for($user)->whereLimitType('daily')->whereLimitAmountBetween(1000, 3000)->get();
```

### Expenses
Expenses are the actual expenses that a user can add to their expense list. You can create an expense using the following command:

```php
use Tmakinde\Expensetracker\Model\Expense;
Expense::create([
    'user_id' => 1,
    'user_type' => 'App\Models\User',
    'category_id' => 1,
    'currency' => 'NGN',
    'amount' => 1000,
]);
```

Note: `user_type` is the model of the user, which means it can serve as a polymorphic relationship.

Fetch all user expenses
    
```php
use Tmakinde\ExpenseTracker\Facade\ExpenseRequest;
ExpenseRequest::for($user)->get();
```

Fetch all user expenses for a category
        
```php
use Tmakinde\ExpenseTracker\Facade\ExpenseRequest;
ExpenseRequest::for($user)->whereCategory($categoryId)->get();
```
Fetch all user expenses for a category within a time period
        
```php
use Tmakinde\ExpenseTracker\Facade\ExpenseRequest;
ExpenseRequest::for($user)->whereCategory($categoryId)->whereDateBetween('2022-01-01', '2022-01-31')->get();
```
Fetch all user expenses within a time period
        
```php
use Tmakinde\ExpenseTracker\Facade\ExpenseRequest;
ExpenseRequest::for($user)->whereDateBetween('2022-01-01', '2022-01-31')->get();
```
Fetch user expenses and group by category
        
```php
use Tmakinde\ExpenseTracker\Facade\ExpenseRequest;
ExpenseRequest::for($user)->groupByCategory()->get();
```

### Limit
Limits are the maximum amount of expenses that a user can spend on a category for a particular time period. You can create a limit using the following command:

```php
// create limit for a user category
use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Enum\LimitType;

$category = Category::find(1);
$category->createLimit(LimitType::Daily, 500)->for($user)

// create limit using the user model

$categoryCallback = function(Category $category) {
    return $category->where('is_active', 1)->first();
}
auth()->user()->createCategoryLimit(LimitType::Daily, 1000, $categoryCallback)
```

where `$limitType` can be `daily`, `weekly`, `monthly`, `yearly`

### Config changes
- You can change the default currency in the config file

## Testing
Run the tests with:

```bash
vendor/bin/phpunit
```
