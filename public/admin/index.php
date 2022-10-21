<?php
session_start();

use modules\dashboard\admin\controllers\DashboardController;
use modules\page\admin\controllers\PageController;
use src\DbConnection;
use src\Template;

define( 'ROOT_PATH', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR );
define( 'VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR );
define( 'MODULE_PATH', ROOT_PATH . '/modules/' );

define( 'SALT', 'dwtn3244<mmgesui12' );

spl_autoload_register( function ( $class ) {
    $file = ROOT_PATH . str_replace( '\\', '/', $class ) . '.php';
    if ( file_exists( $file ) ) {
        require $file;
    }
} );

require '../../vendor/autoload.php';

DbConnection::connect( 'localhost', 'maruphp_db', 'root', 'zxcvbn' );

$url = $_GET['module'] ?? 'dashboard';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

$dbh = DbConnection::getInstance();
$dbc = $dbh->getConnection();
if ( $url == 'dashboard' ) {
    $dashboardController = new DashboardController();
    $dashboardController->template = new Template( 'admin/layout/default' );
    $dashboardController->run( $action );
}
if ( $url == 'page' ) {
    // create a log channel
    // $log = new Logger( 'name' );
    // $log->pushHandler( new StreamHandler( 'pages.log', Logger::WARNING ) );

    $pageController = new PageController();
    $pageController->template = new Template( 'admin/layout/default' );
    $pageController->dbc = $dbc;
    // $pageController->log = $log;
    $pageController->run( $action );
}