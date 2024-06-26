<?php

namespace OfficeMe\Model;

use \Illuminate\Database\Eloquent\Model;
use OfficeMe\Model\BotsModel;
use OfficeMe\Model\OptionsModel;
use Carbon\Carbon;

final class PaymentModel extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'id';


    public static function createPaymentSettings(int $bid, string $gateway_name)
    {

        $get_gateways = OptionsModel::getByName('gateways');
        $get_gateways = $get_gateways ? $get_gateways->content : false;

        $gateways = ($get_gateways && json_decode($get_gateways))
        ? json_decode($get_gateways) : false;

        if(!$gateways){
            redirect(APP_URL . '/p/bots/settings/' . $bid);
        }

        $isGateway = false;

        foreach ($gateways as $key => $gate) {
           if($gate->name == $gateway_name){
                $isGateway = $gate;
                break;
           }
        }

        if(!$isGateway){
            redirect(APP_URL . '/p/bots/settings/' . $bid);
        }

        $payment_settings = json_encode([
            "{$gateway_name}" => [
                'enable' => '0',
                'title'  => $isGateway->title,
                'data' => [
                    'access_token' => ''
                ],
                'split' => [
                    'enable' => '0',
                    'access_token' => '',
                    'expire_access_token' => '',
                    'refresh_token' => '',
                    'percent' => 0,
                    'pin'     => [
                        'number' => rand(10000,999999),
                        'expire' => Carbon::now(TIME_ZONE)->addHour()->timestamp
                    ]
                ],
                'methods' => [
                    'pix' => [
                        'enable' => '1',
                        'text' => 'Pagar com pix'
                    ],
                    'link' => [
                        'enable' => '0',
                        'text' => 'Pagar com cartão'
                    ]
                ]
            ]

        ]);


        $editPaymentSettings = BotsModel::editPaymentSettings((object) [
            'botid' => $bid,
            'payment_settings' => $payment_settings
        ]);

        if ($editPaymentSettings) {
            return json_decode($payment_settings);
        } else {
            return false;
        }

    }


    public static function edit(object $data)
    {
        return GroupsModel::where(['id' => $data->id, 'group_id' => $data->group_id, 'bot_id' => $data->bot_id])
            ->update(
                [
                    'invite_link' => $data->invite_link,
                    'type_group' => $data->type_group,
                    'name' => $data->name,
                    'description' => $data->description,
                    'members_count' => $data->members_count,
                    'permissions' => $data->permissions
                ]
            );
    }

    public static function add(object $data) {
        
        $payment = new PaymentModel();
        $payment->data = $data->data;
        $payment->chat_id = $data->chat_id;
        $payment->plan_id = $data->plan_id;
        $payment->group_id = $data->group_id;
        $payment->external_reference = $data->external_reference;

        if($payment->save()){
            return $payment;
        }else{
            return false;
        }
    }

    public static function setLastMessageBot(object $data)
    {
        return GroupsModel::where(['id' => $data->id])->update(['message_conversation' => $data->message_conversation]);
    }

    public static function setIdMessagePay(object $data)
    {
        return PaymentModel::where(['id' => $data->id])->update(['id_message' => $data->id_message]);
    }
}
