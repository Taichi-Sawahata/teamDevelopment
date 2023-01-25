<?php
if(isset($_POST["btn"])){
  $id   = $_POST["id"];
  $pass = $_POST["pass"];
  
  $dsn  = "mysql:host=localhost;dbname=fee_gpc;charset=utf8";
  $user = "root";//mampでrootが使えなかったのでユーザー追加
 
 
 try {
  $db = new PDO($dsn, $user);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare("INSERT INTO users (user_id, password) VALUES (:id, :pass)");
  $stmt->bindParam(':id', $id, PDO::PARAM_STR);
  $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
  $stmt->execute();
  header("Location: login.php");
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
 <link rel="stylesheet" href="humberger/css/style.css">
  <title>新規登録</title>
</head>
<body>

  <div id="contents">

  <form action="" method="post">
      <h1>新規登録</h1>

      <p><input type="text" name="id" placeholder="ID" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
      <p><input type="text" name="pass" placeholder="PASS WORD" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
      <p><input class="button" type="submit" name="btn" value="登録"></p>

  </form>

  </div>
  
</body>
</html>