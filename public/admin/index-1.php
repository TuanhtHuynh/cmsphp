<?php
// ob_start();

use modules\user\models\User;
use src\Auth;
use src\DbConnection;

session_start();
define( 'ROOT_PATH', dirname( __FILE__ ) . '/../../' );
define( 'VIEW_PATH', ROOT_PATH . 'view/' );
define( 'MODULE_PATH', ROOT_PATH . '/modules/' );

define( 'SALT', 'dwtn3244<mmgesui12' );

require_once ROOT_PATH . 'src/template.php';
require_once ROOT_PATH . 'src/DbConnection.php';
require_once ROOT_PATH . 'src/Entity.php';
require_once ROOT_PATH . 'src/Controller.php';
require_once ROOT_PATH . 'src/Auth.php';
require_once MODULE_PATH . 'page/models/Page.php';
require_once MODULE_PATH . 'user/models/User.php';

DbConnection::connect( 'localhost', 'maruphp_db', 'root', 'zxcvbn' );

$dbh = DbConnection::getInstance();
$dbc = $dbh->getConnection();

$user = new User( $dbc );
$user->findBy( 'username', 'admin' );

$auth = new Auth();
$user = $auth->changePassword( $user, '123456.' );
echo '<pre>';
var_dump( $user );