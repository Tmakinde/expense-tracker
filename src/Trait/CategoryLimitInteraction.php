<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Enum\LimitType;
use Tmakinde\ExpenseTracker\Model\UsersLimits;

trait CategoryLimitInteraction
{
    protected $userLimit;

    private function resolveUserLimit() : self
    {
        $this->userLimit = new UsersLimits;
        $this->userLimit->category_id = $this->id;
        return $this;
    }

    private function validateEnumType(string $limitType) : bool
    {
        $enum = LimitType::getAllTypes();
        return !in_array($limitType, $enum) ? false : true;
    }

    public function createLimit(string $limitType, float $amount) : UsersLimits
    {
        if (!isset($this->userLimit->user_id)) {
            throw new Exception('Set user id for limit');
        }

        if ($this->validateEnumType($limitType)) {
            throw new Exception('Invalid limit type');
        }

        $this->userLimit->limit_type = $limitType;
        $this->userLimit->amount = $amount;
        $this->userLimit->currency = data_get(app()->configPath('expense_tracker_config'), 'currency');
        $this->save();
        return $this->userLimit;
    }

    public function for(Model $user) : self
    {
        $this->resolveUserLimit();
        $this->userLimit->user_type = (new \Reflection($user))->getNamespaceName();
        $this->userLimit->user_id = $user->id;
        return $this;
    }

}
