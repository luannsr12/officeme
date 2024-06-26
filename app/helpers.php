<?php

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

use OfficeMe\Model\UserModel;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Container\Container;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Compilers\BladeCompiler;
use OfficeMe\Model\OptionsModel;
use Carbon\Carbon;

/**
 * Get url for a route by using either name/alias, class or method name.
 *
 * The name parameter supports the following values:
 * - Route name
 * - Controller/resource name (with or without method)
 * - Controller class name
 *
 * When searching for controller/resource by name, you can use this syntax "route.name@method".
 * You can also use the same syntax when searching for a specific controller-class "MyController@home".
 * If no arguments is specified, it will return the url for the current loaded route.
 *
 * @param string|null $name
 * @param string|array|null $parameters
 * @param array|null $getParams
 * @return \Pecee\Http\Url
 * @throws \InvalidArgumentException
 */
function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
{
    return Router::getUrl($name, $parameters, $getParams);
}

 
function is_expire_timestamp($timestamp){
    $currentTimestamp = Carbon::now(TIME_ZONE)->timestamp;
    if($currentTimestamp > $timestamp){
        return true;
    }else{
        return false;
    }
}

/**
 * @return \Pecee\Http\Response
 */
function response(): Response
{
    return Router::response();
}

/**
 * @return \Pecee\Http\Request
 */
function request(): Request
{
    return Router::request();
}

function get_uid(){
    if(isset($_SESSION['uid'])){
        return $_SESSION['uid'];
    }else{
        return NULL;
    }
}

function is_admin(){
    if(get_uid()){
        $user = UserModel::getById(get_uid());
        if(!$user){
            return false;
        }
        if($user->admin > 0){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
 * Get input class
 * @param string|null $index Parameter index name
 * @param string|mixed|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return \Pecee\Http\Input\InputHandler|array|string|null
 */
function input($index = null, $defaultValue = null, ...$methods)
{
    if ($index !== null) {
        return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
    }

    return request()->getInputHandler();
}

/**
 * @param string $url
 * @param int|null $code
 */
function redirect(string $url, ?int $code = null): void
{
    if ($code !== null) {
        response()->httpCode($code);
    }

    response()->redirect($url);
}

/**
 * Get current csrf-token
 * @return string|null
 */
function csrf_token(): ?string
{
    $baseVerifier = Router::router()->getCsrfVerifier();
    if ($baseVerifier !== null) {
        return $baseVerifier->getTokenProvider()->getToken();
    }

    return null;
}



function option($name){
   try {
     $getOpt = OptionsModel::getByName($name);
    if($getOpt){
        echo $getOpt->content;
    }else{
        echo '';
    }
   } catch (\Exception $e) {
      echo '';
   }
}

function view(string $viewName, array $data = [])
{

    $container = new Container();

    $filesystem = new Filesystem();

    $viewFinder = new FileViewFinder($filesystem, [PATH.'/public/views']);

    $resolver = new EngineResolver();
    $resolver->register('blade', function () use ($filesystem) {
        return new CompilerEngine(new BladeCompiler($filesystem, PATH.'/public/cache'));
    });
    $resolver->register('php', function () use ($filesystem) {
        return new PhpEngine($filesystem);
    });

    $dispatcher = new Dispatcher($container);

    $viewFactory = new Factory($resolver, $viewFinder, $dispatcher);

    $viewFactory->addExtension('blade.php', 'blade');

    return $viewFactory->make($viewName, $data)->render();

}