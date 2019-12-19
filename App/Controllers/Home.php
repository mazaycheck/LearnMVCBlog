<?php 

namespace App\Controllers;

use System\Libs\View;

use App\Models\{User, Post};

use System\Helpers\Alert;


use System\Libs\BaseController;

class Home extends BaseController{

    public function __construct()
    {
        //echo "Hello from Home class <br>";
    }

    public function indexAction(){

        $postModelObj = new Post;
        $user = $_SESSION['user'] ?? '';
        $data = $postModelObj->getAllPostsAndComments();
        $count = $postModelObj->getPostCount();


        View::renderTemplate("Posts/index.html", [ 
        'posts' => $data,
        'alert' => Alert::getAlertMessage(),
        'count' => $count,
        'user'  => $user
        ]);
    }
 

}

?>