<?php 

namespace App\Models;

use PDO;
use System\Libs\Model;

class Comment extends Model{

    const TABLENAME = 'comments';
    public $id;      // int AI
    public $name;    // varchar 
    public $text;    // varchar
    public $date;    // timestamp   default: current_timestamp
    public $approved;// int         default : 0
    public $approvedBy;// int NULL  default : NULL       INDEX -> users id
    public $email;   // varchar 
    public $post;    //int                                INDEX -> posts id



    public function __construct($args)
    {
        foreach($args as $key => $value){
            $this->$key = $value;
        }
    }


    public function saveComment(){
        $args = ['name', 'text', 'email' , 'post'];
        return $this->insertData(self::TABLENAME, $args);
    }

    public static function deletecomment($id){
        return self::deleteEntry(self::TABLENAME, $id);
    }

    public function updatecomment($id, $data){

    }

    public static function approveComment($id){
        $sql = "UPDATE comments SET approved = 1 WHERE id = :id;";
        return self::prepareAndExecute($sql, [$id]);
    }

    public static function disApproveComment($id){
        $sql = "UPDATE comments SET approved = 0 WHERE id = :id;";
        return self::prepareAndExecute($sql, [$id]);
    }

    public static function showallcomments(){
        $sql = "SELECT comments.* , posts.title as postTitle FROM comments LEFT JOIN posts ON comments.post = posts.id ORDER BY comments.id DESC;";
        return self::prepareAndExecute($sql)->fetchAll();
    }

    public static function showapprovedcomments(){
        return self::getEntries(self::TABLENAME,['approved' => 1]);
    }


    public function showcommentsbyuser($userid){

    }

    public function showcommentsbypost($postid){

    }

    public function getcommentbyid($id){

    }


    

}

?>