<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 use \OfficeMe\Controllers\Api\WebhookController;
 use Carbon\Carbon;

 final class PlansModel extends Model
 {
    protected $table = 'plans';

    protected $primaryKey = 'id';

    public static function buildKeyboardArray(int $group_id) {
        // Recupera os dados da tabela groups
        $plans = PlansModel::where(['group_id' => $group_id])->get();

        if(!$plans){
            return false;
        }
    
        // Inicializa o array do teclado
        $keyboardArray = [
            "inline_keyboard" => []
        ];
    
        // Adiciona os botões ao array do teclado
        foreach ($plans as $plan) {
            $keyboardArray['inline_keyboard'][] = [
                [
                    "text" => WebhookController::escapeMarkdown($plan->name),
                    "callback_data" => 'plan_' . $plan->id
                ]
            ];
        }
    
        return $keyboardArray;
    }

    public static function getByGroup(int $group_id) {
        return PlansModel::where(['group_id' => $group_id])->get();
    }

    public static function getByIdTelegram(int $group_id) {
        return PlansModel::where(['group_id' => $group_id])->first();
    }
    
    public static function getById(int $id) {
        return PlansModel::where(['id' => $id])->first();
    }
    

    public static function remove(int $id){
        $group = PlansModel::find($id);
        return $group->delete();
    }

    public static function add(object $data) {
        
        $group = new PlansModel();
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
 