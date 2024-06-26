<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 use Carbon\Carbon;

 final class ChatsModel extends Model
 {
    protected $table = 'chats';

    protected $primaryKey = 'id';

    public static function getByBotAndChat(int $chat_id, int $bot_id) {
        $thirtyMinutesAgo = Carbon::now()->subMinutes(30);
        return ChatsModel::where(['chat_id' => $chat_id, 'bot_id' => $bot_id])
        ->where('updated_at', '>=', $thirtyMinutesAgo)
        ->first();
    }
    
    public static function getById(int $id) {
        return ChatsModel::where(['id' => $id])->first();
    }
    
    public static function removeByNewCommand(int $chat_id, int $bot_id){
        $chats = ChatsModel::where(['chat_id' => $chat_id, 'bot_id' => $bot_id])->first();
        return $chats ? $chats->delete() : true;
    }

    public static function remove(int $id){
        $chats = ChatsModel::find($id);
        return $chats->delete();
    }

    public static function add(object $data) {
        
        $chat = new ChatsModel();
        $chat->chat_id = $data->chat_id;
        $chat->bot_id = $data->bot_id;
        $chat->last_message = $data->last_message;
        $chat->message_conversation = $data->message_conversation;

        if($chat->save()){
            return $chat->id;
        }else{
            return false;
        }
    }
 
    public static function edit(object $data) {
        return ChatsModel::where(['chat_id' => $data->chat_id, 'bot_id' => $data->bot_id])->update(['last_message' => $data->last_message]);
    }

    public static function setLastMessageBot(object $data) {
        return ChatsModel::where(['id' => $data->id])->update(['message_conversation' => $data->message_conversation]);
    }
 }
 