<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 
 final class PlataformsModel extends Model
 {
    protected $table = 'plataforms';

    protected $primaryKey = 'id';

    public static function getById(string $bid) {
        return PlataformsModel::where(['id' => $bid])->first();
    }

    public static function getByIdTelegram(string $bid) {
        return PlataformsModel::where(['bot_id' => $bid])->first();
    }


    public static function getByUsername(string $username) {
        return PlataformsModel::where(['username' => $username])->first();
    }

    public static function getByKey(string $apikey) {
        return PlataformsModel::where(['apikey' => $apikey])->first();
    }

    
    public static function getAll() {
        $groups = PlataformsModel::all();
        return $groups;
    }

    public static function remove(int $id){
        $option = PlataformsModel::find($id);
        return $option->delete();
    }

    public static function add(object $data) {
        
        $bots = new PlataformsModel();
        $bots->bot_id = $data->bot_id;
        $bots->name = $data->name;
        $bots->apikey = $data->apikey;
        $bots->username = $data->username;

        if($bots->save()){
            return true;
        }else{
            return false;
        }
    }
 
    public static function edit(object $data) {
        return PlataformsModel::where(['id_user' => $data->id_user, 'id' => $data->id])->update(['name' => $data->name, 'content' => $data->content]);
    }


    public static function editPaymentSettings(object $data) {
        return PlataformsModel::where(['id' => $data->botid])->update(['payment_settings' => $data->payment_settings]);
    }

    public static function editByName(object $data) {

        $getByName = self::getByName($data->name, $data->id_user);
        if($getByName){
            return PlataformsModel::where(['id_user' => $data->id_user, 'name' => $data->name])->update(['content' => $data->content]);
        }else{
            return self::add($data);
        }
    }
    
 }
 