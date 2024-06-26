<?php
namespace OfficeMe\Controllers\Admin;

use OfficeMe\Model\OptionsModel;
use \OfficeMe\Model\BotsModel;
use \OfficeMe\Model\PaymentModel;
use \OfficeMe\Model\ChatsModel;
use \OfficeMe\Model\CommandsModel;
use \OfficeMe\Model\PlansModel;
use \OfficeMe\Model\GroupsModel;
use \OfficeMe\Controllers\Api\GroupsController;
use \OfficeMe\Controllers\Api\BotsController;

class WebhookController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct()
    {

    }


    public static function makeMessageCommand($commandPrompt, $bot, $chat_id){

          $command = CommandsModel::getByCommand($commandPrompt, $bot->id);
          $keyboardArray = false;

          if ($command) {

            // is command
            $content_message = [
                'chat_id' => $chat_id,
                'text' => self::escapeMarkdown($command->response)
            ];

            if ($command->type == 'groups') {
                $keyboardArray = GroupsModel::buildKeyboardArray($bot->id);
            }else if($command->type == 'buttons'){
                $keyboardArray = BotsController::addButtonsMessage(json_decode($command->buttons), $command);
            }

            $commandPrompt != "/start" ? $keyboardArray = BotsController::addMenuMessage(true, $keyboardArray) : NULL;
            $keyboardArray ? $content_message['reply_markup'] = json_encode($keyboardArray) : NULL;

            return $content_message;
        }

        return false;
    }

    public static function runButton($chat_id, $bot, $command, $index){
        try {
            if($command->buttons != "" && $command->buttons != NULL){
                if(json_decode($command->buttons)){

                    $buttons = json_decode($command->buttons, true);
                    $btn     = null;

                    foreach ($buttons as $item) {
                        if (isset($item['index']) && $item['index'] == $index) {
                            $btn = json_decode(json_encode($item));
                            break;
                        }
                    }

                    if($btn){

                        if($btn->setting->event == "text"){
                            // button type text

                            $content_message = [
                                'chat_id' => $chat_id,
                                'text'    => self::escapeMarkdown($btn->setting->make->value)
                            ];
                        }else if($btn->setting->event == "link"){
                            // button type link

                            $content_message = [
                                'chat_id' => $chat_id,
                                'text' => $command->response
                            ];

                            $keyboardArray['inline_keyboard'][] = [
                                [
                                    "text" => self::escapeMarkdown($btn->setting->make->text_link),
                                    "url" =>  $btn->setting->make->link
                                ]
                            ];

                            $keyboardArray = BotsController::addMenuMessage(true, $keyboardArray);
                            $content_message['reply_markup'] = json_encode($keyboardArray);

                        }else if($btn->setting->event == "command"){
                            // button type command

                            $runCommand = self::makeMessageCommand($btn->setting->make->value, $bot, $chat_id);

                            if($runCommand){
                                $content_message = $runCommand;
                            }

                        }else if($btn->setting->event == "request"){

                            $url = $btn->setting->make->api;
                            $headersMake = isset($btn->setting->make->headers) ? $btn->setting->make->headers : false;
                            
                            $headers = [];
                            $headers[] = "Content-Type: application/json";

                            if(count((array)$headersMake) > 0){
                                $h = json_decode(json_encode($headersMake), true);
                               
                                foreach ($h as $key => $value) {
                                    $headers[] = "$key: $value";
                                }
                            }
                       
                            $post_data = [
                                'bot_id'  => $bot->bot_id,
                                'chat_id' => $chat_id,
                                'date'    => date('Y-m-d H:i:s'),
                                'event'   => 'request'
                            ];

                             $curl_array = array(
                                CURLOPT_URL => $url,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($post_data),
                                CURLOPT_HTTPHEADER => $headers,
                            );

                            $curl = curl_init();
                            curl_setopt_array($curl, $curl_array);
                            $response = curl_exec($curl);
                            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                            curl_close($curl);
                           
                            if($httpcode == 200){
                                if(json_decode($response)){
                                  
                                    $data_response =  (object)json_decode($response, JSON_UNESCAPED_UNICODE);
                                    
                                    if(isset($data_response->bot_id, $data_response->chat_id) && ( isset($data_response->message) || isset($data_response->command)) ){

                                        // get bot
                                        $bot = BotsModel::getByIdTelegram($data_response->bot_id);

                                        if($bot){
                                          
                                            if(isset($data_response->command)){
                                                $runCommand = self::makeMessageCommand($data_response->command, $bot, $data_response->chat_id);
                                                if($runCommand){
                                                    $content_message = $runCommand;
                                                }
                                              
                                            }else if(isset($data_response->message)){
                                                $content_message = [
                                                    'chat_id' => $data_response->chat_id,
                                                    'text'    => self::escapeMarkdown($data_response->message)
                                                ];
                                              
                                            }

                                            $content_message['is_send'] = true;
                                        }
                                    }else{
                                        $content_message = null;
                                    }
                                }else{
                                    $content_message = null;
                                }
                            }else{
                                $content_message = null;
                            }

                        }

                        return $content_message;
                    }

                }
            }
            

        } catch (\Exception $e) {
            //$e->getMessage()
        }
    }

    public static function runPay($chat_id, $bot, $paywith = false){

        $content_message = [
            'chat_id' => $chat_id,
            'text'    => 'Metodo de pagamento indisponível no momento 2. Error code: #'. uniqid()
        ];

        if(!$paywith){
           return  $content_message;
        }

        if(!isset($paywith['plan_id'], $paywith['metodo'], $paywith['gateway'])){
            return  $content_message;
        }

        $plan_id = $paywith['plan_id'];
        $metodo  = $paywith['metodo'];
        $gateway = $paywith['gateway'];

        $runPlan = self::runPlan($chat_id, $bot, $plan_id, true);

        if(isset($runPlan['plan'])){

            $name_gateway     = $gateway;
            $payment_settings = $runPlan['payment_settings'];
            
            $gateway_run_string = 'OfficeMe\\Controllers\\Gateways\\' . ucfirst($name_gateway);

            if(class_exists($gateway_run_string)){

                $controller_gateway = new $gateway_run_string((object)[
                    'payment_settings' => $payment_settings,
                    'name_gateway' => $name_gateway,
                    'plan' => $runPlan['plan'],
                    'group' => $runPlan['group'],
                    'chat_id' => $chat_id
                ]);

                if(method_exists($controller_gateway, $metodo)){

                    return $controller_gateway->$metodo();

                }

            }

            return  [
                'chat_id' => $chat_id,
                'text'    => 'Metodo de pagamento indisponível no momento. Error code: #'. uniqid()
            ];
        
        }

        $content_message = $runPlan;

        return $content_message;

    }

    public static function runPlan($chat_id, $bot, $plan_id, $isRunPay = false){
        try {

            $content_message = [
                'chat_id' => $chat_id,
                'text'    => 'Plano indisponível no momento. Error code: #'. uniqid()
            ];
            
            $plan_data = PlansModel::getById($plan_id); 

            if($plan_data){

                // get this group DB
                $group = GroupsModel::getById($plan_data->group_id);

                if(!$group){
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhum grupo para este plano foi localizado. Tente voltar ao menu. Error Code: #' . uniqid()
                    ];
                }

                if($bot->payment_settings == "" || $bot->payment_settings == "{}" || $bot->payment_settings == NULL){
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhuma meio de pagamento configurado. Error Code: #' . uniqid()
                    ];
                }

                if(!json_decode($bot->payment_settings)){
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhuma meio de pagamento configurado. Error Code: #' . uniqid()
                    ];
                }

                $payment_settings = json_decode($bot->payment_settings);

                if(empty($payment_settings)){
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhuma meio de pagamento configurado. Error Code: #' . uniqid()
                    ];
                }

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
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhuma meio de pagamento configurado. Error Code: #' . uniqid()
                    ];
                }
        
                $isGateway = false;
        
                foreach ($gateways as $key => $gate) {
                   if($gate->name == $name_gateway){
                        $isGateway = $gate;
                        break;
                   }
                }

                if(!$isGateway){
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhuma meio de pagamento configurado. Error Code: #' . uniqid()
                    ];
                }

                $isGateway = $payment_settings->$name_gateway;

                if((int)$isGateway->enable < 1){
                    return [
                        'chat_id' => $chat_id,
                        'text'    => 'Nenhuma meio de pagamento configurado. Error Code: #' . uniqid()
                    ];
                }

                if(isset($isGateway->methods) && !$isRunPay){

                    $keyboardArray['inline_keyboard'] = [];
                    $isMethod = 0;

                    foreach ($isGateway->methods as $key => $mt) {
                        
                        if((int)$mt->enable > 0){

                            $keyboardArray['inline_keyboard'][] = [
                                [
                                    "text"          => $mt->text,
                                    "callback_data" => "pay_{$plan_data->id}_{$key}_{$name_gateway}" // pay_planid_metodo_gateway
                                ]
                            ];

                            $isMethod++;

                        }

                    }

                    if($isMethod > 0){
        
                        $response_not_plans = OptionsModel::getByName('text_options_paymenyt');

                        if(isset($response_not_plans->content)){

                            $numberFormatter = new \NumberFormatter(CURRENCY_LOCALE,\NumberFormatter::CURRENCY); 

                            $value_format = $numberFormatter->format($plan_data->value);

                            $text_options_paymenyts = str_replace(
                                        ['{{plan_value}}', '{{plan_name}}', '{{group_name}}', '{{group_invite_link}}'],
                                        [$value_format, $plan_data->name, $group->name, $group->invite_link],
                                        $response_not_plans->content
                            );

                            $content_message = [
                                'chat_id' => $chat_id,
                                'text'    => self::escapeMarkdown($text_options_paymenyts)
                            ];
        
                            $keyboardArray = BotsController::addMenuMessage(true, $keyboardArray);
                            $content_message['reply_markup'] = json_encode($keyboardArray);

                        }

                    }
                    
                }

                if($isRunPay){
                    return ['name_gateway' => $name_gateway, 'payment_settings' => $payment_settings, 'plan' => $plan_data, 'group' => $group];
                }

            }

            return $content_message;

        } catch (\Exception $e) {

        }
    }

    public static function messageRun($body_data, $bot, $botid, $isCallback = false)
    {
        // run commands

        $body_data->message = $isCallback ? $body_data->callback_query->message : $body_data->message;

        $chat_id = $body_data->message->chat->id;
        $message_id = $body_data->message->message_id;
        $message = $body_data->message->text;

        // is command for new chat
        $command = CommandsModel::getByCommand($message, $bot->id);
        $command ? ChatsModel::removeByNewCommand($chat_id, $bot->id) : NULL;

        $chat_database = ChatsModel::getByBotAndChat($chat_id, $bot->id);

        // send or edit messge
        $is_send = true;
        $addChat = false;

        if (!$chat_database) {
            // create new chat
            $addChat = ChatsModel::add((object) [
                'chat_id' => $chat_id,
                'bot_id' => $bot->id,
                'last_message' => $message_id,
                'message_conversation' => 0,
            ]);
        } else {
            // edit chat by new message
            $is_send = false;
            ChatsModel::edit((object) [
                'chat_id' => $chat_id,
                'bot_id' => $bot->id,
                'last_message' => $message_id
            ]);
        }

        $idChatDatabase = $addChat ? $addChat : $chat_database->id;
        $chat_database = ChatsModel::getById($idChatDatabase);

        if (!$isCallback) {
           
            $content_message = WebhookController::makeMessageCommand($message, $bot, $chat_id);

        } else {
            // callback

            $data_callback = $body_data->callback_query->data;
            $data_callback = explode('_', $data_callback);
           
            if($data_callback[0] == "menu"){

                $content_message = WebhookController::makeMessageCommand('/start', $bot, $chat_id);

            } else if ($data_callback[0] == "group") {
                // show plans by group
                $id = $data_callback[1];

                // message default not plans
                $response_not_plans = self::escapeMarkdown(OptionsModel::getByName('response_not_plans')->content);

                $content_message = [
                    'chat_id' => $chat_id,
                    'text' => $response_not_plans
                ];

                // get group data
                $group_data = GroupsModel::getById($id);

                if (!$group_data) {
                    $content_message['text'] = $response_not_plans;
                } else {
                    // is plans
                    $plans_count = PlansModel::getByGroup($id); 

                    if (count($plans_count) > 0) {

                        $content_message['text'] = $group_data->name;
                        $keyboardArray = PlansModel::buildKeyboardArray($id);
                       
                    }else{
                        $content_message['text'] = $response_not_plans;
                    }

                    $keyboardArray = $keyboardArray ? BotsController::addMenuMessage(true, $keyboardArray) : BotsController::addMenuMessage();
                    $keyboardArray ? $content_message['reply_markup'] = json_encode($keyboardArray) : NULL;

                }

            } else if ($data_callback[0] == "btn") {

                $command_id = $data_callback[1];
                $btn_index  = $data_callback[2];

                $command = CommandsModel::getById($command_id);

                if($command){
                    if($command->type == "buttons"){
                        $runBtn = self::runButton($chat_id, $bot, $command, $btn_index);
                        if($runBtn){
                            $content_message = $runBtn;
                        }
                    }
                }

            }else if($data_callback[0] == "plan"){
                $plan_id = $data_callback[1];
                $runPlan = WebhookController::runPlan($chat_id, $bot, $plan_id, false);
                if($runPlan){
                    $content_message = $runPlan;
                }
            }else if($data_callback[0] == "pay"){ // pay_planid_metodo_gateway

                $plan_id = $data_callback[1];
                $metodo = $data_callback[2];
                $gateway = $data_callback[3];
                $runPay = WebhookController::runPay($chat_id, $bot, ['plan_id' => $plan_id, 'metodo' => $metodo, 'gateway' => $gateway]);
 
                if($runPay){
                    $content_message = $runPay;
                }
            }

        }
    
        new \Longman\TelegramBot\Telegram($bot->apikey, $bot->username);

        $content_message['parse_mode'] = 'MarkdownV2';

        if(isset($content_message['is_send'])){
            $is_send = true;
            unset($content_message['is_send']);
        }

        if ($is_send) {
    
            if(isset($content_message['thats_edit'])){
                $thats_edit = $content_message['thats_edit'];
                unset($content_message['thats_edit']);
            }

            // send new message
            $result = \Longman\TelegramBot\Request::sendMessage($content_message);
            if ($result->isOk()) {
                $message_id_bot = $result->raw_data['result']->raw_data['message_id'];
                ChatsModel::setLastMessageBot((object) [
                    'id' => $idChatDatabase,
                    'message_conversation' => $message_id_bot
                ]);

                if(isset($thats_edit)){

                    if(isset($thats_edit['id_pay'])){
                        PaymentModel::setIdMessagePay((object) [
                            'id'         => $thats_edit['id_pay_db'],
                            'id_message' => $thats_edit['id_pay']
                        ]);
                    }
    
                    if($chat_database->message_conversation){
    
                        $text_edit  = $response_not_plans = OptionsModel::getByName('text_options_paymenyt');
    
                         if($text_edit){
    
                            $numberFormatter = new \NumberFormatter(CURRENCY_LOCALE,\NumberFormatter::CURRENCY); 
        
                            $value_format = $numberFormatter->format($thats_edit['plan']['value']);
        
                            $text_options_paymenyts = str_replace(
                                        ['{{plan_value}}', '{{plan_name}}', '{{group_name}}', '{{group_invite_link}}'],
                                        [$value_format, $thats_edit['plan']['name'], $thats_edit['group']['name'], $thats_edit['group']['invite_link']],
                                        $text_edit->content
                            );
        
                            $edit_message = [
                                'chat_id' => $chat_id,
                                'text'    => self::escapeMarkdown($text_options_paymenyts)
                            ];
        
                            $edit_message['message_id'] = $chat_database->message_conversation;
                            $edit_message['parse_mode'] = $content_message['parse_mode'];
                            $result = \Longman\TelegramBot\Request::editMessageText($edit_message);
    
                         }
                    }

                }

            }
        } else {
            // edit message
            $content_message['message_id'] = $chat_database->message_conversation;
            $result = \Longman\TelegramBot\Request::editMessageText($content_message);

            if ($result->isOk()) {
                $message_id_bot = $result->raw_data['result']->raw_data['message_id'];
                ChatsModel::setLastMessageBot((object) [
                    'id' => $idChatDatabase,
                    'message_conversation' => $message_id_bot
                ]);
            }

        }

    }


    public static function escapeMarkdown($text) {
        // Lista de caracteres que precisam ser escapados no Markdown
        $specialChars = ['-', '_', '*', '[', ']', '(', ')', '~', '>', '#', '+', '=', '|', '{', '}', '.', '!'];
        
        // Itera sobre cada caractere especial e substitui por ele mesmo precedido por uma barra invertida
        foreach ($specialChars as $char) {
            $text = str_replace($char, '\\' . $char, $text);
        }
    
        return $text;
    }

    public static function new_chat_member($body_data, $bot, $botid)
    {

        $chat = $body_data->my_chat_member->chat;

        if ($chat->type == 'group' || $chat->type == 'supergroup') {
            // new member group
            $group_id = $chat->id;

            if (
                $body_data->my_chat_member->new_chat_member->user->is_bot
                && ($body_data->my_chat_member->new_chat_member->user->first_name == $bot->username || $body_data->my_chat_member->new_chat_member->user->username == $bot->username)
            ) {
                // is member bot admin

                if ($body_data->my_chat_member->new_chat_member->status == "administrator") {
                    // add or update group to bot
                    GroupsController::updateGroupNow($group_id, $bot);
                } else if ($body_data->my_chat_member->new_chat_member->status == "kicked") {
                    // remove group to bot
                    GroupsController::removeGroupToBot($group_id, $bot);
                }

            }

        }

    }

    public static function telegram()
    {
        if (isset($_REQUEST['botid'])) {

            $botid = trim($_REQUEST['botid']);

            $bot = BotsModel::getById($botid);

            if ($bot) {

                $body_data = json_decode(file_get_contents('php://input'));

                if (isset($body_data->message)) {
                    self::messageRun($body_data, $bot, $botid);
                }else if (isset($body_data->callback_query)) {
                    self::messageRun($body_data, $bot, $botid, true);
                } else if (isset($body_data->my_chat_member->new_chat_member)) {
                    self::new_chat_member($body_data, $bot, $botid);
                }

            }

        }

    }


}