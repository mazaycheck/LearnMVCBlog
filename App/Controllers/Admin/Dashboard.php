<?php 

namespace App\Controllers\Admin;

use System\Libs\View;

use System\Libs\Model;

use System\Libs\BaseController;

use App\Controllers\LoginRequired;

use App\Models\{Post, Category, User};

class Dashboard extends LoginRequired{



    public function __construct()
    {
        

    }




    public function indexAction(){
        
        //\System\Libs\Auth::requiredAccessLevel(3);
        $dataTables = ['posts', 'users', 'categories', 'comments'];
        $stats = Model::getStats($dataTables);
        View::renderTemplate('Admin/index.html', ['stats' => $stats]);


    }

}

?>