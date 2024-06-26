<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 use \OfficeMe\Model\OptionsModel;
 use \OfficeMe\Controllers\Api\WebhookController;
 use Carbon\Carbon;

 final class GroupsModel extends Model
 {
    protected $table = 'groups';

    protected $primaryKey = 'id';

    public static function getByBotAndChat(int $chat_id, int $bot_id) {
        $thirtyMinutesAgo = Carbon::now()->subMinutes(30);
        return GroupsModel::where(['chat_id' => $chat_id, 'bot_id' => $bot_id])
        ->where('updated_at', '>=', $thirtyMinutesAgo)
        ->first();
    }

    public static function buildKeyboardArray(int $botid) {
        // Recupera os dados da tabela groups
        $groups = GroupsModel::where(['bot_id' => $botid])->get();

        if(!$groups){
            return false;
        }
    
        // Inicializa o array do teclado
        $keyboardArray = [
            "inline_keyboard" => []
        ];
    
        // Adiciona os botões ao array do teclado
        foreach ($groups as $group) {
            $keyboardArray['inline_keyboard'][] = [
                [
                    "text" => WebhookController::escapeMarkdown($group->name),
                    "callback_data" => 'group_' . $group->id
                ]
            ];
        }
    
        return $keyboardArray;
    }

    public static function getByBot(int $bid) {
        return GroupsModel::where(['bot_id' => $bid])->get();
    }

    public static function getByIdTelegram(int $group_id) {
        return GroupsModel::where(['group_id' => $group_id])->first();
    }
    
    public static function getById(int $id) {
        return GroupsModel::where(['id' => $id])->first();
    }
    

    public static function remove(int $id){
        $group = GroupsModel::find($id);
        return $group->delete();
    }

    public static function add(object $data) {
        
        $group = new GroupsModel();
        $group->group_id = $data->group_id;
        $group->invite_link = $data->invite_link;
        $group->type_group = $data->type_group;
        $group->name = $data->name;
        $group->description = $data->description;
        $group->members_count = $data->members_count;
        $group->bot_id = $data->bot_id;
        $group->permissions = $data->permissions;

        if($group->save()){
            return $group->id;
        }else{
            return false;
        }
    }
 
    public static function edit(object $data) {
        return GroupsModel::where(['id'=> $data->id, 'group_id' => $data->group_id, 'bot_id' => $data->bot_id])
        ->update(
            [
                'invite_link' => $data->invite_link,
                'type_group' => $data->type_group,
                'name' => $data->name,
                'description' => $data->description,
                'members_count' => $data->members_count,
                'permissions' => $data->permissions
            ]);
    }

    public static function setLastMessageBot(object $data) {
        return GroupsModel::where(['id' => $data->id])->update(['message_conversation' => $data->message_conversation]);
    }
 }
 