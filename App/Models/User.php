<?php 

namespace App\Models;

use System\Libs\Model;



class User extends Model{

    const TABLENAME = 'users';
    public $errors;
    public $id;
    public $name;
    public $email;
    protected $password;
    protected $info;
    public $statuslevel = 3;

    public function __construct($args)
    {
        
        foreach($args as $key => $value){
            $this->$key = $value;
        }

    }

    public function save($type = "save"){
    
        $db = $this->getDb();
        
        if($type == "save"){
            $sql = "INSERT INTO users (name, email, password, statuslevel) VALUES(:name , :email, :password, :statuslevel);";
        }
        elseif($type = "update"){
            $sql = "UPDATE users SET name = :name , statuslevel = :level WHERE id= :id;";
        }

        $stmt = $db->prepare($sql);
        if($type == "update")
        $stmt->bindValue(':id', $this->id);
        $stmt->bindValue(':name', $this->name);
        
        if($type == "save"){
            $stmt->bindValue(':email', $this->email);
            $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);

            $stmt->bindValue(':password', $hashpassword);
        }
        $stmt->bindValue(':statuslevel', $this->statuslevel);
        $stmt->execute();
        if($stmt->rowCount())
        {
   
            return True;
        }
        return False;
  
    }



    public function validate($type = "signup"){
        $this->validateName();
        $this->validateEmail();
        $this->validatePassword();
        if($this->errors)
            return False;
        
        return True;
    }


    public function validateEmail(){

    
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                $this->errors['emailError'] = 'Must be a valid email!';
            }
        if(static::checIfUserAlreadyExists($this->email)){
            $this->errors['emailError'] = 'User Already Exists';
            }
        if($this->errors)
            return false;
        
        return true;
    }

    public function validateName(){
        if(strlen($this->name) < 3){
            $this->errors['nameError'] = 'Name must contain 3 or more characters';
        }
        if($this->errors)
        return false;
    
    return true;
    }


    public function validatePassword(){
        if($this->password != $this->password2){
            $this->errors['passwordError'] = 'Passwords must match!';
        }

        elseif(strlen($this->password) < 6){
            $this->errors['passwordError'] = 'Passwords must be 6 or more characters!';
        }

        elseif(!preg_match('/[\d]/',$this->password)){
            $this->errors['passwordError'] = 'Password must contain at least 1 number!';
        
        }
        elseif(!preg_match('/[a-z]/',$this->password)){
            $this->errors['passwordError'] = 'Password must contain at least 1 character!';
        }

        elseif(!preg_match('/[A-Z]/',$this->password)){
            $this->errors['passwordError'] = 'Password must contain at least 1 upper case character!';
        }
        
        elseif(!preg_match('/[\!\@\#\$\%\^\&\*\(\)\-\/\*\'\:\;\{\}\[\]]/',$this->password)){
            $this->errors['passwordError'] = 'Password must contain at least 1 symbol!';
        }
        if($this->errors)
        return false;
    
    return true;
    }

        public static function checIfUserAlreadyExists($email){
            return static::findByEmail($email) == true;
        }


        public static function findByEmail($email){

            $db = Model::getDb();
            $sql = "SELECT * FROM users WHERE email= :email;";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":email" , $email);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);

        }

        public static function findByid($id){

            $db = Model::getDb();
            $sql = "SELECT * FROM users WHERE id= :id;";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(":id" , $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_OBJ);

        }



        public function getErrors(){
            return $this->errors;
        }


    public static function getUserList(){
        $sql = "SELECT * FROM users;";
        $stmt = Model::prepareAndExecute($sql);
        return $stmt->fetchAll();
    }

    public function authenticate(){
        
        $obj = User::findByEmail($this->email);
        if($obj){
            if(password_verify($this->password, $obj->password)){
                return $obj;
            }else return False;
        }else return False;

    }

    public static function deleteUser($id){
        $sql = "DELETE FROM users WHERE id = :id;";
        $stmt = Model::prepareAndExecute($sql, [$id]);
        return $stmt->rowCount() > 0;
    }

    public function updatePassword(){
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = :password;";
        $stmt = $this->prepareAndExecute($sql , [$hashpassword]);
        return $stmt->rowCount() > 0;
    }

}


// permissions
// level 1 admin => admin_panel  , users, posts , comments 
// level 2 author => admin_panel , posts, comments
// level 3 guest => comments

?>
