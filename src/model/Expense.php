<?php

namespace Tmakinde\ExpenseTracker\Model;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model {

    public function category() {
        return $this->hasMany(Expense::class);
    }

}
