<?php
namespace OfficeMe\Controllers\Gateways;

use Ramsey\Uuid\Uuid;
use OfficeMe\Model\OptionsModel;
use OfficeMe\Model\PaymentModel;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class Mercadopago
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

     public $data = NULL;

     public $error = false;

     public $message_erro = false;

     public $access_token = NULL;

     public $plan = NULL;

     public $group = NULL;

     public $chat_id = NULL;

     public $debug = false;

     public $email_settings_payment = NULL;

    public function __construct($data = NULL){
      
       $this->data = $data;

       $name_gateway = $data->name_gateway;

       $this->access_token = $this->data->payment_settings->$name_gateway->data->access_token;

       $this->plan = $this->data->plan;

       $this->group = $this->data->group;

       $this->chat_id = $this->data->chat_id;

       $this->debug = IS_DEBUG;

       $this->email_settings_payment = OptionsModel::getByName('email_settings_payment') ? OptionsModel::getByName('email_settings_payment')->content : '';
 
       if($this->access_token == "" || (int)$this->data->payment_settings->$name_gateway->enable > 1){
            $this->error = true;
            $this->message_erro = "Mercado pago não ativo ou não configurado.";
       }

       $this->init();

    }
    
    public function init(){
        if( $this->error ){
            if($this->debug){
                dd($this->message_erro);
            }else{
                return [
                    'chat_id' => $this->chat_id,
                    'text'    => 'Metodo de pagamento indisponível no momento. Error code: #'. uniqid()
                ];
            }

        }

        MercadoPagoConfig::setAccessToken($this->access_token);

    }

    public function pix(){

    $client = new PaymentClient();

    try {

        $external_reference = Uuid::uuid4();
 
        $request = [
            "transaction_amount" => (double)$this->plan->value,
            "description" => $this->plan->name,
            "payment_method_id" => "pix",
            "external_reference" => $external_reference,
            "payer"  => [
                "email" => $this->email_settings_payment
            ]
        ];

        // Step 5: Create the request options, setting X-Idempotency-Key
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: {$external_reference}"]);

        // Step 6: Make the request
        $payment = $client->create($request, $request_options);
        
        $addPayment = PaymentModel::add((object)[
            'data' => json_encode($payment),
            'chat_id' => $this->chat_id,
            'plan_id' => $this->plan->id,
            'group_id' => $this->group->id,
            'external_reference' => $external_reference
        ]);

        if($addPayment){

            $plan = $this->plan;
            $group = $this->group;

            return [
                'chat_id'   => $this->chat_id,
                'text'      => "`".$payment->point_of_interaction->transaction_data->qr_code."`",
                'is_send'   => true,
                'thats_edit' => [
                    'id_pay'    => $payment->id,
                    'id_pay_db' => $addPayment->id,
                    'plan'      => ['id' => $plan->id, 'name' => $plan->name, 'value' => $plan->value],
                    'group'     => ['id' => $group->id, 'name' => $group->name, 'invite_link' => $group->invite_link],
                ]
            ];

        }else{
            return [
                'chat_id' => $this->chat_id,
                'text'    => 'Metodo de pagamento indisponível no momento. Error code: #'. uniqid()
            ];
        }
            
        }catch (MPApiException $e) {
            // echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
            // echo "Content: ";
            // var_dump($e->getApiResponse()->getContent());
            if($this->debug){
                dd($e->getApiResponse()->getContent());
            }
        } catch (\Exception $e) {
            // echo $e->getMessage();
            if($this->debug){
                dd($e->getMessage());
            }
        }

    }

}