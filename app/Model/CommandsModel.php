<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;
 
 final class CommandsModel extends Model
 {
    protected $table = 'commands';

    protected $primaryKey = 'id';

    public static function getById(string $cid) {
        return CommandsModel::where(['id' => $cid])->first();
    }

    public static function getByCommand(string $command, int $bot_id) {
        return CommandsModel::where(['command' => $command, 'bot_id' => $bot_id])->first();
    }

    public static function getByBot(string $apikey) {
        return CommandsModel::where(['apikey' => $apikey])->first();
    }

    
    public static function getAll(int $bot_id) {
        $commands = CommandsModel::where(['bot_id' => $bot_id])->orderBy('id', 'ASC')->get();
        return $commands;
    }

    public static function remove(int $id){
        $commands = CommandsModel::find($id);
        return $commands->delete();
    }

    public static function add(object $data) {
        
        $commands = new CommandsModel();
        $commands->bot_id = $data->bot_id;
        $commands->command = $data->command;
        $commands->description = $data->description;
        $commands->response = $data->response;
        $commands->type = $data->type;
        $commands->is_menu = $data->is_menu;

        if($commands->save()){
            return $commands->id;
        }else{
            return false;
        }
    }
  
    public static function editButtons(object $data) {
        return CommandsModel::where(['id' => $data->id])
        ->update([
            'buttons' => $data->buttons
        ]);
      
    }

    public static function edit(object $data) {
        return CommandsModel::where(['id' => $data->id])
        ->update([
            'bot_id' => $data->bot_id, 
            'command' => $data->command, 
            'description' => $data->description,
            'response' => $data->response, 
            'type' => $data->type,
            'is_menu' => $data->is_menu
        ]);
      
    }

 }
 