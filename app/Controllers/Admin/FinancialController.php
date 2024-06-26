<?php

namespace OfficeMe\Controllers\Admin;

use
OfficeMe\Model\FinancialModel,
OfficeMe\Model\DataTablesModel,
Illuminate\Pagination\LengthAwarePaginator,
Illuminate\Http\Request,
Carbon\Carbon;

class FinancialController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct()
    {

    }

    public function get(int $fid)
    {
        try {

            if(!is_admin()){
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }


            if (!$fid) {
                response()->json([
                    'title' => 'Error',
                    'success' => false,
                    'message' => 'Informe o id da movimentação'
                ]);
            }

            if (!is_numeric($fid)) {
                response()->json([
                    'title' => 'Error',
                    'success' => false,
                    'message' => 'Informe o id da movimentação'
                ]);
            }

            $fin = FinancialModel::getById($fid);

            if ($fin) {
                response()->json([
                    'success' => true,
                    'data' => (object) [
                        'id' => $fin->id,
                        'value' => $fin->value,
                        'description' => $fin->description,
                        'type' => $fin->type,
                        'plan_id' => $fin->plan_id,
                        'created_at' => explode(' ', $fin->created_at)[0]
                    ]
                ]);
            } else {
                response()->json([
                    'title' => 'Error',
                    'success' => false,
                    'message' => 'Movimentação não localizada'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'title' => 'Error',
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function list()
    {

        if(!is_admin()){
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $columns = array(

            array(
                'db' => 'id',
                'dt' => 'multiple',
                'formatter' => function ($d, $row) {
                    return "<input data-id='" . $row['id'] . "' id='rowid_" . $row['id'] . "' class='switch' onclick='setRows(" . $row['id'] . ", event);' value='" . $row['id'] . "'  type='checkbox' />";
                },
            ),
            array(
                'db' => 'type',
                'dt' => 'type',
                'formatter' => function ($d, $row) {

                    switch ($row['type']) {
                        case 'deposit':
                            return '<span class="badge bg-gradient-success" ><i class="fa fa-arrow-up" ></i> Comissão</span>';
                            break;
                        case 'withdraw':
                            return '<span class="badge bg-gradient-danger" ><i class="fa fa-arrow-down" ></i> Resgate</span>';
                            break;
                        default:
                            return '<span class="badge bg-gradient-dark" >Desconhecido</span>';
                            break;
                    }

                }
            ),

            array(
                'db' => 'created_at',
                'dt' => 'date',
                'formatter' => function ($d, $row) {
                    return $row['created_at'];
                }
            ),

            array(
                'db' => 'description',
                'dt' => 'description',
                'formatter' => function ($d, $row) {
                    return $row['description'];
                }
            ),

            array(
                'db' => 'value',
                'dt' => 'value',
                'formatter' => function ($d, $row) {
                    return (float) $row['value'];
                }
            ),


            array(
                'db' => 'id',
                'dt' => 'opc',
                'formatter' => function ($d, $row) {
                    return '<div class="btn-group btn-more-customers" role="group">
                            <button id="btnOptFinancial" type="button" class="btn-sm mt-2 btn bg-gradient-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Opções
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnOptFinancial">
                                <a class="dropdown-item" href="javascript:modalEditFinancial(' . $row['id'] . ');" ><i class="fa fa-edit"></i>
                                    Editar </a>
                                <a class="dropdown-item" href="javascript:removeFinancial(' . $row['id'] . ');" ><i class="fa fa-trash"></i>
                                    Deletar</a>
                            </div>
                        </div>';
                }
            ),


            array('db' => 'id', 'dt' => 'id'),


        );


        $table = 'financial';

        // Table's primary key
        $primaryKey = 'id';

        $whereAll = "";

        if (!isset($_REQUEST['search'])) {
            $whereAll .= " id_user='" . get_uid() . "'";
        }

        if (isset($_REQUEST['search'])) {
            $value = $_REQUEST['search']['value'];
            if ($value == "") {
                $whereAll .= " id_user='" . get_uid() . "'";
            } else {
                $whereAll .= " id_user='" . get_uid() . "' AND (CONVERT(`id` USING utf8) LIKE '%{$value}%' OR CONVERT(`value` USING utf8) LIKE '%{$value}%' OR CONVERT(`description` USING utf8) LIKE '%{$value}%')";
            }
        }


        if (isset($_REQUEST['filter'])) {

            $filter = trim($_REQUEST['filter']);

            if (in_array($filter, ['deposit', 'withdraw'])) {

                switch ($filter) {
                    case 'deposit':
                        $whereAll .= " AND type = 'deposit'";
                        break;
                    case 'withdraw':
                        $whereAll .= " AND type = 'withdraw'";
                        break;
                    default:
                        # code...
                        break;
                }

            }

        }

        if (isset($_REQUEST['period'])) {

            $period = trim($_REQUEST['period']);

            if (in_array($period, ['last_week', 'this_month'])) {

                switch ($period) {
                    case 'last_week':
                        $whereAll .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
                        break;
                    case 'this_month':
                        $whereAll .= " AND ( YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW()) )";
                        break;
                    default:
                        # code...
                        break;
                }

            }
        }

        if (isset($_REQUEST['byDates'])) {

            $dates = trim($_REQUEST['byDates']);
            $dates = explode(',', $dates);

            if (is_array($dates)) {

                $fisrt_date = $dates[0];
                $after_date = $dates[1];

                if(validateDate($fisrt_date, 'Y-m-d') && validateDate($after_date, 'Y-m-d')){
                    $whereAll .= " AND ( DATE(created_at) BETWEEN '".$fisrt_date."' AND '".$after_date."' )";
                }

            }
        }
 

        $database = require 'config.php';

        $sql_details = array(
            'user' => $database['database']['user'],
            'pass' => $database['database']['pass'],
            'db' => $database['database']['name'],
            'host' => $database['database']['host']
        );

        $return = DataTablesModel::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll);

        echo json_encode($return, JSON_INVALID_UTF8_IGNORE);


    }


    public function delete_multiple()
    {
        try {

            if(!is_admin()){
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }

            $data = input('data');

            if ($data) {

                $removes = 0;

                foreach ($data['ids'] as $k => $fid) {

                    $financial = FinancialModel::getById($fid);

                    if ($financial) {

                        if (FinancialModel::remove($fid)) {
                            $removes = $removes + 1;
                        }

                    } else {
                        response()->json([
                            'title' => 'Error!',
                            'success' => false,
                            'message' => 'Desculpe, tente novamente mais tarde.'
                        ]);
                        break;
                    }

                }

                response()->json([
                    'title' => 'Removido!',
                    'success' => true,
                    'message' => '(' . $removes . ') movimentações removidas.'
                ]);

            } else {
                response()->json([
                    'title' => 'Error!',
                    'success' => false,
                    'message' => 'Nenhuma movimentação informada'
                ]);
            }

        } catch (\Exception $e) {
            response()->json([
                'title' => 'Error!',
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete(int $fid)
    {

        if(!is_admin()){
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $financial = FinancialModel::getById($fid);
        if ($financial) {
            if (FinancialModel::remove($fid)) {
                response()->json([
                    'title' => 'Removido!',
                    'success' => true,
                    'message' => 'Movimentação removida com sucesso!'
                ]);
            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Movimentação não removida'
                ]);
            }
        } else {
            response()->json([
                'title' => 'Erro!',
                'success' => false,
                'message' => 'Movimentação não localizada'
            ]);
        }
    }

    public function edit(int $fid)
    {

        try {

            if(!is_admin()){
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }

            $data = input('data');

            if ($data) {

                $data = (object) $data;

                $data->id = $fid;

                if (!isset($data->value, $data->type, $data->date)) {
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Preencha todos os campos'
                    ]);
                }

                $edit = FinancialModel::edit($data);
                if ($edit) {

                    response()->json([
                        'title' => 'Editado!',
                        'success' => true,
                        'message' => 'Movimentação editada com sucesso!'
                    ]);
                }
            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Não foi possível editar a movimentação.'
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

    public function add()
    {
        try {

            if(!is_admin()){
                return response()->json(['success' => false, 'message' => 'Unauthorized']);
            }
            
            $data = input('data');

            if ($data) {

                $data = (object) $data;

                if (!isset($data->value, $data->type, $data->date)) {
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Preencha todos os campos'
                    ]);
                }

                if ($data->value < 0 || $data->value == 0) {
                    response()->json([
                        'title' => 'Campos vazios',
                        'success' => false,
                        'message' => 'Por favor, informe um valor maior que zero.'
                    ]);
                }

                if (strlen($data->description) > 255) {
                    response()->json([
                        'title' => 'Muitos caracteres',
                        'success' => false,
                        'message' => 'Em detalhes use no máximo 255 caracteres.'
                    ]);
                }


                $add = FinancialModel::add($data);
                if ($add) {

                    response()->json([
                        'title' => 'Adicionado!',
                        'success' => true,
                        'message' => 'Movimentação registrada com sucesso.'
                    ]);
                }
            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Não foi possível registrar a movimentação.'
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