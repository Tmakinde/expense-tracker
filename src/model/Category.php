<?php

namespace Tmakinde\ExpenseTracker\Model;
use Tmakinde\ExpenseTracker\Model\Expense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tmakinde\ExpenseTracker\Trait\CategoryLimitInteraction;

class Category extends Model
{
    use CategoryLimitInteraction;

    protected $guarded = ['id'];

    public function expenses() : BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

}
