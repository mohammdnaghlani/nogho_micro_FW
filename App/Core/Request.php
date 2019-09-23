<?php
namespace App\Core ;

class Request
{
    public $user_agent;
    public $user_ip;
    public $referer;
    public $current_uri;
    public $method;
    public $server_ip;
    public $params;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->referer = $this->get_referer();
        $this->user_ip = $_SERVER['REMOTE_ADDR'];
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->server_ip = $_SERVER['SERVER_ADDR'];
        $this->params = $this->get_params();
        $this->current_uri = $this->get_current_uri();
        $this->method = $this->get_current_uri_method();
    }
    /**
     * get_current_uri method . 
     * this method for give current uri in $_SERVER global varable.
     */
    private function get_current_uri()
    {
        $current_uri = explode('?' , $_SERVER['REQUEST_URI']) ;
        return rtrim($current_uri[0] , '/');
    }
    /**
     * get_current_uri_method . 
     * this method for give method and lower case method .
     */
    private function get_current_uri_method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    /**
     * get_referer method . 
     * this method for give referer url .
     */
    private function get_referer()
    {
        return $_SERVER['HTTP_REFERER'] ?? null ;
    }
    /**
     * get_params method
     * this method set all params in $params property.
     */
    private function get_params()
    {
        return $_REQUEST ;
    }
    /**
     * get_param method
     * this method return value using a key
     */
    public function get_param($key)
    {
        return $this->params[$key];
    }
    public function __get($key)
    {
        return $this->$key = $this->get_param($key);
    }
    public function is_in($allowed_method)
    {
        return in_array($this->method , $allowed_method);
    }
    public function is_ajax()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {    
            return true ;
        }
        return false ;
    }
}