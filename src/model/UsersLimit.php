<?php
namespace Tmakinde\ExpenseTracker\Model;

use Illuminate\Database\Eloquent\Model;

class UsersLimits extends Model
{
    protected $guarded = ['id'];

    protected $table = 'users_limits';
}
