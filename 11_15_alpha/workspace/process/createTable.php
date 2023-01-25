<?php
    $dsn = $dsn = "mysql:host=localhost;dbname=$db_name;charset=utf8";
    $user = 'root';
    try {
        //PDOインスタンスの作成
        $db = new PDO($dsn,$user);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        include('cT_process.php');
        $create_host = $_SESSION['user_id'];
        for($i=0;$i<count($cT_process);$i++){
            $stmt = $db -> query($cT_process[$i]);
            $stmt = "";
        }
        $stmt = $db->prepare("INSERT INTO users(user_id) VALUES (:user)");
        $stmt -> bindParam(':user',$create_host,PDO::PARAM_STR);
        $stmt->execute();
        //仮置き
        /*
        INSERT INTO テーブル名  データの値 WHERE NOT EXISTS (SELECT
        1 FROM テーブル名 WHERE 条件);
        WHERE NOT EXISTS (SELECT 1 FROM tables WHERE room_id = :r_id)
        */
        
    }catch (PDOException $e){
        exit('エラー：'.$e->getMessage());
    }finally{
        $db = null;
        header('Location:../room.php');
    }
?>  