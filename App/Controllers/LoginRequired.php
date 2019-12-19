<?php 

namespace App\Controllers;

use System\Libs\BaseController;

use System\Helpers\Alert;

abstract class LoginRequired extends BaseController{

    protected function before(){
        
        $this->requireLogin();

    }

}


?>