<?php 

 namespace OfficeMe\Model;

 use \Illuminate\Database\Eloquent\Model;

 final class FinancialModel extends Model
 {
    protected $table = 'financial';

    protected $primaryKey = 'id';

    public static function getById(string $fid) {
        return FinancialModel::where(['id' => $fid, 'id_user' => get_uid()])->first();
    }
  
    
    public static function getAll() {
        $financials = FinancialModel::where(['id_user' => get_uid()])->get();
        return $financials;
    }


    public static function getByMY(int $m = 1, int $y = 2024)
    {

        return FinancialModel::where('id_user', get_uid())
            ->whereYear('created_at', $y)
            ->whereMonth('created_at', $m)
            ->get();

    }

    public static function remove(int $id){
        $financial = FinancialModel::where('id', $id)
                                    ->where('id_user', get_uid())
                                    ->first();
    
        if($financial){
            return $financial->delete();
        }
    
        return false;
    }
    

    public static function add(object $data) {
        
        $financial              = new FinancialModel();
        $financial->id_user     = get_uid();
        $financial->value       = $data->value;
        $financial->description = $data->description;
        $financial->type        = $data->type;
        $financial->plan_id     = isset($data->plan_id) ? $data->plan_id : NULL;
        isset($data->date) ? $financial->created_at = $data->date : NULL;

        if($financial->save()){
            return true;
        }else{
            return false;
        }

    }

    public static function edit(object $data) {

        $data_up = [
            'value' => $data->value, 
            'description' => $data->description, 
            'type' => $data->type,
            'plan_id' => isset($data->plan_id) ? $data->plan_id : NULL
        ];

        isset($data->date) ? $data_up['created_at'] = $data->date : NULL;

        return FinancialModel::where(['id' => $data->id, 'id_user' => get_uid()])->update($data_up);
    }
  

    
 }
 