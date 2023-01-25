<?php 
session_start();
$room = $_SESSION['room_id'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $comment = $_POST['comment'];
    $topic_id = $_POST['topic_id'];
    //$_SESSION['user_id'] = 'gon';
try{
    $pdo = new PDO("mysql:host=localhost;dbname=$room;charset=utf8",'root','');
    $stmt = $pdo->prepare("SELECT id FROM topic 
    WHERE id = :id");
    $stmt->bindValue(':id',$topic_id,PDO::PARAM_STR);
   $stmt->execute();

   $stmt = $pdo->prepare(
    "INSERT INTO comments (topic_id,date,user,value)
    VALUES(:topic_id,now(),:user,:value)"
);
   $stmt->bindValue(':topic_id',$topic_id,PDO::PARAM_STR);
   $stmt->bindValue(':user',$_SESSION['user_id'],PDO::PARAM_STR);
   $stmt->bindValue(':value',$comment,PDO::PARAM_STR);
   $stmt->execute();
   header('Location:../room.php');
   exit();
}catch(PDOException $e){
    echo $e->getMessage();
}
}
?>