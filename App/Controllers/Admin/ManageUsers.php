<?php 

namespace App\Controllers\Admin;

use App\Controllers\LoginRequired;
use System\Libs\View;
use System\Helpers\Alert;
use App\Models\User;
use App\Models\Statuslist;

class ManageUsers extends LoginRequired{


    public function __construct()
    {
        
    }

    public function indexAction(){
        $users = User::getUserList();
        View::renderTemplate('Admin/Users/userlist.html', ['users'=> $users]);
    }

    public function addAction(){
        $errors = [];
        $statuslist = Statuslist::getStatusList();
        $inputdata = [];
        if(isset($_POST['submit'])){
            $inputdata = $_POST;
            $user = new User($_POST);
            if($user->validate()){
                echo "validated";
                $user->save();
            }
            else{new Alert("Error adding a new user!", "danger") ;$errors = $user->getErrors();}
        }

        // echo '<pre>';
        // print_r($errors);
        // echo '</pre>';
        
        View::renderTemplate('Admin/Users/adduser.html', ['errors' => $errors, 'statuslist' => $statuslist , 'inputdata' => $inputdata]);
    }


    public function confirmDeleteAction($id){
        $user = User::findByid($id);
        View::renderTemplate('Admin\Users\deleteconfirm.html', ['user' => $user]);
     
    }

    public function delete($id){
        $user = User::findByid($id);

        
        if(User::deleteUser($id)){
            new Alert("User  with email <strong> {$user->email} </strong>  deleted", 'warning');

        }else{
            new Alert("Unable to delete user with email <strong> {$user->email} </strong>", 'danger');
        }
        header("Location: /admin/manageusers/");
        
    }

    public function updateAction($id){

        $user = User::findByid($id);
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        $errors = [];
        if(isset($_POST['submit'])){

            
            $user = new User($_POST);
            if($user->validateName()){
                // echo "validated";
                $user->save("update");
                new Alert("User updated");
                self::redirect("/admin/manageusers");
         
            }
            else{new Alert("Error!") ;$errors = $user->getErrors();}
        }
        // echo '<pre>';
        // print_r($errors);
        // echo '</pre>';
        $statuslist = Statuslist::getStatusList();
        
        View::renderTemplate('Admin/Users/updateUser.html', ['errors' => $errors, 'user' => $user, 'statuslist' => $statuslist]);
    }

    public function resetpassword($id){
        $user = User::findByid($id);
        $errors = [];
        if(isset($_POST['submit'])){
            $user = new User($_POST);
            if($user->validatePassword()){
                $user->updatePassword();
                
                new Alert("Password updated!");
                self::redirect("/admin/manageusers/update/{$user->id}");
              
            }else $errors = $user->getErrors();
        }

        View::renderTemplate('Admin/Users/resetpassword.html', ['errors' => $errors, 'user' => $user]);
    }

    
}
?>