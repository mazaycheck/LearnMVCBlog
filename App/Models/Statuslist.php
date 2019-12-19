<?php 

namespace App\Models;

use System\Libs\Model;

class Statuslist extends Model{

    public static function getStatusList(){
        $db = Model::getDb();
        $sql = "SELECT * from statuslist;";
        $result = Model::prepareAndExecute($sql);
        return $result->fetchAll();
    }

}


?>

