<?php 

namespace App\Controllers\Admin;

use App\Models\Category;

use System\Libs\{View, BaseController};



class Categories extends BaseController{

    private $catModel;

    public function __construct()
    {
        $this->catModel = new Category;
    }


    public function before(){

        $this->requireLogin();
        
    }

    public function indexAction(){
        if(isset($_POST['submit'])){
            $cleanData = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $categoryName = $cleanData['category'];
            $this->catModel->createCategory($categoryName);
            header("Location: /admin/categories");
        }

       
        $data = $this->catModel->getCategoryList();

        View::renderTemplate("Admin\Categories\index.html", ['categories' => $data]);
    }

    public function deleteAction($id){
        $this->catModel->deleteCategory($id);
        header("Location: /admin/categories");
    }
}

?>