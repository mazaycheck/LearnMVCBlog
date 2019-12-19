<?php 

namespace System\Helpers;

class Alert{

    public function __construct($message, $class = 'success')
    {
        
        $alertText =<<<HERE
        <div class="alert alert-$class my-2">
        $message
        </div>
        HERE;
        $_SESSION['alert'] = $alertText;
    }


    public static function getAlertMessage(){
  
        if(isset($_SESSION['alert'])){
            $message = $_SESSION['alert'];
            unset($_SESSION['alert']);
            return $message;
        }else return "";
    }

}

?>