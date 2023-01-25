<?php
//
//メンバー一覧の呼び出し
  $dsn = "mysql:host=localhost;dbname=each_room;charset=utf8";
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
  <title>部屋へ招待・削除・一覧</title>
  <style>
    table,th,td { 
      border:1px solid black;
      border-collapse: collapse;
    }
    th,td {
      width:100px;
      text-align:center;
    }
  </style>
</head>
<body>
  <h2>メンバー一覧</h2> <!--DBを代入-->
  <table class="table">
      <tbody>
      <thead><th>ID</th><th>NAME</th><th>削除</th></thead>
       <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
           <tr>
           <form action="" method="post">
                 <td><?=($row['user_id'])?></td> <!--連想配列化されているのでkeyに変わったカラム名を書くと全て表示される-->
                 <td><?=($row['name'])?></td>
                 <td><button type="submit" value="<?php echo $row['user_id'] ?>" name="delete">削除</button></td>
           </form>
           </tr>
       <?php } $stmt = null;?>
      </tbody>
  </table>

<!--メンバーの追加-->
  <form action="addition.php" method="post">
     <h2>メンバーの追加</h2>
      <p>ユーザーID : <input type="text" name="user_id" placeholder="半角英数字5文字~10文字" pattern="^[a-zA-Z0-9]+$" minlength="5" maxlength="10"></p>
      <p>名前 : <input type="text" name="name" required="required"></p>
    <input type="submit" name="addition" value="追加">
  </form>

</body>
</html>

