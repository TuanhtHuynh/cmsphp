<?php
namespace src\interfaces;

interface ValidationRuleInterface
{
    public function ValidationRule( $value );
    public function getErrorMessage();
}