<?php
namespace modules\user\models;

use src\Entity;

class User extends Entity
{
    public function __construct( $dbc )
    {
        parent::__construct( $dbc, 'users' );
    }

    protected function initValue()
    {
        $this->fields = [
            'id',
            'name',
            'username',
            'password',
            'password_hash'];
    }
}