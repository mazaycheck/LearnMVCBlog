<?php 

namespace System\Libs;

use System\Helpers\Alert;

class BaseController{

    protected $params = [];

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function __call($name, $arguments)
    {
        $method = $name . 'Action';
        if(method_exists($this, $method)){
            if($this->before()!== false){
                call_user_func_array([$this, $method], $arguments);
                $this->after();
            }
        }
        else{
            echo "Method Does not exists in controller" . get_class($this);
        }
    }


    protected function before(){
      
    }

    protected function after(){
       
    }

    public static function redirect($url){
        header("Location: /" . ltrim($url, '/'), true, 303);
        exit();
    }

    public static function loginRequired(){
        return isset($_SESSION['user']);
    }

    public static function rememberUrl(){
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    public static function getRedirectdUrl(){
        return $_SESSION['return_to'] ?? '/';
    }

    public function requireLogin(){
        BaseController::rememberUrl();
        if(!\System\Libs\Auth::getUser())
        {
            new Alert("Login required!", "warning");
            self::redirect("account/login");
        }
    }


}

?>