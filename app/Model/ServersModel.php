<?php

namespace OfficeMe\Model;

use \Illuminate\Pagination\Paginator;
use \Illuminate\Database\Eloquent\Model;
use \OfficeMe\Model\ListsModel;
use \Illuminate\Database\Capsule\Manager as DB;

final class ServersModel extends Model
{
    protected $table = 'servers';

    protected $primaryKey = 'id';

    public static function getById(int $sid)
    {
        return ServersModel::where(['id' => $sid, 'id_user' => get_uid()])->first();
    }

       public static function getAll()
    {
        $customers = ServersModel::where(['id_user' => get_uid()])->get();
        return $customers;
    }

    public static function remove(int $id){
        $financial = ServersModel::where('id', $id)
                                    ->where('id_user', get_uid())
                                    ->first();
    
        if($financial){
            return $financial->delete();
        }
    
        return false;
    }
 

    // public static function add(object $data)
    // {

    //     $campaigns = new CampaignsModel();
    //     $campaigns->list = $data->list; 
    //     $campaigns->contacts = $data->contacts;
    //     $campaigns->message = $data->message;

    //     if ($campaigns->save()) {

    //         CampaignsModel::setNoReplyLastContacts($data->contacts, $data->list);

    //         return true;
            
    //     } else {
    //         return false;
    //     }

    // }
 
 

    // public static function edit(object $data)
    // {
    //     return CampaignsModel::where('id', $data->id)->update(['name' => $data->name, 'contacts' => $data->contacts, 'message' => $data->message]);
    // }



}
