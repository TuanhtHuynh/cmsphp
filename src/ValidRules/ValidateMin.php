<?php
namespace src\ValidRules;

use src\interfaces\ValidationRuleInterface;

class ValidateMin implements ValidationRuleInterface
{
    private $min;

    public function __construct( $min )
    {
        $this->min = $min;
    }

    public function ValidationRule( $value )
    {
        if ( strlen( $value ) < $this->min ) {
            return false;
        }
        return true;
    }

    public function getErrorMessage()
    {
        return 'ít nhất ' . $this->min . ' kí tự';
    }

    // public function getErrorMessage()
    // {
    // }
}