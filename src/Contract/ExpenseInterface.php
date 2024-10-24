<?php
namespace Tmakinde\ExpenseTracker\Contract;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface ExpenseInterface {
    public function categories() : BelongsTo;
}
