<?php
namespace OfficeMe\Controllers\Admin;

use \OfficeMe\Model\PlataformsModel;
use \OfficeMe\Model\CommandsModel;
use \OfficeMe\Model\OptionsModel;

class PlataformsController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct()
    {

    }


    public function add()
    {

        $name = input('name');
        $username = input('username');
        $apikey = input('apikey');

        if ($name && $username && $apikey) {

            if ($name == "" || $username == "" || $apikey == "") {
                response()->json([
                    'success' => false,
                    'title' => 'Oops!',
                    'message' => 'Preencha todos os campos'
                ]);
            }

            try {

                $username = str_replace('@', '', $username);

                $getByUser = PlataformsModel::getByUsername($username);
                $getByKey = PlataformsModel::getByKey($apikey);

                if ($getByUser || $getByKey) {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Um bot com esses dados já foi cadastrado'
                    ]);
                }

                $telegram = new \Longman\TelegramBot\Telegram($apikey, $username);

                if ($telegram->getBotUsername() != $username) {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Username incorreto para este bot'
                    ]);
                }

                $botid = $telegram->getBotId();

                $result = \Longman\TelegramBot\Request::getUserProfilePhotos([
                    'user_id' => $botid,
                ]);

                $n_photos = $result->raw_data['result']->raw_data['total_count'];

                if ($n_photos) {
                    $file_id = $result->raw_data['result']->raw_data['photos'][0][0]['file_id'];

                    $resultPhoto = \Longman\TelegramBot\Request::getFile([
                        'file_id' => $file_id,
                    ]);

                    $file_path = $resultPhoto->raw_data['result']->raw_data['file_path'];

                    $image = file_get_contents("https://api.telegram.org/file/bot" . $apikey . '/' . $file_path);
                    file_put_contents(BASEDIR . "/public/assets/img/bots/profile-bot-" . $username . ".jpg", $image);

                }

                $addBot = PlataformsModel::add((object) [
                    'bot_id' => $botid,
                    'name' => $name,
                    'apikey' => $apikey,
                    'username' => $username
                ]);


                if ($addBot) {

                    $telegram->setWebhook(WEBHOOK_PREFIX . '/teste.php?botid=' . $botid);

                    $getByKey = PlataformsModel::getByKey($apikey);

                    $addCommand = CommandsModel::add((object) [
                        'bot_id' => $getByKey->id,
                        'command' => '/start',
                        'description' => 'Comando inicial.',
                        'response' => 'Olá, bem vindo ao meu bot',
                        'type' => 'groups',
                        'is_menu' => 1
                    ]);

                    if ($addCommand) {
                        PlataformsController::insertCommandsBot($getByKey->id);
                    }

                    response()->json([
                        'success' => true,
                        'title' => 'Sucesso!',
                        'message' => 'Bot adicionado com sucesso!'
                    ]);

                } else {
                    response()->json([
                        'success' => false,
                        'title' => 'Error!',
                        'message' => 'Não foi possível adicionar o bot no momento, tente novamente mais tarde.'
                    ]);
                }


            } catch (\Exception $e) {
                response()->json([
                    'success' => false,
                    'title' => 'Erro ao se comunicar com a API',
                    'message' => $e->getMessage()
                ]);
            }

        } else {
            response()->json([
                'success' => false,
                'title' => 'Oops!',
                'message' => 'Preencha todos os campos'
            ]);
        }
    }

    public function insertCommandsBot(int $bid)
    {

        $bot = PlataformsModel::getById($bid);

        if ($bot) {

            $commands = CommandsModel::getAll($bid);

            if ($commands) {

                $commands_list = [];

                foreach ($commands as $key => $v) {
                    if ($v->is_menu > 0) {
                        $commands_list[$key] = ['command' => ltrim($v->command, '/'), 'description' => $v->description];
                    }
                }

                $telegram = new \Longman\TelegramBot\Telegram($bot->apikey, $bot->username);
                $addCommands = \Longman\TelegramBot\Request::setMyCommands(['commands' => json_encode($commands_list)]);

                if ($addCommands->isOk()) {
                    return true;
                } else {
                    return false;
                }

            }

        } else {
            return false;
        }


    }


    public function getButtonsCommand(int $cid)
    {
        try {
            $command = CommandsModel::getById($cid);
            if ($command) {

                if ($command->type == "buttons") {

                    if ($command->buttons == "" || $command->buttons == "{}" || $command->buttons == NULL) {
                        response()->json([
                            'success' => true,
                            'rows' => 0,
                            'data' => []
                        ]);
                    } else {

                        if (!json_decode($command->buttons)) {
                            response()->json([
                                'success' => true,
                                'rows' => 0,
                                'data' => []
                            ]);
                        }

                        if (count(json_decode($command->buttons)) <= 0) {
                            response()->json([
                                'success' => true,
                                'rows' => 0,
                                'data' => []
                            ]);
                        }

                        response()->json([
                            'success' => true,
                            'rows' => count(json_decode($command->buttons)),
                            'data' => json_decode($command->buttons)
                        ]);

                    }

                } else {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Este comando não é do tipo botões'
                    ]);
                }

            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Oops!',
                    'message' => 'Comando não localizado'
                ]);
            }
        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Erro ao se comunicar com a API',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getCommand(int $cid)
    {
        try {
            $command = CommandsModel::getById($cid);
            if ($command) {

                response()->json([
                    'success' => true,
                    'data' => $command
                ]);

            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Oops!',
                    'message' => 'Comando não localizado'
                ]);
            }
        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Erro ao se comunicar com a API',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function editCommand(int $id)
    {
        try {

            $bid = input('botid');

            $bot = PlataformsModel::getById($bid);

            if ($bot) {

                $commandData = CommandsModel::getById($id);
                if ($commandData) {

                    $command = input('command');
                    $description = input('description');
                    $response = input('response');
                    $type = input('type');
                    $is_menu = input('is_menu');


                    if (!$command || !$description || !$response || !$type) {
                        response()->json([
                            'success' => false,
                            'title' => 'Oops!',
                            'message' => 'Preencha todos os campos'
                        ]);
                    }

                    if ($is_menu == "" || $command == "" || $description == "" || $response == "" || $type == "") {
                        response()->json([
                            'success' => false,
                            'title' => 'Oops!',
                            'message' => 'Preencha todos os campos'
                        ]);
                    }

                    if (!in_array($type, ['groups', 'message', 'buttons'])) {
                        response()->json([
                            'success' => false,
                            'title' => 'Oops!',
                            'message' => 'Escolha um tipo válido'
                        ]);
                    }


                    $edit = CommandsModel::edit((object) [
                        'id' => $id,
                        'bot_id' => $bid,
                        'command' => $command,
                        'description' => $description,
                        'response' => $response,
                        'type' => $type,
                        'is_menu' => $is_menu
                    ]);

                    if ($edit) {

                        PlataformsController::insertCommandsBot($bid);

                        response()->json([
                            'command_id' => $id,
                            'success' => true,
                            'title' => 'Sucesso!',
                            'message' => 'Comando editado com sucesso!'
                        ]);

                    } else {
                        response()->json([
                            'success' => false,
                            'title' => 'Oops!',
                            'message' => 'Desculpe, tente novamente mais tarde.'
                        ]);
                    }

                } else {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Comando não localizado'
                    ]);
                }

            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Bot não localizado'
                ]);
            }
        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Erro ao se comunicar com a API',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function addButtons(int $cid)
    {
        try {

            $commandData = CommandsModel::getById($cid);

            if ($commandData) {

                $buttons = input('buttons');

                if (!$buttons) {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Preencha todos os campos'
                    ]);
                }

                if ($buttons == "") {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Preencha todos os campos'
                    ]);
                }


                $edit = CommandsModel::editButtons((object) [
                    'id' => $cid,
                    'buttons' => $buttons
                ]);

                if ($edit) {

                    response()->json([
                        'success' => true,
                        'title' => 'Sucesso!',
                        'message' => 'Botões editados com sucesso!'
                    ]);

                } else {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Desculpe, tente novamente mais tarde.'
                    ]);
                }

            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Oops!',
                    'message' => 'Comando não localizado'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Erro ao se comunicar com a API',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function addCommand(int $bid)
    {
        try {

            $bot = PlataformsModel::getById($bid);

            if ($bot) {

                $command = input('command');
                $description = input('description');
                $response = input('response');
                $type = input('type');
                $is_menu = input('is_menu');


                if (!$command || !$description || !$response || !$type) {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Preencha todos os campos'
                    ]);
                }

                if ($is_menu == "" || $command == "" || $description == "" || $response == "" || $type == "") {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Preencha todos os campos'
                    ]);
                }

                if (!in_array($type, ['groups', 'message', 'buttons'])) {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Escolha um tipo válido'
                    ]);
                }

                $ad_command = CommandsModel::add((object) [
                    'bot_id' => $bid,
                    'command' => $command,
                    'description' => $description,
                    'response' => $response,
                    'type' => $type,
                    'is_menu' => $is_menu
                ]);

                if ($ad_command) {

                    $insertedCommands = PlataformsController::insertCommandsBot($bid);

                    if ($insertedCommands) {

                        response()->json([
                            'command_id' => $ad_command,
                            'success' => true,
                            'title' => 'Sucesso!',
                            'message' => 'Comandos adicionados com sucesso.'
                        ]);

                    } else {
                        response()->json([
                            'success' => false,
                            'title' => 'Error',
                            'message' => 'Desculpe, tente novamente mais tarde.'
                        ]);
                    }

                } else {
                    response()->json([
                        'success' => false,
                        'title' => 'Error',
                        'message' => 'Desculpe, tente novamente mais tarde.'
                    ]);
                }

            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Bot não localizado'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Erro ao se comunicar com a API',
                'message' => $e->getMessage()
            ]);
        }
    }


    public static function addMenuMessage($existsBtns = false, $keyboardArray = [])
    {

        $getTextMenu = OptionsModel::getByName('text_menu')->content;
        $getTextMenu = $getTextMenu ? $getTextMenu : "Menu";

        $menuButton = [
            [
                "text" => $getTextMenu,
                "callback_data" => "menu"
            ]
        ];

        if ($existsBtns) {
            $keyboardArray['inline_keyboard'][] = $menuButton;
            return $keyboardArray;
        } else {

            $keyboardMenu['inline_keyboard'][] = $menuButton;
            return $keyboardMenu;
        }

    }

    public static function addButtonsMessage($buttons, $command)
    {

        if (count($buttons) > 0) {
            foreach ($buttons as $k => $btn) {
                $keyboardButtons['inline_keyboard'][] = [
                    [
                        "text" => $btn->setting->text,
                        "callback_data" => 'btn_' . $command->id . '_' . $btn->index
                    ]
                ];
            }

            
            return $keyboardButtons;

        }

        return false;

    }

    public function saveProfilePic()
    {

        try {

            $bid = input('id');

            $bot = PlataformsModel::getById($bid);

            if ($bot) {

                $is_img = false;
                $telegram = new \Longman\TelegramBot\Telegram($bot->apikey, $bot->username);

                if ($telegram->getBotUsername() != $bot->username) {
                    response()->json([
                        'success' => false,
                        'title' => 'Oops!',
                        'message' => 'Dados do bot incorretos'
                    ]);
                }

                $botid = $telegram->getBotId();

                $result = \Longman\TelegramBot\Request::getUserProfilePhotos([
                    'user_id' => $botid,
                ]);

                $n_photos = $result->raw_data['result']->raw_data['total_count'];

                if ($n_photos) {

                    $is_img = true;

                    $file_id = $result->raw_data['result']->raw_data['photos'][0][0]['file_id'];

                    $resultPhoto = \Longman\TelegramBot\Request::getFile([
                        'file_id' => $file_id,
                    ]);
                    $file_path = $resultPhoto->raw_data['result']->raw_data['file_path'];

                    $image = file_get_contents("https://api.telegram.org/file/bot" . $bot->apikey . '/' . $file_path);
                    file_put_contents(BASEDIR . "/public/assets/img/bots/profile-bot-" . $bot->username . ".jpg", $image);

                }

                //\Longman\TelegramBot\Request::setWebhook(['url' => WEBHOOK_PREFIX . '/teste.php?botid=' . $bot->id ]);
                //\Longman\TelegramBot\Request::deleteWebhook([]);

                response()->json([
                    'success' => true,
                    'title' => 'Sucesso!',
                    'message' => 'Foto do bot atualizada',
                    'profile_pic' => ($is_img ? APP_URL . '/public/assets/img/bots/profile-bot-' . $bot->username . '.jpg' : APP_URL . '/public/assets/img/default.png') . '?v=' . uniqid()
                ]);


            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Bot não localizado'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function list_commands(int $bid)
    {
        try {

            $bot = PlataformsModel::getById($bid);

            if ($bot) {

                $commands = CommandsModel::getAll($bid);

                if ($commands) {

                    if (!empty($commands)) {

                        $bots = [];

                        foreach ($commands as $key => $value) {

                            $bots[$key] = [
                                'id' => $value->id,
                                'command' => $value->command,
                                'response' => $value->response,
                                'type' => $value->type
                            ];
                        }

                        response()->json($bots);

                    }

                }


            } else {
                response()->json([
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Bot não localizado'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'title' => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function list()
    {
        $b = PlataformsModel::getAll();

        if ($b) {
            if (!empty($b)) {

                $bots = [];
                $i = 0;

                foreach ($b as $key => $value) {

                    $bots[$key] = [
                        'id' => $value->id,
                        'name' => $value->name,
                        'username' => $value->username,
                        'profile_pic' => is_file(BASEDIR . '/public/assets/img/plataforms/'. $value->id . '.png') ? APP_URL . '/public/assets/img/plataforms/' . $value->id . '.png' : APP_URL . '/public/assets/img/default.png',
                    ];

                    $i++;
                }

                response()->json([
                    'success' => true,
                    'data' => $bots,
                    'rows' => $i
                ]);

            }
        }

        response()->json([
            'success' => true,
            'data' => [],
            'rows' => 0
        ]);

    }

    private function typeStatus(string $c)
    {

        if ($c > 0 && $c < 2) {
            return (object) ['color' => 'gradient-success', 'text' => 'Uma campanha ativa'];
        } else if ($c > 2) {
            return (object) ['color' => 'gradient-success', 'text' => '(' . $c . ') campanhas ativas'];
        } else {
            return (object) ['color' => 'gradient-secondary', 'text' => 'Nenhuma'];
        }
    }

    public function delete(int $id)
    {
        $sale = ListsModel::getById($id);
        if ($sale) {
            if (ListsModel::remove($id)) {
                response()->json([
                    'title' => 'Removido!',
                    'success' => true,
                    'message' => 'Lista removida com sucesso!'
                ]);
            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Lista não removida'
                ]);
            }
        } else {
            response()->json([
                'title' => 'Erro!',
                'success' => false,
                'message' => 'Lista não localizada'
            ]);
        }
    }

    public function edit()
    {
        try {
            $data = input('data');

            if ($data) {
                $data = json_decode($data);
                $edit = ListsModel::edit($data);
                if ($edit) {

                    response()->json([
                        'title' => 'Editado!',
                        'success' => true,
                        'message' => 'Lista editada com sucesso!'
                    ]);
                }
            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Não foi possível editar a lista.'
                ]);
            }
        } catch (\Exception $th) {
            response()->json([
                'title' => 'Erro!',
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

}