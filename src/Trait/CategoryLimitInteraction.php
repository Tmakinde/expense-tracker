<?php
namespace Tmakinde\ExpenseTracker\Trait;

use Illuminate\Database\Eloquent\Model;
use Tmakinde\ExpenseTracker\Enum\LimitType;
use Tmakinde\ExpenseTracker\Exceptions\InvalidModelException;
use Tmakinde\ExpenseTracker\Exceptions\InvalidTypeException;
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
            throw InvalidModelException::LogError('Set user id for limit');
        }

        if ($this->validateEnumType($limitType)) {
            throw InvalidTypeException::LogError('Invalid limit type');
        }

        $this->resolveUserLimit();

        try {
            $this->userLimit->limit_type = $limitType;
            $this->userLimit->amount = $amount;
            $this->userLimit->currency = data_get(app()->configPath('expense_tracker_config'), 'currency');
        } catch (\Throwable $ex) {
            throw InvalidModelException::LogError($ex->getMessage());
        }
        return $this;
    }

    public function for(Model $user) : self
    {
        $this->userLimit->user_type = (new \ReflectionClass($user))->getNamespaceName();
        $this->userLimit->user_id = $user->id;
        $this->save();
        return $this;
    }

}
