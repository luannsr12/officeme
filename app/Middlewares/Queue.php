<?php
namespace OfficeMe\Middlewares;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class Queue implements IMiddleware
{
	public function handle(Request $request): void
	{
        
        $header  = request()->getHeaders();

        $request->authorization = false;

        if(isset($header['http_queue_token'])){
            $queue_token = $header['http_queue_token'];
            if($queue_token == TOKEN_QUEUE){
                $request->authorization = true;
            }
        }

        if(!$request->authorization){
            response()->json([
				'success' => false,
				'message' => 'Not authenticated'
			]);
			exit();
        }


	}

}