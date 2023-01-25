<?php
session_start();

//セッションにidが保存されていれば$user_idへ保存現在の名前を表示---------------------------
//↓決め打ち
$_SESSION["user_id"] = "nobita";

$user_id = $_SESSION["user_id"];

//db接続------------------------------------------------------------------------------------------
$dsn = "mysql:host=localhost;dbname=each_room;charset=utf8";
$user = "root";

try {
      $db = new PDO($dsn, $user);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $stmt = $db->prepare("SELECT name FROM users  WHERE user_id = :user_id");
      $stmt->bindParam(":user_id",$user_id,PDO::PARAM_STR);
      $stmt->execute();

//formで新ユーザーネームが送信された場合----------------------------------------------------
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST["name"];
        $stmn = $db->prepare("UPDATE users SET name = :name WHERE user_id = :user_id");
        $stmn->bindParam(":name",$name,PDO::PARAM_STR);
        $stmn->bindParam(":user_id",$user_id,PDO::PARAM_STR);
        $stmn->execute();
         }
    } catch (PDOException $e) {
       echo $e->getMessage();
    };

$row = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($row)


?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>名前の変更</title>
</head>
<body>
  <h1>ユーザーネーム変更</h1>

  <form action="" method="post">
    <p>現在の名前 : <?php echo $row["name"]; ?></p>
    <label>新しい名前 : </label>
    <input type="text" name="name"  required="required">
    <input type="submit" name="btn" value="変更">
  </form>
  
</body>
</html>