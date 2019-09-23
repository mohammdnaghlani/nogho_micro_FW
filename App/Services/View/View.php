<?php
namespace App\Services\View ;
/**
 * View Class
 * all display requests are handled by this class.
 * all methods are static and public.
 * @method load_from_base 
 * @method load_theme 
 * @method Load_admin 
 */
class View
{
    /**
     * load_from_base method.
     * this a method to load information Views from the root of the framework.
     * @param = string path file or directory.file
     * @param = array() data and information in the from are associative array .
     * @param = string name or directory/name of layout.
     * note : layout information should be in a directory called layout (Views/layout)
     */
    public static function load_from_base($path , $data = [] , $layout = null)
    {
        $path = str_replace('.' , D_S , $path) ;
        $base_path = BASE_PATH . 'Views' .D_S . $path . '.php' ;
        if(!file_exists($base_path)){
               self::load_from_base('error.404');
               die();
        }
        
        if(!is_readable($base_path)){ //TODO : this if not best code .
            self::load_from_base('error.403');
            die();
        }
        
        ob_start();
        extract($data);
        include_once  $base_path;
        $view = ob_get_clean();
        if(is_null($layout)){
            echo $view ;
        }else{
            $layout_path = BASE_PATH .  'Views' .D_S . 'layout' .D_S . $layout .'.php';
            include_once $layout_path ;
        }
    }
    /**
     * load_theme method.
     * this a method to load information  from the Views/ThemeName directory of the framework.
     * note : 
     * @param = string path file or directory.file
     * @param = array() data and information in the from are associative array .
     * @param = string name or directory/name of layout.
     * note : layout information should be in a directory called layout (Views/layout)
     */
    public static function load_theme($path , $data = [] , $layout = null)
    {
        $path = ACTIVE_THEME . '.' .$path ;
        self::load_from_base($path , $data , $layout);

    }
    /**
     * load_admin method.
     * this a method to load admin information  from the Views/admin directory of the framework.
     * @param = string path file or directory.file
     * @param = array() data and information in the from are associative array .
     * @param = string name or directory/name of layout.
     * note : layout information should be in a directory called layout (Views/layout)
     */
    public static function load_admin($path , $data = [] , $layout = null)
    {
        $path =  'admin.' .$path ;
        self::load_from_base($path , $data , $layout);

    }
}