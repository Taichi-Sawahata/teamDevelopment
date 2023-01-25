<?php
    session_start();
    //isset($_SESSION['user_id'])||isset($_SESSION['room_id']){}
    $db_name = $_SESSION['room_id'];
    //データベース一覧が非常にわかりづらいので、将来的にdbnameにfee_gpc_をつけて操作するのも視野
    try {
        // DB接続
        $pdo = new PDO('mysql:host=localhost;','root','',
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        // SQL文をセット
        $stmt = $pdo->prepare("CREATE DATABASE $db_name");
        // SQL実行
        $stmt->execute();
    } catch (PDOException $e) {
        // エラー発生
        echo $e->getMessage();
         
    } finally {
        // DB接続を閉じる
        $pdo = null;
        echo "データベース作れたんやないかな";
    }
    include('createTable.php');
?>