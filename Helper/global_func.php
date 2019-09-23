<?php
/**
 * inc_from_base function
 * this function is for read file path root .
 * @param = string File name or directory\fileName.
 */
function inc_from_base($file_name)
{
    $file_path =  BASE_PATH . $file_name ;
    if(file_exists($file_path) && is_readable($file_path)){
        return include $file_path ;
    }
    return false ;
}
/**
 * inc_admin_partials_path function
 * this function is for read file from path admin/partials path
 * @param = string File name or directory\fileName.
 */
function inc_admin_partials_path($file_name)
{
    return inc_from_base('Views' . D_S . 'admin' .D_S .'partials' . D_S . $file_name . '.php');
}
/**
 * remove_empty_member function
 * this function for remove empty value in array .
 * note : array not associative .
 * @param = array() 
 */
function remove_empty_member($array)
{
    return array_filter($array , function($a){
        if($a !== false) return $a ;
    }) ;
}
/**
 * site_url function
 * this function create site url
 * note : url created by base uri => http://yourDomain.com.
 * @param = string file name or directory/name.
 */
function site_url($file_name = null)
{
    return BASE_URI . $file_name ;
}
/**
 * site_url function
 * this function create site url
 * note : url created by base uri => http://yourDomain.com/assets/$file_name.
 * note :  do'not use the word ASSETS in this function , The word is defined there in .
 * @param = string file name or directory/name.
 */
function get_assets($file_name){
    return site_url('assets/' . $file_name);
}
/**
 * site_url function
 * this function create site url
 * note : url created by base uri => http://yourDomain.com/$dir/assets/$file_name.
 * note :  do'not use the word ASSETS in this function , The word is defined there in .
 * @param = string custom directory.
 * @param = string file name or directory/name.
 */
function get_assets_from_dir( $base_dir , $file_name){
    return site_url($base_dir .'/assets/' . $file_name);
}
/**
 * site_url function
 * this function create site url
 * note : url created by base uri => http://yourDomain.com/Views/admin/assets/$file_name.
 * note :  do'not use the word ASSETS in this function , The word is defined there in .
 * @param = string file name or directory/name.
 */
function get_assets_admin($file_name)
{
    return site_url('Views/admin/assets/' . $file_name);  
}