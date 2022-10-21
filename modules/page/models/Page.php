<?php
namespace modules\page\models;

use src\Entity;

class Page extends Entity
{
    public function __construct( $dbc )
    {
        parent::__construct( $dbc, 'pages' );
    }
    
    protected function initValue()
    {
        $this->fields = [
            'title', 'content',
        ];
    }

}