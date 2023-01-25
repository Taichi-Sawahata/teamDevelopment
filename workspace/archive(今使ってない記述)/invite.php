<?php
session_start();
 try{
   //今これ使ってない説？
     $room_id = $_SESSION['room_id'];
     $ddd = $_SESSION['invited_usr'];
     
     $db = new PDO('mysql:host=localhost;dbname=fee_gpc;charset=utf8','root','');
     
       $stmt = $db->prepare(
           "UPDATE users SET room_id=:room_id WHERE user_id = :id AND 
           room_id IS NULL"
       );
       $stmt->bindValue(':room_id',$room_id,PDO::PARAM_STR);
       $stmt->bindValue(':id',$ddd,PDO::PARAM_STR);
       $stmt->execute();
       unset ($_SESSION['invited_usr']);
    //    if($stmt->execute()){
    //      echo 'ok';
    //    }else{
    //     echo 'あります';
    //    }
       header('Location:room.php');
       exit;
 }catch(PDOException $e){
    echo $e->getMessage();
    echo 'ccc';
 }
?>

