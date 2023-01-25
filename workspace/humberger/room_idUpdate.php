<?php
//session_start();
function update_fee(){
    try{
        //$_SESSION['room_id']='God';
        $pdo = new PDO('mysql:host=localhost;dbname=fee_gpc;charset=utf8','root');
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        /*
        $stmt= $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id',$_SESSION['invite'] ,PDO::PARAM_STR);
        $stmt->execute();
        */
        $stmt = $pdo->prepare("UPDATE users SET room_id = :room_id WHERE user_id = :user_id");
         $stmt->bindParam(':user_id',$_SESSION['invite'] ,PDO::PARAM_STR);
        $stmt->bindParam(':room_id',$_SESSION['room_id'] ,PDO::PARAM_STR);
       $stmt->execute();
       header('Location:../room.php');
    }catch(PDOException $e){
        echo $e->getMessage();   
    }
}
//AND room_id IS NULL
?>