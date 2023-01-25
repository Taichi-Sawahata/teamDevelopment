<?php

session_start();
  $room = $_SESSION['room_id'];
  $dsn = "mysql:host=localhost;dbname=$room;charset=utf8";
  include('../include/access_fee.php');
if(!empty($_POST["btn"])){
  $user_id  = $_POST["user_id"];
  $room_id = $_POST["room_id"];
  $newRoomName = $_POST["newRoomName"];
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
  <link rel="stylesheet" href="css/style.css">
  <title>部屋名変更</title>
</head>

<body>
  <div id="contents">
   <h1>部屋名変更</h1>
     <form action="roomNameChange.php" method="post">
         <p><input type="text" name="user_id" placeholder="ユーザーID" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
         <p><input type="text" name="room_id" placeholder="部屋ID" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
         <p><input type="text" name="newRoomName" placeholder="変更後の部屋名" value="<?php echo $_SESSION['room_name']; ?>"></p>
         <p><input class="button" type="submit" name="btn" value="変更"></p>
         <p><a href="../room.php">戻る</a></p>
     </form>
  </div>
</body>

</html>