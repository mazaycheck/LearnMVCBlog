<?php 

namespace App\Models;

use System\Libs\Model;

class Category extends Model{

    public function __construct()
    {
       
    }

    public function createCategory($categoryName){
        $sql = "INSERT INTO categories (category) VALUES(:category);";
        $stmt = Model::prepareAndExecute($sql , [':category' => $categoryName]);
        return $stmt->rowCount();
    }

    public function deleteCategory($id){
        $sql = "DELETE FROM categories WHERE id= :id;";
        $stmt = Model::prepareAndExecute($sql, [':id' => $id]);
        return $stmt->rowCount;
    }

    public function updateCategory(){

    }

    public function getCategoryById(){

    }

    public static function getCategoryList(){
        $sql = "SELECT * from categories;";
        $stmt = Model::prepareAndExecute($sql);
        return $stmt->fetchAll();

    }


}

?>