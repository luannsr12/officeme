<?php

namespace OfficeMe\Model;

use \Illuminate\Pagination\Paginator;
use \Illuminate\Database\Eloquent\Model;
use \OfficeMe\Model\ListsModel;
use \OfficeMe\Model\SendModel;
use \OfficeMe\Model\ReplysModel;
use \Illuminate\Database\Capsule\Manager as DB;

final class CampaignsModel extends Model
{
    protected $table = 'queue_campaigns';

    protected $primaryKey = 'id';

    public static function getById(int $cid)
    {
        return CampaignsModel::where('id', $cid)->first();
    }

    public static function getProcessingByList(int $lid)
    {
        $campaignProcess = CampaignsModel::where(['list' => $lid, 'status' => 'processing'])->get();
        return $campaignProcess;
    }

    public static function getByActive(){
        return CampaignsModel::where('status', 'processing')->first();
    }

    public static function getInProcessing()
    {
        $campaignProcess = CampaignsModel::where(['status' => 'processing'])->get();
        return $campaignProcess;
    }

    public static function getAllByList($lid, $page, $perPage = 3)
    {
        $campaignsByList = CampaignsModel::where('list', $lid)->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
        return $campaignsByList;
    }

    public static function getAll()
    {
        $campaigns = CampaignsModel::all();
        return $campaigns;
    }

    public static function remove(int $id)
    {
        $campaigns = CampaignsModel::find($id);
        return $campaigns->delete();
    }

    
    public static function setNoReplyLastContacts($contacts, $lid)
    {
        $contacts = explode("\n", $contacts);

        foreach ($contacts as $key => $c) {

            $con = explode(';', $c);
            $isContact = SendModel::where(['list' => $lid, 'customer_contact' => $con[1], 'status' => 'delivered'])->first();
            if($isContact){
                SendModel::where('id', $isContact->id)->update(['status' => 'no_reply']);
            }
        }

    }

    public static function add(object $data)
    {

        $campaigns = new CampaignsModel();
        $campaigns->list = $data->list; 
        $campaigns->contacts = $data->contacts;
        $campaigns->message = $data->message;

        if ($campaigns->save()) {

            CampaignsModel::setNoReplyLastContacts($data->contacts, $data->list);

            return true;
            
        } else {
            return false;
        }

    }
 
    public static function getLastCampaign()
    {
        $latestUpdatedRecord = CampaignsModel::where('status', 'finished')->latest('updated_at')->first();
        return $latestUpdatedRecord;
    }

    public static function getNumContatcs()
    {
        $result = CampaignsModel::selectRaw("SUM(LENGTH(contacts) - LENGTH(REPLACE(contacts, '\n', '')) + 1) AS total_contacts")->first();
        return $result->total_contacts;
    }

    public static function setMessageInfo(object $data) {
        return CampaignsModel::where('id', $data->id)->update(['message_info' => $data->message]);
    }

    public static function setStatus(object $data) {
        return CampaignsModel::where('id', $data->id)->update(['status' => $data->status]);
    }

    public static function setPID(object $data) {
        return CampaignsModel::where('id', $data->id)->update(['pid' => $data->pid]);
    }


    public static function edit(object $data)
    {
        return CampaignsModel::where('id', $data->id)->update(['name' => $data->name, 'contacts' => $data->contacts, 'message' => $data->message]);
    }


    public static function isSentToCostumer($data)
    {
        return SendModel::where(['campaign_id' => $data->cid, 'customer_contact' => $data->phone])->first();

    }

    public static function getQueue(int $cid) {
        $results = DB::table('queue_campaigns as t1')
                    ->selectRaw('TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(t1.contacts, "\n", numbers.n), ";", 1)) AS name')
                    ->selectRaw('TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(t1.contacts, "\n", numbers.n), ";", -1)) AS phone')
                    ->joinSub(function($query) {
                        $query->select(DB::raw('(a.N + b.N * 10 + 1) n'))
                              ->from(DB::raw('(SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a,
                                              (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
                                             ORDER BY n'));
                    }, 'numbers', function($join) {
                        $join->on(DB::raw('CHAR_LENGTH(t1.contacts) - CHAR_LENGTH(REPLACE(t1.contacts, "\n", ""))'), '>=', DB::raw('numbers.n - 1'));
                    })
                    ->whereNotExists(function($query) {
                        $query->select(DB::raw(1))
                              ->from('history_send as hs')
                              ->whereColumn('hs.campaign_id', 't1.id')
                              ->whereRaw('hs.customer_contact = TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(t1.contacts, "\n", numbers.n), ";", -1))');
                    })
                    ->where("id", $cid)
                    ->limit(1)
                    ->get();
    
        return $results;
    }

    public static function percent_logs(int $list_id, int $campaign_id, string $status = "delivered", $model = "send")
    {

        try {

            $total_contacts = 0;
            $count_contacts = 0;

            $campaign = CampaignsModel::getById($campaign_id);
            $contacts = $campaign ? explode("\n", $campaign->contacts) : [];
            $total_contacts = count($contacts);

            foreach ($contacts as $contact) {

                $contact = explode(';', $contact)[1];

                $where_array   = ['customer_contact' => $contact, 'campaign_id' => $campaign_id, 'status' => $status];
                $count_history = 0;

                if($model == "send"){

                    if ($status == "sent") {

                        $count_history = SendModel::where(['customer_contact' => $contact, 'campaign_id' => $campaign_id])
                            ->where(function ($query) {
                                $query->where('status', 'sent')->orWhere('status', 'delivered')->orWhere('status', 'error'); })
                            ->count();
    
                    } else {
                        $count_history = SendModel::where(['customer_contact' => $contact, 'campaign_id' => $campaign_id, 'status' => $status])->count();
                    }

                }else if($model == "reply"){
                    $count_history = ReplysModel::where(['customer_contact' => $contact, 'campaign_id' => $campaign_id])->count();
                }


                if ($count_history > 0) {
                    $count_contacts++;
                }
            }

            $percentage_delivered = ($count_contacts / $total_contacts) * 100;
            return $percentage_delivered;

        } catch (\Exception $e) {
            return 0;
        }

    }

}
