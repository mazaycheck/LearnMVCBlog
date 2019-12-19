<?php 

namespace App\Controllers\Admin;

use System\Helpers\Alert;
use App\Models\Comment;
use System\Libs\BaseController;
use App\Controllers\LoginRequired;
use System\Libs\View;

class ManageComments extends LoginRequired{

    public function addAction(){
        if(isset($_POST['submit'])){
            $comment = new Comment($_POST);
            if($comment->saveComment()){
                echo "Comment added!";
                new Alert("Comment added!");
            }else{
                //new Alert("Error adding comment", "danger");
            }
        }
        View::renderTemplate("Admin/Comments/add.html");

    }

    public function manageAction(){
        $comments = Comment::showallcomments();

        
        View::renderTemplate("Admin/Comments/manage.html", ['comments' => $comments]);
    }

    public function approve($id){
        if(Comment::approveComment($id)){
            new Alert("Comment approved");
            
        }else{
            new Alert("Something wrong", "danger");
        }
        self::redirect("/admin/managecomments/manage");

    }
    public function disapprove($id){
        if(Comment::disApproveComment($id)){
            new Alert("Comment disApproved", "warning");
            
        }else{
            new Alert("Something wrong", "danger");
        }
        self::redirect("/admin/managecomments/manage");

    }

    public function delete($id){
        if(Comment::deletecomment($id)){
            new Alert("Comment deleted", "warning");
        }
        else{
            new Alert("Could not delet comment!");
        }
        self::redirect("/admin/managecomments/manage");
    }

}


?>