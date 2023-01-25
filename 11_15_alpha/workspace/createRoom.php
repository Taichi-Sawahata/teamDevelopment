<?php
    session_start();
    //仮アカウント
    //$_SESSION['user_id']='test';
    //SESSIONにuser_idが含まれている/room_idがアンセットである事を確認  
    if(isset($_POST['r_id'])||isset($_POST['r_name'])){
        $dsn = 'mysql:host=localhost;dbname=fee_gpc;charset=utf8';
        $user = 'root';
        $message;
        try {
            //PDOインスタンスの作成
            $db = new PDO($dsn,$user);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $stmt = $db -> prepare("SELECT * FROM tables WHERE room_id = :r_id");
            $stmt -> bindParam(':r_id',$_POST['r_id'],PDO::PARAM_STR);
            $stmt -> execute();
            if(!$stmt->fetch()){
                //プリペアドステートメントを作成
                $stmt = $db -> prepare("INSERT INTO tables (room_id,room_name) VALUES (:r_id,:r_name)");
                //プリペアドステートメントの詳細を割り当て
                $stmt -> bindParam(':r_id',$_POST['r_id'],PDO::PARAM_STR);
                $stmt -> bindParam(':r_name',$_POST['r_name'],PDO::PARAM_STR);
                //クエリの実行
                if($stmt -> execute()){
                    $stmt = $db -> prepare("UPDATE users SET room_id = :r_id WHERE user_id = :usr_id");
                    $stmt -> bindParam('usr_id',$_SESSION['user_id'],PDO::PARAM_STR);
                    $stmt -> bindParam('r_id',$_POST['r_id'],PDO::PARAM_STR);
                    $stmt -> execute();
                    $_SESSION['room_id']=$_POST['r_id'];
                    header('Location:process/createDB.php');
                    exit();
                }else{
                    $message = "ルームの作成中にエラーが発生しました";
                }
            }else{
                $message = "そのidは使用されています";
            }
            //仮置き
            /*
            INSERT INTO テーブル名  データの値 WHERE NOT EXISTS (SELECT
            1 FROM テーブル名 WHERE 条件);
            WHERE NOT EXISTS (SELECT 1 FROM tables WHERE room_id = :r_id)
            */
            
        }catch (PDOException $e){
            exit('エラー：'.$e->getMessage());
        }
        echo $message;
    }
    
?>

<section>
    <form action="createRoom.php" method="post">
        <p>ルームID：<input type="text" name="r_id" size="10" placeholder="半角英数字5~10文字"></p>
        <p>ルーム名：<input type="text" name="r_name" size="20" placeholeder="最大20文字"></p>
        <p><input type="submit" value="ルームを作成"></p>
    </form>
    <div>
        <p>サービスを利用するには、あなたのアカウントと部屋を紐付ける必要があります！<br>
        ご自身で部屋を作るか、既に部屋に所属してるユーザーからの招待を受けてください。
        </p>
    </div>
</section>
