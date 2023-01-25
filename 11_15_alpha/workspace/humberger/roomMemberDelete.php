<?php
//
//メンバー一覧の呼び出し
session_start();
  $room = $_SESSION['room_id'];
  $dsn = "mysql:host=localhost;dbname=$room;charset=utf8";
  $user = "root";
  
 try{
  $db = new PDO($dsn, $user);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare("SELECT * FROM users");
  $stmt->execute();

  if(isset($_POST["delete"])){
    $user_id = $_POST["delete"];
    $dlt = $db->prepare("DELETE FROM users WHERE user_id = :user_id");
    $dlt->bindParam(":user_id",$user_id,PDO::PARAM_STR);
    $dlt->execute();
 }
}
 catch(PDOException $e){
  exit("エラー:".$e->getMessage());
 }
?>

<?php
//fee_gpcのusersテーブルのroom_idをnullに
$dns = "mysql:host=localhost;dbname=fee_gpc;charset=utf8";
$user = "root";
if(isset($_POST["delete"])){
      $id = $_POST["delete"];
    try { 
      $db = new PDO($dns, $user);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $update = $db->prepare("UPDATE users SET room_id = NULL WHERE user_id = :id");
      $update->bindParam(":id",$id,PDO::PARAM_STR);
      $update->execute();
        } catch(PDOException $e){
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
  <link rel="stylesheet" href="css/style.css">
  <title>部屋へ招待・削除・一覧</title>
</head>
<body>
  <div id="contents">
  <h2>メンバー削除</h2> <!--DBを代入-->
  <table class="table">
     <thead>
        <tr>
          <th>ID</th><th>名前</th><th>削除</th>
        </tr>
     </thead>

      <tbody>
       <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
           <tr>
           <form action="" method="post">
                 <td><?=($row['user_id'])?></td> <!--連想配列化されているのでkeyに変わったカラム名を書くと全て表示される-->
                 <td><?=($row['name'])?></td>
                 <td><button class="button" type="submit" value="<?php echo $row['user_id'] ?>" name="delete">削除</button></td>
           </form>
           </tr>
       <?php } $stmt = null;?>
      </tbody>
  </table>
  <p><a href="../room.php">戻る</a></p>
  </div>

</body>
</html>

