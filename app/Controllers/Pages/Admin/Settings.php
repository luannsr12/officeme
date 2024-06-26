<?php
namespace OfficeMe\Controllers\Pages\Admin;

use OfficeMe\Model\UserModel;

class Settings
{

    public function __construct(){
        if(!UserModel::isLogged()){
            redirect(APP_URL . '/login' );
        } 
    }

    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function profile() {
   
        $csrf_token = csrf_token();

        $user_details = UserModel::getByToken($csrf_token);

        if($user_details){
            
            return view('settings_profile', [
                'user'     => $user_details,
                'pagename' => 'settings_profile'
            ]);


        }else{
            redirect(APP_URL . '/login' );
        }

    }

}