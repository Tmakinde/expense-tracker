<?php

namespace Tmakinde\ExpenseTracker\Model;

use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Contract\ExpenseInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model implements ExpenseInterface
{
    protected $guarded = ['id'];

    public function category() : HasMany
    {
        return $this->hasMany(Expense::class);
    }

}
