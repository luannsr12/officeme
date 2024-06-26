<?php

namespace OfficeMe\Model;

use \Illuminate\Pagination\Paginator;
use \Illuminate\Database\Eloquent\Model;
use \OfficeMe\Model\ListsModel;
use \Illuminate\Database\Capsule\Manager as DB;
use Carbon\Carbon;

final class CustomersModel extends Model
{
    protected $table = 'customers';

    protected $primaryKey = 'id';

    public static function getById(int $cid)
    {
        return CustomersModel::where(['id' => $cid, 'id_user' => get_uid()])->first();
    }

    public static function getAll()
    {
        $customers = CustomersModel::all();
        return $customers;
    }

    public static function getNews(int $d = 30)
    {
        $daysAfter = Carbon::now()->subDays($d)->startOfDay();

        return CustomersModel::where('id_user', get_uid())
            ->where('created_at', '>=', $daysAfter)
            ->get();
    }

    public static function getRenovated(int $d = 30)
    {
        $daysAfter = Carbon::now()->subDays($d)->startOfDay();

        return CustomersModel::where('id_user', get_uid())
            ->where('renovated_at', '>=', $daysAfter)
            ->whereNotNull('renovated_at')
            ->get();
    }


    public static function getNewsByMY(int $m = 1, int $y = 2024)
    {

        return CustomersModel::where('id_user', get_uid())
            ->whereYear('created_at', $y)
            ->whereMonth('created_at', $m)
            ->get();

    }

    public static function getRenovatedByMY(int $m = 1, int $y = 2024)
    {

        return CustomersModel::where('id_user', get_uid())
            ->whereYear('renovated_at', $y)
            ->whereMonth('renovated_at', $m)
            ->get();
    }


    public static function remove(int $id)
    {
        $financial = CustomersModel::where('id', $id)
            ->where('id_user', get_uid())
            ->first();

        if ($financial) {
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
