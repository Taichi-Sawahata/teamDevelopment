<?php
session_start();

if(isset($_SESSION["user_id"])){
    unset($_SESSION["user_id"]);
};


?>
<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>ログアウト完了</title>
</head>
<body>
  <div id="contents">
    <h1>ログアウト完了</h1>
    <p><a href="../login.php">ログイン画面へ戻る</a></p>
  </div>
  
</body>
</html>