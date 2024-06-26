<?php
namespace OfficeMe\Controllers\Admin;

use OfficeMe\Model\PaymentModel;
use OfficeMe\Model\BotsModel;
use OfficeMe\Model\OptionsModel;
use Carbon\Carbon;

class PaymentsController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct(){
      
    }
    
 
   public static function isExpiratePin($payment_settings){
        try {

            $currentTimestamp = Carbon::now(TIME_ZONE)->timestamp;

            if(json_decode($payment_settings)){

                $payment_settings = json_decode($payment_settings);

                $payment_settings_new[] = [];

                foreach ($payment_settings as $key => $value) {

               
                    $payment_settings_new[$key] = $value;

                    if($currentTimestamp > $value->split->pin->expire){
                        $payment_settings_new[$key]->split->pin->is_expired = true;
                    }else{
                        $payment_settings_new[$key]->split->pin->is_expired = false;
                    }
                }

                return json_decode(json_encode($payment_settings_new));

            }
            
           
        } catch (\Exception $e) {
            return json_decode($payment_settings);
        }
   }

   public function generate_link_split(int $bid){
        try {

            $pin_split = rand(10000,99999);
            $bot       = BotsModel::getById($bid);

            if($bot){

                $gateway = input('gateway');

                $payment_settings = (json_decode($bot->payment_settings) && $bot->payment_settings != NULL)
                ? json_decode($bot->payment_settings) : PaymentModel::createPaymentSettings($bid, $gateway);

               if(isset($payment_settings->$gateway->split->pin->number)){
                  
                    $payment_settings->$gateway->split->pin->number = $pin_split;
                    $payment_settings->$gateway->split->pin->expire = Carbon::now(TIME_ZONE)->addHour()->timestamp;

                    $editPaymentSettings = BotsModel::editPaymentSettings((object) [
                        'botid' => $bid,
                        'payment_settings' => json_encode($payment_settings)
                    ]);

                    if($editPaymentSettings){

                        response()->json([
                            'title'   => 'Sucesso!',
                            'success' => true,
                            'message' => 'Link gerado com sucesso!',
                            'link'    => APP_URL . "/connect/{$gateway}/split/{$bid}/{$pin_split}"
                        ]);

                    }else{
                        response()->json([
                            'title' => 'Erro!',
                            'success' => false,
                            'message' => 'Desculpe, tente novamente mais tarde.'
                        ]);
                    }
        
               }else{
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Desculpe, nenhum PIN encontrado para esta gateway'
                    ]);
                }

            }else{
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Bot não localizado!'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'title' => 'Erro!',
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
   }


   public function savePaymentSettings(int $bid){
    
    try {
        
        $bot = BotsModel::getById($bid);

        if($bot){

            $payment_settings = input('payment_settings');

            if(!$payment_settings){
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Preencha todos os campos'
                ]);
            }

            if(!json_decode($payment_settings)){
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Desculpe, tente novamente mais tarde'
                ]);
            }

            
            $payment_settings_json = $payment_settings;
            $payment_settings = json_decode($payment_settings);

            $name_gateway = '';

            foreach ($payment_settings as $key => $value) {
                $name_gateway = $key;
                break;
            }
 
            $get_gateways = OptionsModel::getByName('gateways');
            $get_gateways = $get_gateways ? $get_gateways->content : false;
    
            $gateways = ($get_gateways && json_decode($get_gateways))
            ? json_decode($get_gateways) : false;
    
            if(!$gateways){
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Nenhuma gateway de pagamento encontrada'
                ]);
            }
    
            $isGateway = false;
    
            foreach ($gateways as $key => $gate) {
               if($gate->name == $name_gateway){
                    $isGateway = $gate;
                    break;
               }
            }

            if($isGateway){

                $edit_settings_payment = BotsModel::editPaymentSettings((object)['botid' => $bid, 'payment_settings' => $payment_settings_json]);

                if($edit_settings_payment){

                    response()->json([
                        'title' => 'Sucesso!',
                        'success' => true,
                        'message' => 'Configurações de pagamento alteradas com sucesso!'
                    ]);

                }else{
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Desculpe, alterações não salvas, tente novamente mais tarde.'
                    ]);
                }

            }else{
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Está gateway de pagamento não está instalada no sistema.'
                ]);
            }

        }else{
            response()->json([
                'title' => 'Erro!',
                'success' => false,
                'message' => 'Bot não localizado!'
            ]);
        }

    } catch (\Exception $e) {
        response()->json([
            'title' => 'Erro!',
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
   }

}