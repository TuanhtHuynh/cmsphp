<?php
namespace src;

use modules\user\models\User;

class Auth
{
    public function checkLogin( $username, $password )
    {
        $dbh = DbConnection::getInstance();
        $dbc = $dbh->getconnection();

        $user = new User( $dbc );
        $user->findBy( 'username', $username );
        if ( property_exists( $user, 'id' ) ) {
            if ( password_verify( $password, $user->password ) ) {
                return true;
            }
        }
    }

    public function changePassword( $userData, $newPassword )
    {
        $userData->password = password_hash( $newPassword, PASSWORD_DEFAULT );
        return $userData;
    }
}