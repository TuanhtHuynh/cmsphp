<?php
namespace modules\page\controllers;

use modules\page\models\Page;
use src\Controller;
use src\DbConnection;

class HomeController extends Controller
{
    public function defaultAct()
    {
        $dbh = DbConnection::getInstance();
        $dbc = $dbh->getConnection();

        $page = new Page( $dbc );
        $page->findBy( 'id', 1 );
        $variables['page'] = $page;

        $this->template->view( 'page/views/home-page', $variables );
    }
}