<?php 

namespace App\Models;

use System\Libs\Model;

use System\Helpers\Alert;

class Post extends Model{



    public function __construct()
    {
      
    }

    public function getAllPosts(){
        
        $sql = "SELECT * FROM posts ORDER BY id DESC;";
        $stmt = Model::prepareAndExecute($sql);
        return $stmt->fetchAll();
        
    }

    public function getAllPostsAndComments(){
        
        $sql = "SELECT posts.* , comments.email as commentEmail, comments.text as commentText, comments.date as commentDate FROM posts LEFT JOIN comments ON posts.id = comments.post ORDER BY id DESC";
        $stmt = Model::prepareAndExecute($sql);
        return $stmt->fetchAll();
        
    }




    public function getSinglePost($id){
        $sql = "SELECT * FROM posts WHERE id = :id;";
        $stmt = Model::prepareAndExecute($sql,[':id' => $id]);
        return $stmt->fetch();
    }

    public function newPost($title, $author, $text, $category){
        $sql = "INSERT INTO posts (title, author, text , category_id) VALUES(:title,:author,:text, :category_id);";
        $stmt = Model::prepareAndExecute($sql,[':title' => $title, ':author' => $author, ':text'=>$text, ':category_id' => $category]);
        return $stmt->rowCount();
    }
 

    public function updatePost($id, $title, $author, $text, $category){
        $sql = "UPDATE posts SET title= :title , author = :author,  `text`= :text, category_id = :category WHERE id = :id;";
        $stmt = Model::prepareAndExecute($sql,[':title' => $title, ':author' => $author, ':text'=>$text, ':category' => $category, ':id' => $id]);
        return $stmt->rowCount();
    }

    public function deletePost($id){
        $sql = "DELETE FROM posts WHERE id = :id;";
        $stmt = Model::prepareAndExecute($sql,[':id' => $id]);
        
        return $stmt->rowCount();
    }

    public function getPostCount(){
        $sql = "SELECT COUNT(*) from posts ORDER BY id DESC;";
        $stmt = Model::prepareAndExecute($sql);
        $result = $stmt->fetch(\PDO::FETCH_NUM);                
        $count = $result[0];
        return $count;
    }

    public function getAuthorById($id){
        $sql = "SELECT users.name from posts LEFT JOIN users ON posts.author = users.id WHERE posts.id = :id ORDER BY posts.id DESC;";
        $stmt = Model::prepareAndExecute($sql, [':id' => $id]);
        $result = $stmt->fetch();

        return $result['name'];
    }
}

?>