<?php 

namespace System\Libs;

use \System\Config;

use System\Helpers\Alert;

use System\Helpers\Errors;

class Model{

    
    public static function getDb()
    {

        static $db;

        $host = Config::DB_HOST;
        $dbname = Config::DB_NAME;
        $user = Config::DB_USER;
        $password = Config::DB_PASSWORD;
        
        
        if($db ===  null){
            try{
                $db = new \PDO("mysql:host=$host;dbname=$dbname", $user,$password);
                $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                $db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
                $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch(\PDOException $e){
                self::handleSQLErrors('', $e);
            }

        }return $db;
        
    }


    public static function prepareAndExecute($sql, $array = []){
      
        $db = self::getDb();
        $stmt = $db->prepare($sql);
        $stmt->execute($array);

        return  $stmt;
        
    }
    public static function deleteEntry($tableName, $id){
        $sql = "DELETE from $tableName WHERE id = :id";
        return self::prepareAndExecute($sql, [$id])->rowCount() > 0;

    }

    public static function countEntries($tableName){
     
            $sql = "SELECT COUNT(*) from $tableName;";
            
            $stmt = self::prepareAndExecute($sql);
            
            $result = $stmt->fetch(\PDO::FETCH_NUM);                
            $count = $result[0];
            return $count;
            }


    public static function handleSQLErrors($query, $e){
        echo $query;
        echo '<pre>';
        print_r($e->getMessage());
        echo '</pre>';
        die();
    }

    public static function getStats($args){
        $data = [];

        foreach($args as $tableName){
            $data[$tableName . "Count"] = self::countEntries($tableName);
        }

        return $data;


        }
    

    public function insertData($table, $args){
            $db = Model::getDb();            
            $string1 = implode(', ',$args);
            $string2 = preg_replace('/([a-z0-9]+)/', ':$1',$string1);            
            $sql = "INSERT INTO $table ($string1) VALUES($string2)";
            $stmt = $db->prepare($sql);
            foreach($args as $colname){
                $tmp = $this->$colname;
                $stmt->bindValue(":$colname", $this->$colname);
            }
            try{
                $stmt->execute();
            }catch(\PDOException $e){
                new Alert("Error inserting to database!", "danger");
                $err_message = Errors::createErrorLogEntry($e);
                Errors::writeErrorToFile($err_message);
                
            }
            return $stmt->rowCount() > 0;

          
    }
    public static function getEntries($tableName, $filter = []){
        $sql = "SELECT * FROM $tableName ORDER BY id DESC";
        if($filter){
            $key = array_key_first($filter);
            $val = $filter[$key];
            $sql = "SELECT * FROM $tableName WHERE $key = $val;";    
        }   
        
        return self::prepareAndExecute($sql)->fetchAll();
    }


    }






    // public function query($sql, $array = []){
    //     $stmt = ->db->prepare($sql);
    //     $stmt->execute($array);
    //     return $data->fetchAll();
    // }






// $db = new \PDO("mysql:host=$host;dbname=$dbname", $user,$password);
// $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
// $db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
// $rows = $db->query("SELECT * from posts");
// $rows->fetchColumn(1);
// $count = $rows->rowCount();
// print_r($db->errorInfo());
// foreach ($rows as $row) {
//     print_r($row);
// }

// //OR
// $rows = $rows->fetchAll(\PDO::FETCH_ASSOC);

// //OR
// $stmt = $db->prepare("SELECT * from posts WHERE id = :id");
// $stmt->execute(['id' => $id]);
// print_r($stmt->fetchAll());
// echo $stmt->rowCount();


?>