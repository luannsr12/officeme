<?php

namespace OfficeMe\Controllers\Admin;

use
OfficeMe\Model\CustomersModel,
OfficeMe\Model\DataTablesModel,
Illuminate\Pagination\LengthAwarePaginator,
Illuminate\Http\Request,
Carbon\Carbon;

class CustomersController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct()
    {

    }

    public function list()
    {

        $columns = array(

            array('db' => 'id', 'dt' => 'id'),

            array(
                'db' => 'id',
                'dt' => 'nome',
                'formatter' => function ($d, $row) {


                    //$query1 = Conn::getInstance()->query("SELECT * FROM `clientes` WHERE id='".$row['id']."' LIMIT 1");
                    $user = CustomersModel::getById($row['id']);


                    //  $query = Conn::getInstance()->query("SELECT * FROM `categorias_cliente` WHERE id='".$user['categoria']."' ");
                    //  $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                    //  if( count($fetch)>0 ){
                    //      $query = Conn::getInstance()->query("SELECT * FROM `categorias_cliente` WHERE id='".$user['categoria']."' ");
                    //      $cate = $query->fetch(PDO::FETCH_OBJ);
                    //  }else{
                    $cate = false;
                    // }
        
                    $cores['danger'] = "#ec3541";
                    $cores['primary'] = "#0048ff";
                    $cores['secondary'] = "#dddddd";
                    $cores['info'] = "#2d87ce";
                    $cores['warning'] = "#fb9100";
                    $cores['marrom'] = "#6d2b19";
                    $cores['green'] = "#2bad18";
                    $cores['roxo'] = "#7922ff";
                    $cores['verde2'] = "#04fbb1";

                    if (isset ($cate)) {
                        $back = "#04fbb1";
                    } else {
                        $back = "#04fbb1";
                    }


                    $nome_cli = substr($user->nome, 0, 15);

                    if (strlen($user->nome) > 15) {
                        $nome_cli .= '...';
                    }

                    $id_externo = "";

                    if ($user->identificador_externo != NULL && strlen($user->identificador_externo) > 0) {
                        $id_externo = "<br /><small style='font-size:10px;color:gray;position: absolute;bottom: 2px;' >#" . $user->identificador_externo . "</small>";
                    }

                    $iconAlert = "";

                    if ($user->alert != "" && $user->alert != NULL) {
                        $iconAlert = "<img data-info='" . $user->alert . "' class='notbottom info_extra' style='width: 15px;top: -2px;left: 3px;position: relative;' src='http://gestorlite.com/painel-gestor/img/icon/warning-icon.png' /> ";
                    }


                    return "<span style='border-bottom: 2px solid " . $back . ";' >" . $nome_cli . $iconAlert . " " . $id_externo . " </span>";


                }
            ),

            array(
                'db' => 'email',
                'dt' => 'email',
                'formatter' => function ($d, $row) {


                    if ($row['email'] == "" || $row['email'] == NULL) {
                        $email_cli = '[Sem email]';
                        $title = "Sem email";
                    } else {
                        $email_cli = substr($row['email'], 0, 25);
                        $title = $row['email'];
                        if (strlen($row['email']) > 25) {
                            $email_cli .= '...';
                        }

                    }

                    return '<span title="' . $title . '" >' . $email_cli . '</span>';
                }
            ),
            array(
                'db' => 'telefone',
                'dt' => 'whatsapp',
                'formatter' => function ($d, $row) {

                    return "<a href=\"http://wa.me/" . $row['telefone'] . "\" target=\"_blank\" > <i class='fas fas-whatsapp' ></i> " . $row['telefone'] . "</a>";

                }
            ),

            array(
                'db' => 'id',
                'dt' => 'plano',
                'formatter' => function ($d, $row) {

                    //$query1 = Conn::getInstance()->query("SELECT * FROM `clientes` WHERE id='".$row['id']."' LIMIT 1");
                    $user = CustomersModel::getById($row['id']);

                    //   $query = Conn::getInstance()->query("SELECT * FROM `planos` WHERE id='".$user['id_plano']."' ");
                    //   $fetch = $query->fetchAll(PDO::FETCH_OBJ);
                    //   if( count($fetch)>0 ){
                    //      $query = Conn::getInstance()->query("SELECT * FROM `planos` WHERE id='".$user['id_plano']."' ");
                    //      $plano = $query->fetch(PDO::FETCH_OBJ);
                    //   }else{
                    $plano = false;
                    //}
        
                    $screens = ' <span style="font-size:11px;" > ( <i class="fa fa-television" aria-hidden="true"></i> ' . $user->screens . ') <span>';


                    if ($plano) {
                        return $plano->nome . $screens;
                    } else {
                        return "Não possui";
                    }
                }
            ),

          

            array(
                'db' => 'id',
                'dt' => 'opc',
                'formatter' => function ($d, $row) {

                    return '<button class="btn btn-sm bg-gradient-primary" onclick="options_cliente(' . $row['id'] . ');" >Opções</button>';

                }
            )




        );


        $table = 'customers';

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
                $whereAll .= " id_user='" . get_uid() . "' AND (CONVERT(`id` USING utf8) LIKE '%{$value}%' OR CONVERT(`nome` USING utf8) LIKE '%{$value}%' OR CONVERT(`email` USING utf8) LIKE '%{$value}%' OR CONVERT(`telefone` USING utf8) LIKE '%{$value}%' OR CONVERT(`vencimento` USING utf8) LIKE '%{$value}%' OR CONVERT(`identificador_externo` USING utf8) LIKE '%{$value}%')";
            }
        }


        if (isset($_REQUEST['filter'])) {

            $filter = trim($_REQUEST['filter']);

            if (in_array($filter, ['actives', 'disabled', 'defaulters'])) {

                switch ($filter) {
                    case 'actives':
                        $whereAll .= " AND (DATE(vencimento) >= CURDATE())";
                        break;
                    case 'disabled':
                        $whereAll .= " AND (DATE(vencimento) < DATE_SUB(CURDATE(), INTERVAL 3 MONTH))";
                        break;
                    case 'defaulters':
                        $whereAll .= " AND (DATE(vencimento) < CURDATE() AND DATE(vencimento) >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH))";
                        break;
                    case 'new':
                        $whereAll .= " AND (DATE(created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 DAY) AND CURDATE())";
                        break;
                    case 'with_alert':
                        $whereAll .= " AND (alert IS NOT NULL AND alert <> '')";
                        break;
                    default:
                        # code...
                        break;
                }

            }

        }


        if (isset($_REQUEST['condition'])) {

            $condition = trim($_REQUEST['condition']);

            if (in_array($condition, ['new'])) {

                switch ($condition) {
                    case 'new':
                        $whereAll .= " AND (DATE(created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 DAY) AND CURDATE())";
                        break;
                    default:
                        # code...
                        break;
                }
            }

        }

        if (isset($_REQUEST['extra'])) {

            $extra = trim($_REQUEST['extra']);

            if (in_array($extra, ['with_alert'])) {
                switch ($extra) {
                    case 'with_alert':
                        $whereAll .= " AND (alert IS NOT NULL AND alert <> '')";
                        break;
                    default:
                        # code...
                        break;
                }
            }

        }

        if (isset($_GET['server'])) {
            if (is_numeric($_GET['server'])) {
                $whereAll .= " AND server_id='" . $_GET['server'] . "'";
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





}