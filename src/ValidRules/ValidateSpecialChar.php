<?php
namespace src\ValidRules;

use src\interfaces\ValidationRuleInterface;

class ValidateSpecialChar implements ValidationRuleInterface
{
    public function ValidationRule( $value )
    {
        if ( !preg_match( '/[^a-zA-Z0-9]+/', $value ) ) {
            return false;
        }
        return true;
    }

    public function getErrorMessage()
    {
        return 'chứa ít nhất 1 kí tự đặc biệt';
    }
}