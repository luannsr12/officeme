<?php
namespace OfficeMe\Controllers\Admin;

use OfficeMe\Model\UserModel;
use OfficeMe\Model\SellerModel;
 
class SettingsController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */

    public function __construct(){
     
    }

 
    public function saveprofile(){

        try {

            $csrf_token = csrf_token();
            $user_details = UserModel::getByToken($csrf_token);

            if(!$user_details){
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Faça login para editar seus dados'
                ]);
            }

            $username = input('username');
            $password = input('password');

            if ($username) {

                if($username == ""){
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Preencha todos os campos obrigatórios'
                    ]);
                } 

                $editPassword = $password != "" ? UserModel::editPassword($username, $user_details->id) : true;

                if($password != "" && !$editPassword){
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Não foi possível alterar sua senha'
                    ]);
                }

                $editUsername = UserModel::editUsername($username, $user_details->id);

                if ($editUsername || $editPassword) {

                    response()->json([
                        'title' => 'Editado!',
                        'success' => true,
                        'message' => 'Dados editados com sucesso!'
                    ]);

                }


            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Não foi possível editar seus dados.'
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
            $data = input('data');

            if ($data) {
                $data = json_decode($data);

                if(!isset($data->list_id)){
                    response()->json([
                        'title' => 'Erro!',
                        'success' => false,
                        'message' => 'Informe a lista na qual o vendedor pertence'
                    ]);
                }else{
                    if((int)$data->list_id < 1){
                        response()->json([
                            'title' => 'Erro!',
                            'success' => false,
                            'message' => 'Informe a lista na qual o vendedor pertence'
                        ]);
                    }
                }


                $add = SellerModel::add($data);
                if ($add) {

                    response()->json([
                        'title' => 'Adicionado!',
                        'success' => true,
                        'message' => 'Vendedor adicionado com sucesso!'
                    ]);
                }
            } else {
                response()->json([
                    'title' => 'Erro!',
                    'success' => false,
                    'message' => 'Não foi possível adicionar o vendedor.'
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