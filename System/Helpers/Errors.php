<?php 


namespace System\Helpers;



class Errors{


    


    public static function errorHandler( $er_level, $er_message, $er_file, $er_line){
        throw new \ErrorException($er_message, 0, $er_level , $er_file, $er_line);
    }

    public static function exceptionHandler($exception){
        
        $message = self::createErrorLogEntry($exception);        
        if(\System\Config::SHOW_ERRORS)
            echo $message;
        else
            self::writeErrorToFile($message);
        
    }

    public static function createErrorLogEntry($exception){
        $message =<<<HERE
        {$exception->getMessage()}
        In File : {$exception->getFile()}
        Line : {$exception->getLine()}
        Trace :
        {$exception->getTraceAsString()}
        ********************************
        HERE;
        return $message;
    }

    public static function writeErrorToFile($message){
        ini_set('error_log', dirname(__DIR__) . "/logs/" . date("Y-m-d") . ".txt");
        error_log($message);
    }


}


?>