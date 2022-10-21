<?php
namespace src\ValidRules;

use src\interfaces\ValidationRuleInterface;

class ValidateEmail implements ValidationRuleInterface
{
    public function ValidationRule( $value )
    {
        if ( !filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
            return false;
        }

        return true;
    }

    public function getErrorMessage()
    {
        return 'email không hợp lệ';
    }
}