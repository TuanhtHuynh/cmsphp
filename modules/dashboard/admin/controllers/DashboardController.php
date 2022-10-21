<?php
namespace modules\dashboard\admin\controllers;

use src\Auth;
use src\Controller;
use src\Validation;
use src\ValidRules\ValidateEmail;
use src\ValidRules\ValidateMin as ValidRulesValidateMin;
use src\ValidRules\ValidateSpecialChar;

class DashboardController extends Controller
{
    public function runBefore()
    {
        if ( $_SESSION['is_admin'] ?? false == true ) {
            return true;
        }
        $action = $_GET['action'] ?? $_POST['action'] ?? 'default';

        if ( $action != 'login' ) {
            header( 'Location: /admin/index.php?module=dashboard&action=login' );
        }
        return true;
    }

    public function defaultAct()
    {
        $variables = [];
        header( 'Location: /admin/index.php?module=page' );
        exit();
    }

    public function loginAct()
    {
        if ( $_POST['postAct'] ?? 0 == 1 ) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $valid = new Validation();
            if ( !$valid
                ->addRule( new ValidRulesValidateMin( 6 ) )
                ->addRule( new ValidateSpecialChar() )
                ->validation( $password ) ) {
                $_SESSION['validationRules']['errors'] = $valid->getErrorMessages();
            }

            if ( !$valid
                ->addRule( new ValidRulesValidateMin( 3 ) )
                ->addRule( new ValidateEmail() )
                ->validation( $username ) ) {
                $_SESSION['validationRules']['errors'] =
                $valid->getErrorMessages();
            }

            if ( $_SESSION['validationRules']['error'] ?? '' == '' ) {
                $auth = new Auth();
                if ( $auth->checkLogin( $username, $password ) ) {
                    $_SESSION['is_admin'] = 1;
                    header( 'Location: /admin/' );
                    exit();
                }
                $_SESSION['validationRules']['errors'] =
                $valid->getErrorMessages();

            }
        }

        include VIEW_PATH . 'admin/login.html';
        unset( $_SESSION['validationRules']['error'] );
    }
}