<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 use \Illuminate\Database\Capsule\Manager as DB;
 final class ListsModel extends Model
 {
    protected $table = 'lists';

    protected $primaryKey = 'id';

    public static function getById(int $lid) {
        return ListsModel::where('id', $lid)->first();
    }

    public static function getAll() {
        $groups = ListsModel::all();
        return $groups;
    }

    public static function remove(int $id){
        $lists = ListsModel::find($id);
        return $lists->delete();
    }

    public static function add(object $data) {
        
        $lists = new ListsModel();
        $lists->name = $data->name;
        $lists->contacts = $data->contacts;
        $lists->message = $data->message;

        if($lists->save()){
            return true;
        }else{
            return false;
        }

    }

    public static function getNumContatcs(){
        $result = self::selectRaw("SUM(LENGTH(contacts) - LENGTH(REPLACE(contacts, '\n', '')) + 1) AS total_contacts")->first();
        return $result->total_contacts;
    }

 
    public static function edit(object $data) {
        return ListsModel::where('id', $data->id)->update(['name' => $data->name, 'contacts' => $data->contacts, 'message' => $data->message]);
    }
 
    
 }
 