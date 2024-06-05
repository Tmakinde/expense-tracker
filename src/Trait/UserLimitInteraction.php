<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Model\UsersLimits;

trait UserLimitInteraction
{
    public function createLimit(string $limitType, float $amount, Category $category)
    {
        return UsersLimits::create([
            'user_type' => (new \Reflection(static::class))->getNamespaceName(),
            'user_id' => $this->id,
            'category_id' => $category->id,
            'limit_type' => $limitType,
            'amount' => $amount,
            'currency' => data_get(app()->configPath('expense_tracker_config'), 'currency')
        ]);
    }

}
