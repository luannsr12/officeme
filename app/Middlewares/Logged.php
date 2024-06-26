<?php
namespace OfficeMe\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use OfficeMe\Model\UserModel;

class Logged implements IMiddleware
{
	public function handle(Request $request): void
	{
		// Do authentication
		$request->authenticated = UserModel::isLogged();

		if (!$request->authenticated && !$request->getUrl()->contains('/login')) {
			 redirect(APP_URL . '/login');
		}
 

	}

}