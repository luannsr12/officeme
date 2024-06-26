<?php
namespace OfficeMe\Controllers\Global;

use OfficeMe\Model\UserModel;
 
class AuthController
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public function show($id): void
	{
		// The variable authenticated is set to true in the ApiVerification middleware class.
		response()->json([
            'authenticated' => request()->authenticated
        ]);
	}

    public function auth()
    {
         $data = input('data');
 
         if($data){
            $data = json_decode($data);
            $user = UserModel::getByUsername($data->username);
            if($user){

                $vPass = password_verify($data->password, $user->password);

                if($vPass){

                    $csrf_token = csrf_token();

                    $_SESSION['uid'] = $user->id;
                    $_SESSION['logged'] = true;
                    $_SESSION['CSRF_TOKEN'] = $csrf_token;

                    UserModel::setToken($csrf_token, $user->id);

                    response()->json([
                        'success' => true,
                        'message' => 'Logado com sucesso!'
                    ]);

                }else{
                    response()->json([
                        'success' => false,
                        'message' => 'Senha incorreto'
                    ]);
                }

            }else{
                response()->json([
                    'success' => false,
                    'message' => 'Usuário incorreto'
                ]);
            }
         }else{
            response()->json([
                'success' => false,
                'message' => 'Preencha todos os campos'
            ]);
         }
    }

}