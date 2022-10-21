<?php

use modules\page\controllers\HomeController;
use src\DbConnection;
use src\Template;

session_start();
define( 'ROOT_PATH', dirname( __FILE__ ) . '/../' );
define( 'VIEW_PATH', ROOT_PATH . 'view/' );
define( 'MODULE_PATH', ROOT_PATH . '/modules/' );

spl_autoload_register( function ( $class ) {
    $file = ROOT_PATH . str_replace( '\\', '/', $class ) . '.php';
    if ( file_exists( $file ) ) {
        require $file;
    }
} );

DbConnection::connect( 'localhost', 'maruphp_db', 'root', 'zxcvbn' );

$url = $_GET['module'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

// can replace dashboard with home to redirect to home page
// if ( $url == 'dashboard' ) {
//     $dashboardController = new DashboardController();
//     $dashboardController->template = new Template( 'layout/default' );
//     $dashboardController->run( $action );
// }
if ( $url == 'home' ) {
    $homeController = new HomeController();
    $homeController->template = new Template( 'layout/default' );
    $homeController->run( $action );
}
// admin/index.php?module=dashboard&action=login