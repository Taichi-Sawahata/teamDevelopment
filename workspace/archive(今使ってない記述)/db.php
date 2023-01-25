<?php
session_start();
$dbname = $_SESSION['room_id'];
 $dsn  = "mysql:host=localhost;dbname=$dbname;charset=utf8";
 $user = "root";

 try {
     $db = new PDO($dsn, $user);
     $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
     $stmt = $db->prepare("SELECT topic.*,GROUP_CONCAT(tags.value) as value FROM topic left join tags on topic.id = tags.topic_id GROUP BY topic.id JOIN users ON topic.user_id = users.user_id");
     $stmt->execute();
} catch (PDOException $e) {
  exit("エラー:".$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  table,th,td {
    border:1px black solid;
    border-collapse:collapse;
  }
  th,td {
    width:200px;
    text-align: center;
  }
</style>
<body>
<table>
  <tbody>
<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
  <thead>
      <th>ID</th><th>DATE</th><th>USER_ID</th><th>CONTENT</th><th>MODE</th><th>IMPORTANCE</th><th>RESOLVED</th><th>タグ</th>
  </thead>
  <tr>
        <td><?=($row['id'])?></td> <!--連想配列化されているのでkeyに変わったカラム名を書くと全て表示される-->
        <td><?=($row['date'])?></td>
        <td><?=($row['user_id'])?></td>
        <td><?=($row['content'])?></td>
        <td><?=($row['mode'])?></td>
        <td><?=($row['importance'])?></td>
        <td><?=($row['resolved'])?></td>
        <td><?=($row['value'])?></td>
    </tr>

<?php } ?>
  </tbody>
</table>

</body>
</html>

