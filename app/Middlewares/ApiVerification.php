<?php
namespace OfficeMe\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use OfficeMe\Model\UserModel;

class ApiVerification implements IMiddleware
{
	public function handle(Request $request): void
	{
		// Do authentication
		$request->authenticated = UserModel::isLogged();

		if (!$request->authenticated) {
			response()->json([
				'success' => false,
				'message' => 'Not authenticated'
			]);
			exit();
		}

	}

}