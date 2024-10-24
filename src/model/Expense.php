<?php

namespace Tmakinde\ExpenseTracker\Model;

use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Expense extends Model implements ExpenseInterface
{
    protected $guarded = ['id'];

    public function categories() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
