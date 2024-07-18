<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Closure;
use Tmakinde\ExpenseTracker\Exceptions\InvalidTypeException;
use Tmakinde\ExpenseTracker\Model\Category;
use Tmakinde\ExpenseTracker\Model\UsersLimits;
use Tmakinde\ExpenseTracker\Utils\Utils;

trait UserLimitInteraction
{
    public function createCategoryLimit(string $limitType, float $amount, Closure $callback)
    {
        $category = $callback((new Category()));

        if (!Utils::validateEnumType($limitType)) {
            throw InvalidTypeException::LogError('Invalid limit type');
        }

        return UsersLimits::create([
            'user_type' => (new \ReflectionClass(static::class))->getName(),
            'user_id' => $this->id,
            'category_id' => $category->id,
            'limit_type' => $limitType,
            'amount' => $amount,
            'currency' => data_get(app()->configPath('expense_tracker_config'), 'currency', 'NGN')
        ]);
    }

}
