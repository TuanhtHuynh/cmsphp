<?php
namespace modules\page\admin\controllers;

use modules\page\models\Page;
use src\Controller;

class PageController extends Controller
{
    public function runBefore()
    {
        if ( $_SESSION['is_admin'] ?? false == true ) {
            return true;
        }
        $action = $_GET['action'] ?? $_POST['action'] ?? 'default';
        if ( $action != 'login' ) {
            header( 'Location: /admin/index.php?module=dashboard&action=login' );
        } else {
            return true;
        }
    }

    public function defaultAct()
    {
        $variables = [];

        $page = new Page( $this->dbc );
        $pages = $page->findAll();
        $variables['pages'] = $pages;

        $this->template->view( 'page/admin/views/page-list', $variables );
    }

    public function editPageAct()
    {
        $pageID = $_GET['id'];
        $variables = [];

        $page = new Page( $this->dbc );
        $page->findBy( 'id', $pageID );

        if ( $_POST['action'] ?? false ) {
            $page->setValues( $_POST );
            var_dump( $page );
            $page->save();
        }

        // create a log channeld
        $this->log->warning( 'Admin has changed the page id:' . $pageID );

        $variables['page'] = $page;
        $this->template->view( 'page/admin/views/page-edit', $variables );
    }
}