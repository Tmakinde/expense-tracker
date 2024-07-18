<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Model\Expense;
use Tmakinde\ExpenseTracker\Model\UsersLimits;

trait UserExpenseInteraction
{
    public function createExpense(float $amount, Category $category)
    {
        return Expense::create([
            'user_type' => (new \Reflection(static::class))->getNamespaceName(),
            'user_id' => $this->id,
            'category_id' => $category->id,
            'amount' => $amount,
            'currency' => data_get(app()->configPath('expense_tracker_config'), 'currency')
        ]);
    }

}
