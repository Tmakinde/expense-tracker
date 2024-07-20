<?php
namespace Tmakinde\ExpenseTracker\Tests\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tmakinde\ExpenseTracker\Trait\UserCategoryInteraction;
use Tmakinde\ExpenseTracker\Trait\UserLimitInteraction;

class User extends Model
{
    protected $guarded = ['id'];
    use UserLimitInteraction, UserCategoryInteraction;
}
