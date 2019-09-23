<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'constants.php';
require_once BASE_PATH . 'vendor' . D_S . 'autoload.php';
require_once BASE_PATH . 'Helper' . D_S . 'global_func.php';
if(IS_DEV_MODE){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}