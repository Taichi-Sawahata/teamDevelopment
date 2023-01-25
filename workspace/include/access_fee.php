<?php
    $dsn = 'mysql:host=localhost;dbname=fee_gpc;charset=utf8';
    $user = 'root';
    $message;
    try {
        //PDOインスタンスの作成
        $db = new PDO($dsn,$user);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $stmt = $db -> prepare("SELECT * FROM tables WHERE room_id = :r_id");
        $stmt -> bindParam(':r_id',$_SESSION['room_id'],PDO::PARAM_STR);
        if($stmt -> execute()){
            $row = $stmt -> fetch();
        $_SESSION['room_name'] = $row['room_name'];
        } 
    }catch (PDOException $e){
        exit('エラー：'.$e->getMessage());
    }finally{
        $db = null;
    }
?>