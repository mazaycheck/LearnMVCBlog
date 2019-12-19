<?php 

namespace System\Libs;

use System\Helpers\Alert;

class Auth{

    public static function login($user){
        session_regenerate_id(true);
        $_SESSION['loggedin'] = True;
        $_SESSION['user'] = $user->name;
        $_SESSION['level'] = $user->statuslevel;
        new Alert("User logged in");
    }

    public static function logout(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
        }
        session_destroy();
        
    }

    // public static function isloggedin(){
    //     return isset($_SESSION['loggedin']);
    // }


    public static function getUser(){

        return $_SESSION['user'] ?? '';
    }

    public static function requiredAccessLevel($level){
        if($_SESSION['level'] > $level){
        exit("You do not have privileges");}
    }




}

?>