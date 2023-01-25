<?php
  session_start();
  if(isset($_POST['tp'])){
  $tp = $_POST['tp'];
  $tp = intval($tp);
  //$tp = intval($_GET['tp']);
  $room = $_SESSION['room_id'];
  $dsn = "mysql:host=localhost;dbname=$room;charset=utf8";
    $user = 'root';
    $message;
    try {
        //PDOインスタンスの作成
        $db = new PDO($dsn,$user);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $stmt = $db -> prepare("UPDATE topic SET resolved = 't' WHERE id = :tp");
        $stmt -> bindParam(':tp',$tp,PDO::PARAM_INT);
        $stmt -> execute();
        
    }catch (PDOException $e){
        exit('エラー：'.$e->getMessage());
    }finally{
        $db = null;
    }
}

?>