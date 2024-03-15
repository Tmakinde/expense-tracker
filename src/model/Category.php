<?php

namespace Tmakinde\ExpenseTracker\Model;
use Tmakinde\ExpenseTracker\Model\Expense;

use Illuminate\Database\Eloquent\Model;
class Category extends Model {

    public function expenses() {
        return $this->belongsTo(Expense::class);
    }
}