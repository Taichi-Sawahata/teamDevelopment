<?php
session_start();
if(isset($_SESSION["user_id"])){
  if(isset($_SESSION["room_id"])){
    header("Location: room.php");
  }else{
  header("Location: createRoom.php");
  exit();
  }
}

if(isset($_POST["btn"]) && isset($_POST["id"]) && isset($_POST["pass"])){
  $id   = $_POST["id"];
  $pass = $_POST["pass"];
  
  $dsn  = "mysql:host=localhost;dbname=fee_gpc;charset=utf8";
  $user = "root";//mampでrootが使えなかったのでユーザー追加
  //$pass = "test";
 
 try {
  $db = new PDO($dsn, $user);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare("SELECT * FROM users WHERE user_id = :id AND password = :pass");
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
  $stmt->execute();

  if($row = $stmt->fetch()){
    $_SESSION["user_id"]  = $row["user_id"];
    if($row["room_id"]===null){
      //room_idがrowにあるかどうかで分岐
      header("Location: createRoom.php");
      exit();
    }else{
      $_SESSION["room_id"]=$row["room_id"];
      header("Location: room.php");
      exit();
    }
    
  } else {
    header("Location: login.php");
    exit();
  }

} catch (PDOException $e) {
  exit("エラー:".$e->getMessage());
}
} 
?>


<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./humberger/css/style.css">
  <title>ログイン画面</title>
</head>
<body>
  <div id="contents">
     <h1>ログイン</h1>

     <form action="login.php" method="post">
       <p><input type="text" name="id" placeholder="LOGIN ID" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10" class="form"></p>
       <p><input type="passwoed" name="pass" placeholder="PASS WORD" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10" class="form"></p>
       <p><input type="submit" name="btn" value="LOGIN" class="button"></p>
     </form>

     <a href="createAccout.php">新規登録はこちら</a>
  </div>
</body>
</html>