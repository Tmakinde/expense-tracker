<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Model\UsersLimits;
use Tmakinde\ExpenseTracker\UserLimitManager;

trait InteractsWithUserLimit
{
    protected $userLimit;

    private function resolveUserLimit() : self
    {
        $this->userLimit = new UsersLimits;
        $this->userLimit->category_id = $this->id;
        return $this;
    }

    public function createLimit(string $limitType, float $amount) : UserLimitManager
    {
        tap($this, function($this) use($limitType, $amount) {
            $this->userLimit = $this->resolveUserLimit()->limit_type = $limitType;
            $this->userLimit = $this->resolveUserLimit()->amount = $amount;
        });
        return  (new UserLimitManager($this->userLimit));
    }

}
