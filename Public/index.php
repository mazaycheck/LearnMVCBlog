<?php 
session_start();
require_once  dirname(__DIR__) . '/vendor/autoload.php';

spl_autoload_register(function($className){
    $file = dirname(__DIR__) . '/' . str_replace('\\', '/' , $className) . ".php";
    if(file_exists($file)){
        require_once($file);
    }
});

;

error_reporting(E_ALL);
set_error_handler('System\Helpers\Errors::errorHandler');
set_exception_handler('System\Helpers\Errors::exceptionHandler');

$url = $_SERVER['QUERY_STRING'];

$r1 = new \System\Libs\Router();

$r1->executeUrl($url);

?>