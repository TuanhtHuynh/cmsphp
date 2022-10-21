<?php
namespace src;

class Template
{
    protected $layout;

    public function __construct( $layout )
    {
        $this->layout = $layout;
    }

    public function view( $view, $variables )
    {
        extract( $variables );
        include VIEW_PATH . $this->layout . '.html';
    }
}