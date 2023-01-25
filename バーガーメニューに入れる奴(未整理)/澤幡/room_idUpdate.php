<?php
session_start();
    try{
        //$_SESSION['room_id']='God';
        $pdo = new PDO('mysql:host=localhost;dbname=fee_gpc;charset=utf8','root','');
        $stmt= $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindValue(':user_id',$_SESSION['invite'] ,PDO::PARAM_STR);
        $stmt->execute();
        $stmt = $pdo->prepare("UPDATE users SET room_id = :room_id 
           WHERE user_id = :user_id ");
         $stmt->bindValue(':user_id',$_SESSION['invite'] ,PDO::PARAM_STR);
        $stmt->bindValue(':room_id',$_SESSION['room_id'] ,PDO::PARAM_STR);
       $stmt->execute();
       header('Location:roomMemberUpdate.php');
    }catch(PDOException $e){
        echo $e->getMessage();   
    }
   
//AND room_id IS NULL
?>