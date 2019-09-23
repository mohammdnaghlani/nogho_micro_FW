<?php
namespace App\Services\Router ;

use App\Core\Request;

class Router
{
    const BaseController = 'App\\Controllers\\';
    const BaseMiddleware = 'App\\Middlewares\\';
    /**
     * important Router method .
     * this method run and start all request from web app . 
     */
    public static function start()
    {
        $request = new Request ;
        $current_uri = $request->current_uri;
        if(!self::exists_rout($current_uri)){
            header('HTTP/1.0 404 Not Found');
            die('404');
        }
        $allowed_method = self::get_allowed_method_this_rout($current_uri);
        if(!$request->is_in($allowed_method)){
            header('HTTP/1.0 403 Forbidden');
            die('403');
        }
        if(self::has_middleware($current_uri)){
            $middlewares = self::get_middlewares($current_uri);
           foreach($middlewares as $middleware){
               $middleware = self::BaseMiddleware . $middleware ;
               if(!class_exists($middleware) && IS_DEV_MODE ){
                   die("Error : Middleware {$middleware} not exists .");
               }
               $middleware_obj = new $middleware ;
               $middleware_obj->handel($request);
           }
        }
        list($controller , $method) = self::get_target_current_uri($current_uri);
        $controller = self::BaseController . $controller ;
        if(!class_exists($controller) && IS_DEV_MODE)
        {
            die("Error : Class {$controller} Not exists in path .");
        }
        $controller_obj = new $controller;
        if(!method_exists($controller_obj , $method) && IS_DEV_MODE){
            die("Error : Method {$method} Not exists in Class {$controller} ."); 
        }
        $controller_obj->$method($request);
    }
    private static function exists_rout($current_uri)
    {
        $routs = array_keys(self::get_all_routs());
        return in_array($current_uri , $routs);
    }
    /**
     * get_all_routs() method. 
     * this method for give all routs in Routes\web.php address.
     */
    private static function get_all_routs()
    {
        return  inc_from_base('Routes\web.php');
    }
    /**
     * get_allowed_method_this_rout() method.
     * this method for give allowed method in Routes/web.php
     * @param = Current uri 
     */
    private static function get_allowed_method_this_rout($current_uri)
    {
        $routs = self::get_all_routs();
        $methods = $routs[$current_uri]['method'] ?? 'get';
        $allowed_method = explode('|' , $methods);
        return $allowed_method ;
    }
    /**
     * has_middleware() method .
     * this method checked exists middleware and return all middleware.
     * @param = Current uri .
     */
    private static function has_middleware($current_uri)
    {
        $routs = self::get_all_routs();
        $middleware = $routs[$current_uri]['middleware'] ?? null ;
        $middleware .= GLOBAL_MIDDLE ;
        return $middleware ;
    }
    /**
     * get_middlewares() method .
     * this method give all middlewares in Routes/web.php .and explode by |(pipe) delimiter.
     * @param = Current uri 
     */
    private static function get_middlewares($current_uri)
    {
        $middlewares =explode('|' , self::has_middleware($current_uri)) ;
        return remove_empty_member($middlewares);
        
    }
    /**
     * get_target_current_uri() method .
     * this method give target key in Routes/web.php .and explode by @ delimiter.
     * return controller and method.
     * @param = Current uri 
     */
    private static function get_target_current_uri($current_uri)
    {
        $routs = self::get_all_routs();
        $target = explode('@' , $routs[$current_uri]['target']);  
        return $target;
    }
}