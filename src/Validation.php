<?php
namespace src;

use src\interfaces\ValidationRuleInterface;

class Validation
{
    private $rules;
    private $errorMessages = [];

    public function __construct()
    {

    }

    public function addRule( ValidationRuleInterface $rule )
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function validation( $value )
    {
        foreach ( $this->rules as $rule ) {
            $ruleValid = $rule->ValidationRule( $value );
            if ( !$ruleValid ) {
                $this->errorMessages[] = $rule->getErrorMessage();
                return false;
            }
        }

        return true;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}