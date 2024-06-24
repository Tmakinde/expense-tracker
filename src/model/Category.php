<?php

namespace Tmakinde\ExpenseTracker\Model;
use Tmakinde\ExpenseTracker\Model\Expense;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tmakinde\ExpenseTracker\Trait\CategoryLimitInteraction;
use Tmakinde\ExpenseTracker\Enum\CategoryStatus;

class Category extends Model
{
    use CategoryLimitInteraction;

    protected $guarded = ['id'];

    public function expenses() : BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getCategoryStatus()
        );
    }

    protected function getCategoryStatus()
    {
        $totalExpenses = Expense::where('category_id', $this->id)->where('user_id', $this->user->id)->sum('amount');
        $categoryLimit = $this->getUserCategoryLimit()->amount;
        if ($totalExpenses == $categoryLimit) {
            return CategoryStatus::BALANCED;
        }
        return $totalExpenses > $categoryLimit ? CategoryStatus::EXCEEDED : CategoryStatus::NOT_EXCEEDED;
    }

    protected function getUserCategoryLimit() : UsersLimits
    {
        return UsersLimits::where('user_id', $this->user_id)->where('category_id', $this->id)->first();
    }

}
