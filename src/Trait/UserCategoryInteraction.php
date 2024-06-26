<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Tmakinde\ExpenseTracker\Model\Category;

trait UserCategoryInteraction
{
    public function categories() : MorphToMany
    {
        return $this->morphToMany(Category::class, 'users_categories', 'users_limits', 'user_id', 'category_id')
            ->withPivot('limit_type', 'amount', 'currency')
            ->withTimestamps();
    }
}
