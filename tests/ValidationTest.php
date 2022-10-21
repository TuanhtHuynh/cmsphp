<?php
declare ( strict_types = 1 );
use PHPUnit\Framework\TestCase;

require_once 'src/interfaces/ValidationRuleInterface.php';
require_once 'src/Validation.php';
require_once 'src/ValidRules/ValidateEmail.php';

final class ValidationTest extends TestCase
{
    public function testValidationEmail(): void
    {
        $validationClass = new Validation();
        $validationClass->addRule( new ValidateEmail() );

        // $this->assertTrue( $validationClass->validation( 'test@' ) );
        $this->assertTrue( $validationClass->validation( 'test@gmail.com' ) );
    }
}