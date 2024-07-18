<?php
namespace Tmakinde\ExpenseTracker\Utils;

use Tmakinde\ExpenseTracker\Enum\LimitType;

abstract class Utils {
    public static function validateEnumType(string $limitType) : bool
    {
        $enum = LimitType::getAllTypes();
        return in_array($limitType, $enum) ? true : false;
    }

}
