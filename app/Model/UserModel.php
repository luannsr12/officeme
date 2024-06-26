<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;

 final class UserModel extends Model
 {
    protected $table = 'user';

    protected $primaryKey = 'id';

    public static function getById(string $userUuid) {
        return UserModel::where('id', $userUuid)->first();
    }

    public static function getByToken(string $token) {
        return UserModel::where('csrf_token', $token)->first();
    }

    public static function getByUsername(string $username){
        return UserModel::where('username','=', $username)->first();
    }

    public static function setToken(string $token, int $uid){
         return UserModel::where('id', $uid)->update(['csrf_token' => $token]);
    }

    public static function isLogged(){
        $csrf_token = csrf_token();
        $user = UserModel::where('csrf_token', $csrf_token)->first();
        return $user ? true : false;
    }

    public static function editPassword(string $password, int $uid){
        $newPass = password_hash($password, PASSWORD_DEFAULT);
        return UserModel::where('id', $uid)->update(['password' => $newPass]);
    }
 
    public static function editUsername(string $username, int $uid){
        return UserModel::where('id', $uid)->update(['username' => $username]);
    }

 }
 