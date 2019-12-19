<?php 

namespace App\Controllers\Admin;

use System\Libs\View;
use App\Models\{Post, Category, User};


use System\Libs\BaseController;
use App\Controllers\LoginRequired;
use System\Helpers\Alert;

class ManagePosts extends LoginRequired{

    private $postModel;



    public function __construct()
    {
        $this->postModel = new Post;
 
      
    }




    public function indexAction(){
        $postData = $this->postModel->getAllPosts();
        for ($i=0; $i < count($postData); $i++) { 
            $postData[$i]['authorName'] = $this->postModel->getAuthorById($postData[$i]['id']);
        }
        View::renderTemplate('Admin/Posts/index.html', ['posts' => $postData]);
    }

    public function addnewAction(){

        if(isset($_POST['submit'])){
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            $data = $_POST;
            $title = $data['title'];
            $text = $data['editor1'];
            echo '<pre>';
            print_r(nl2br($text));
            echo '</pre>';
            
       
            $author_id = $data['author'];
            $category_id = $data['category'];
            $this->postModel->newPost($title, $author_id, $text, $category_id);
        }

        $categories = Category::getCategoryList();
        $authors = User::getUserList();
        View::renderTemplate('Admin/Posts/addnewpostform.html', ['categories' => $categories, 'authors' => $authors]);
    }

    public function deleteAction($id){

        $this->postModel->deletePost($id);
        new Alert('Post Deleted!', 'danger');
        header("Location: /admin/manageposts");

    }

    public function updateAction($id){
        if(isset($_POST['submit'])){
            if($this->updatePost($id,$_POST))
            header("Location: /admin/manageposts");

        }

        $data = $this->postModel->getSinglePost($id);
        $categories = Category::getCategoryList();
        $authors = User::getUserList();
        View::renderTemplate('Admin/Posts/addnewpostform.html', ['categories' => $categories, 'authors' => $authors, 'postdata' => $data]);        
    }


    public function updatePost($id,$args){
        extract($args);

        return $this->postModel->updatePost($id,$title, $author, $editor1, $category) > 0;
    }

    public function viewsinglepostAction($id){
        $post = $this->postModel->getSinglePost($id);
        View::renderTemplate('Admin/Posts/singlePost.html', ['post' => $post]);      
    }
}

?>