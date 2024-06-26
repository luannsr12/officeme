<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;

 final class SellerModel extends Model
 {
    protected $table = 'sellers';

    protected $primaryKey = 'id';

    public static function getById(string $sid) {
        return SellerModel::where('id', $sid)->first();
    }
 
    public static function getAll() {
        $sellers = SellerModel::all();
        return $sellers;
    }

    public static function remove(int $id){
        $seller = SellerModel::find($id);
        return $seller->delete();
    }

    public static function add(object $data) {
        
        $seller = new SellerModel();
        $seller->name = $data->name;
        $seller->whatsapp = $data->whatsapp;
        $seller->list_id = $data->list_id;

        if($seller->save()){
            return true;
        }else{
            return false;
        }

    }

    public static function edit(object $data) {
        return SellerModel::where('id', $data->id)->update(['name' => $data->name, 'whatsapp' => $data->whatsapp, 'list_id' => $data->list_id]);
    }
 
    public static function getsellersByList(int $lid)
    {
        $sellersList = SellerModel::where('list_id', $lid)->get();
        return $sellersList;
    }

    
 }
 