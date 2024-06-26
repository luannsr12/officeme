<?php
namespace OfficeMe\Controllers\Pages;

use OfficeMe\Model\UserModel;
use OfficeMe\Model\OptionsModel;
use OfficeMe\Controllers\Api\StatisticsController;

class Dashboard
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function index() {

        $page = (is_admin() ? 'admin' : 'user') . '.dashboard'; 

        return UserModel::isLogged() ? view($page, [
            'pagename' => 'dashboard'
            ]) : view('login');
    }

    public static function logout() {

        if(isset($_SESSION['uid'], $_SESSION['logged'], $_SESSION['CSRF_TOKEN'])){
            if(UserModel::setToken('', $_SESSION['uid'])){
                session_destroy();
            }
        }
            
       redirect(APP_URL . '/login' );
        
    }
 
}