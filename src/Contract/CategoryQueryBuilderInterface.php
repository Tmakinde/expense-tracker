<?php
namespace Tmakinde\ExpenseTracker\Contract;

use Illuminate\Database\Eloquent\Collection;
use Tmakinde\ExpenseTracker\Model\Category;

interface CategoryQueryBuilderInterface {

    public function create(array $data) : Category;

    public function get() : Collection;
}
