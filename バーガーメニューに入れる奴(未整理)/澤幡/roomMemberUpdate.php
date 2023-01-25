<?php 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
try{
    $pdo = new PDO('mysql:host=localhost;dbname=each_room;charset=utf8','root','');
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
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    ユーザーID<input type="text" name="user_id">
    ユーザー名<input type="text" name="user_name">
    <input type="submit">
</form>
</body>
</html>