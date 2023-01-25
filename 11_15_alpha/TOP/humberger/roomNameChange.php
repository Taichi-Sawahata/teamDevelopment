<?php
$room;

if(!empty($_POST["btn"])){
  $user_id  = $_POST["user_id"];
  $room_id = $_POST["room_id"];
  $newRoomName = $_POST["newRoomName"];

  $dsn = "mysql:host=localhost;dbname=fee_gpc;charset=utf8";
  $user = "root";

try {
     $db = new PDO($dsn, $user);
     $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
     $stmt = $db->prepare("SELECT * FROM users WHERE user_id = :user_id AND room_id = :room_id");
     $stmt->bindParam(":user_id",$user_id,PDO::PARAM_STR);
     $stmt->bindParam(":room_id",$room_id,PDO::PARAM_STR);
     $stmt->execute();

  if($row = $stmt->fetch()){
      $stmt = $db->prepare("UPDATE tables SET room_name = :newRoomName");
      $stmt->bindParam(":newRoomName",$newRoomName,PDO::PARAM_STR);
      $stmt->execute();
  } else {
    echo "ユーザーid,またはpwが間違っています";
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
}

?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>部屋名変更</title>
</head>
<body>
  <h1>部屋名変更</h1>
  <form action="roomNameChange.php" method="post">
      <p>ユーザーID : <input type="text" name="user_id" placeholder="半角英数字5文字~10文字" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
      <p>現在の部屋ID : <input type="text" name="room_id" placeholder="半角英数字5文字~10文字" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
      <p>変更後の部屋名 : <input type="text" name="newRoomName"></p>
      <p><input type="submit" name="btn" value="変更"></p>
  </form>
</body>

</html>