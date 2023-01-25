<?php 
session_start();
$room = $_SESSION['room_id'];
$dsn = "mysql:host=localhost;dbname=$room;charset=utf8";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];

try{
    $pdo = new PDO($dsn,'root','');
    $stmt = $pdo->prepare("INSERT INTO users (user_id,name)
     VALUES(:user_id,:user_name) ");
    $stmt->bindValue(':user_id',$user_id,PDO::PARAM_STR);
    $stmt->bindValue(':user_name',$user_name,PDO::PARAM_STR);
   $stmt->execute();
   $stmt = $pdo->prepare("SELECT user_id FROM users");
   $stmt->execute();
   if($row = $stmt->fetch()){
    $_SESSION['invite'] = $row['user_id'];
   };

   
//    var_dump($row);
}catch(PDOException $e){
    echo $e->getMessage();
}finally{
    $pdo = null;
}

 include('room_idUpdate.php');
}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<div id="contents">

  <h1>部屋に招待</h1>

    <form action="" method="post">
        <p><input type="text" name="user_id" placeholder="ユーザーID" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
        <p><input type="text" name="user_name" placeholder="名前"  maxlength="20"></p>
        <input class = "button" type="submit">
    </form>

        <p><a href="../room.php">戻る</a></p>

</div>
</body>
</html>