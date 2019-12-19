<?php 

namespace App\Controllers;

use App\Models\User;

use System\Libs\View;

use System\Libs\Auth;

use System\Helpers\Alert;

use System\Libs\BaseController;

class Account extends BaseController{

    public function validateemailadressAction(){
        $is_valid = '';
        if(isset($_GET['email']))
        $is_valid = !User::checIfUserAlreadyExists($_GET['email']);
        header('Content-Type: application/json');
        echo json_encode($is_valid);           
    }

    public function signupAction(){
      
        $errors = [];
        $result = '';
        $inputdata = [];

        if(isset($_POST['submit'])){

            $user = new User($_POST);
            if($user->validate())
            {   
                $user->save();
                Auth::login($user);
                $result = "success";
                header("Location: /account/success" , true, 303);                
                exit();
            }
            else{
                $result = "error";
                new Alert("Try again!", "warning");
                $errors = $user->getErrors();
                $inputdata = ['name' => $_POST['name'] ?? '',
                            'email' => $_POST['email'] ?? ''];
                }
            }

        

        View::renderTemplate("Account/signup.html", [
            'result' => $result,
            'errors' => $errors, 
            'inputdata' => $inputdata
            ]);

    }
    

    public function successAction(){
        header( "refresh:5;url=http://localhost/" );
        View::renderTemplate("Account/signup-success.html");
        
        
    }

    public function loginAction(){
        
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = new User(['email' => $email, 'password' => $password]);
            if($auth_user = $user->authenticate()){
                Auth::login($auth_user);
                BaseController::redirect(BaseController::getRedirectdUrl());
            }else echo "Wrong credentials!";
        }

        //     $data = User::findByEmail($_POST['email']);

            
        //     if($data){
        //         if(password_verify($_POST['password'], $data['password'])){    
        //             $_SESSION['user'] = $data['name'];
        //             header("Location: /index");
        //         }else echo "Wrong password!";
        //     }else echo "Wrong email!";
        // }   

        $email = $_POST['email'] ?? '';
        View::renderTemplate("Account/login.html", ['email' => $email]);
    }

    public function logoutAction(){
        Auth::logout();
        header("Location: /index");
    }

    

}


?>