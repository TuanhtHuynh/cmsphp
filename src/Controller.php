<?php
namespace src;

class Controller
{
    public $template;
    public $dbc;
    public $log;

    public function run( $action )
    {
        if ( method_exists( $this, 'runBefore' ) ) {
            $result = $this->{'runBefore'}();
            if ( $result == false ) {
                return;
            }
        }

        $action .= 'Act';
        if ( method_exists( $this, $action ) ) {
            $this->$action();
        }
    }
}