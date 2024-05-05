<?php
namespace Tmakinde\ExpenseTracker\Tests\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $guarded = ['id'];
}
