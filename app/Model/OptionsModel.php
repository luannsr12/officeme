<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 
 final class OptionsModel extends Model
 {
    protected $table = 'options_settings';

    protected $primaryKey = 'id';

    public static function getById(string $oid, int $uid = 0) {
        return OptionsModel::where(['id' => $oid, 'id_user' => $uid])->first();
    }

    public static function getByName(string $name) {
        return OptionsModel::where(['name' => $name])->first();
    }

    public static function remove(int $id){
        $option = OptionsModel::find($id);
        return $option->delete();
    }

    public static function add(object $data) {
        
        $options = new OptionsModel();
        $options->id_user = $data->id_user;
        $options->name = $data->name;
        $options->content = $data->content;

        if($options->save()){
            return true;
        }else{
            return false;
        }
    }
 
    public static function edit(object $data) {
        return OptionsModel::where(['id_user' => $data->id_user, 'id' => $data->id])->update(['name' => $data->name, 'content' => $data->content]);
    }
    public static function editByName(object $data) {

        $getByName = self::getByName($data->name, $data->id_user);
        if($getByName){
            return OptionsModel::where(['id_user' => $data->id_user, 'name' => $data->name])->update(['content' => $data->content]);
        }else{
            return self::add($data);
        }
    }
    
 }
 