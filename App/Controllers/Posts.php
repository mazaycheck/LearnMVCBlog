<?php 

// namespace App\Controllers;

// use System\Libs\View;

// use App\Models\Post as postModelObj;

// use System\Helpers\Alert;

// class Posts extends View{

//     private $postModelObj;

//     public function __construct()
//     {
//         $this->postModelObj = new postModelObj();
//     }

//     public function index(){
//         $data = $this->postModelObj->getAllPosts();
//         $count = $this->postModelObj->getPostCount();


//         View::renderTemplate("Posts/index.html", [ 
//         'posts' => $data,
//         'alert' => Alert::getAlertMessage(),
//         'count' => $count
//         ]);
//     }

//     public function addForm(){

//         View::renderTemplate("Posts/addForm.html", [ 

      
//             ]);        
//     }

//     public function delete($id){
//         $this->postModelObj->deletePost($id);
//         header("Location: /posts/index");

//     }

//     // public function addNewPost(){
//     //     if(isset($_POST['submit'])){
//     //         $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
//     //         $title = $data['title'];
//     //         $author = $data['author'];
//     //         $text = $data['text'];
//     //         $category = $data['category'];
//     //         $this->postModelObj->newPost($title, $author, $text, $category);
   
//     //     }header("Location: /posts/index");

//     // }

//}

?>