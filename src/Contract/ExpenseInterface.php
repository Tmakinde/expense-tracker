<?php
namespace Tmakinde\ExpenseTracker\Contract;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface ExpenseInterface {
    public function category() : HasMany;
}
