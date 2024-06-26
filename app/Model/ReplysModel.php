<?php

namespace OfficeMe\Model;

use \Illuminate\Database\Eloquent\Model;
use \OfficeMe\Model\SellerModel;

final class ReplysModel extends Model
{
    protected $table = 'history_reply';

    protected $primaryKey = 'id';

    public static function getById(string $gid)
    {
        return ReplysModel::where('id', $gid)->first();
    }

    public static function getByIdMessage(string $sid)
    {
        return ReplysModel::where('send_id', $sid)->first();
    }

    public static function getAll()
    {
        $replys = ReplysModel::all();
        return $replys;
    }

    public static function remove(int $id)
    {
        $replys = ReplysModel::find($id);
        return $replys->delete();
    }

    public static function getReplyByMessage(int $sid, int $cid)
    {
        $replyCampaign = ReplysModel::where(['send_id' => $sid, 'campaign_id' => $cid])->first();
        return $replyCampaign;
    }

    public static function add(object $data)
    {

        $replys = new ReplysModel();
        $replys->list_id = $data->list_id;
        $replys->campaign_id = $data->campaign_id;
        $replys->send_id = $data->send_id;
        $replys->customer_contact = $data->customer_contact;
        $replys->seller_id = $data->seller_id;
        $replys->message_content = $data->message_content;
        
        if ($replys->save()) {
            return true;
        } else {
            return false;
        }

    }


    public static function getReplysCampaign(int $cid)
    {
        $replysCampaign = ReplysModel::where('campaign_id', $cid)->get();
        return $replysCampaign;
    }

    
   public static function getNextSeller($lid, $cid, $sid){

    $nextSeller = false;

    $lastReply = ReplysModel::where(['list_id' => $lid, 'campaign_id' => $cid])->orderBy('id', 'desc')->first();
    
     if(!$lastReply){

        $nextSeller = SellerModel::where('list_id', $lid)->orderBy('id', 'asc')->first();

     }else{

            // Obtém o próximo vendedor com base no último vendedor registrado
            $nextSeller = SellerModel::where('list_id', $lid)
            ->whereRaw("id > {$lastReply->seller_id}")
            ->orderBy('id', 'asc')
            ->first();

            if(!$nextSeller){
                $nextSeller = SellerModel::where('list_id', $lid)->orderBy('id', 'asc')->first();
            }
     }

     return $nextSeller;

    }

}
