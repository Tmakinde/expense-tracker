<?php

namespace Tmakinde\ExpenseTracker\Model;
use Tmakinde\ExpenseTracker\Model\Expense;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Trait\CategoryLimitInteraction;
use Tmakinde\ExpenseTracker\Enum\CategoryStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use CategoryLimitInteraction;

    protected $fillable = ['name', 'is_active',];

    protected $guarded = ['id'];

    public function expenses() : HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function limit() : HasOne
    {
        return $this->hasOne(UsersLimits::class);
    }

    public function getCategoryStatus(Model $user)
    {
        $totalExpenses = Expense::where('category_id', $this->id)->where('user_id', $user->id)->where('user_type', (new \ReflectionClass($user))->getName())->sum('amount');
        $categoryLimit = $this->getUserCategoryLimit($user)?->amount;
        if (is_null($categoryLimit)) {
            return CategoryStatus::NO_LIMIT;
        }
        if ($totalExpenses == $categoryLimit) {
            return CategoryStatus::BALANCED;
        }
        return $totalExpenses > $categoryLimit ? CategoryStatus::EXCEEDED : CategoryStatus::NOT_EXCEEDED;
    }

    protected function getUserCategoryLimit(Model $user) : ?UsersLimits
    {
        return UsersLimits::where('user_id', $user->id)->where('user_type', (new \ReflectionClass($user))->getName())->where('category_id', $this->id)->first();
    }

    public function scopeMarkAsInactive(Builder $query, $categoryId)
    {
        return $query->where('id', $categoryId)->update(['is_active' => 0]);
    }

    public function scopeMarkAsActive(Builder $query, $categoryId)
    {
        return $query->where('id', $categoryId)->update(['is_active' => 1]);
    }

    public function scopeInActive(Builder $query)
    {
        return $query->where('is_active', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

}
