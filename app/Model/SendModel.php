<?php

namespace OfficeMe\Model;
use \Illuminate\Pagination\Paginator;

use \Illuminate\Database\Eloquent\Model;

final class SendModel extends Model
{
    protected $table = 'history_send';

    protected $primaryKey = 'id';

    public static function getById(string $gid)
    {
        return SendModel::where('id', $gid)->first();
    }

    public static function getByIdAndCampaign(int $mid, int $cid)
    {
        return SendModel::where(['id' => $mid, 'campaign_id' => $cid])->first();
    }

    public static function getAll()
    {
        $replys = SendModel::all();
        return $replys;
    }

    public static function remove(int $id)
    {
        $replys = SendModel::find($id);
        return $replys->delete();
    }

    public static function add(object $data)
    {

        $send = new SendModel();
        $send->list = $data->list;
        $send->campaign_id = $data->campaign_id;
        $send->customer_contact = $data->customer_contact;
        $send->message_content = $data->message_content;

        if ($send->save()) {
            return $send->id;
        } else {
            return false;
        }

    }

    public static function setStatus(object $data) {
        return SendModel::where('id', $data->id)->update(['status' => $data->status]);
    }

    public static function setIdMessage(object $data) {
        return SendModel::where('id', $data->id)->update(['id_message' => $data->id_message]);
    }
    
    public static function setMessageInfo(object $data) {
        return SendModel::where('id', $data->id)->update(['message_info' => $data->message]);
    }
 
    public static function getSendsCampaignPagination($cid, $page, $perPage =10)
    {
        $campaignsByList = SendModel::where('campaign_id', $cid)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
        return $campaignsByList;
    }
    public static function getSendsCampaign(int $cid)
    {
        $replysCampaign = SendModel::where('campaign_id', $cid)->get();
        return $replysCampaign;
    }

    public static function getMessageSendByCustomer($number)
    {
        $replysCampaign = SendModel::where(['customer_contact' => $number, 'status' => 'delivered'])->orderBy('id', 'desc')->first();
        return $replysCampaign;
    }

    public static function getNotSended(int $cid, array $array){
        $numbersInTable = SendModel::where('campaign_id', $cid)->pluck('customer_contact')->toArray();

        $filteredArray = $array;
        foreach ($filteredArray as $key => $item) {
            $phoneNumber = explode(';', $item)[1]; // Obtém o número após o ponto e vírgula
            if (in_array($phoneNumber, $numbersInTable)) {
                unset($filteredArray[$key]); // Remove o elemento da cópia da array
            }
        }
    
        return $filteredArray;
    }


    public static function getDeliveredCampaign(int $cid)
    {
        $replysCampaign = SendModel::where(['campaign_id' => $cid, 'status' => 'delivered'])->get();
        return $replysCampaign;
    }

    public static function getErrorCampaign(int $cid)
    {
        $replysCampaign = SendModel::where(['campaign_id' => $cid, 'status' => 'error'])->get();
        return $replysCampaign;
    }

}
