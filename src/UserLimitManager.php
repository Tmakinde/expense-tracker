<?php

namespace Tmakinde\ExpenseTracker;

use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Model\UsersLimits;

class UserLimitManager {

    protected $userLimit;

    public function __construct(UsersLimits $usersLimits)
    {
        $this->userLimit = $usersLimits;
    }

    public function for(Model $user) : UsersLimits
    {
        try {
            $this->userLimit->user_id = $user->id;
            $this->save();
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $this->userLimit;
    }
}
