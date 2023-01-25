<?php
    session_start();
    $ct = intval($_POST['ct']);
    $room_id = $_SESSION['room_id'];
    //include('');
    $dsn = "mysql:host=localhost;dbname=$room_id;charset=utf8";
        $user = 'root';
        $topicList = array();
        try {
            //PDOインスタンスの作成
            $db = new PDO($dsn,$user);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $stmt = $db -> prepare("SELECT topic.*,users.name,GROUP_CONCAT(DISTINCT(cmt_list.datas)) AS comments ,GROUP_CONCAT(DISTINCT (tags.value))AS tags FROM topic 
            LEFT JOIN users ON topic.user_id = users.user_id LEFT JOIN (SELECT topic_id,CONCAT(comments.id,'/',comments.date,'/',users.name,'/',comments.value) AS datas FROM comments LEFT JOIN users ON comments.user = users.user_id)AS cmt_list ON topic.id = cmt_list.topic_id LEFT JOIN tags ON tags.topic_id = topic.id  GROUP BY topic.id ORDER BY topic.id DESC");
            $stmt -> execute();
            //WHERE topic.resolved IS NULLをつけたい

            // fetchメソッドでSQLの結果を取得
            // 定数をPDO::FETCH_ASSOC:に指定すると連想配列で結果を取得できる
            // 取得したデータを$productListへ代入する
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $topicList[] = array(
                    'id'    => $row['id'],
                    'date'  => $row['date'],
                    'user_id' => $row['user_id'],
                    'content' => $row['content'],
                    'mode' => $row['mode'],
                    'importance' => $row['importance'],
                    'resolved' => $row['resolved'],
                    'comments' => explode(',',$row['comments']),
                    'tags' => $row['tags'],
                    'name' => $row['name']
                );
            }
            include('makecard.php');
            //解決済みを廃除するphp
            for($i=0;$i<count($topicList);$i++){
                if(!$topicList[$i]['resolved'] == null){
                    unset($topicList[$i]);
                }
            }
            $topicList = array_values($topicList);
            $target =  array_slice($topicList,$ct,5);
                //makeCard($topicList);
            // ヘッダーを指定することによりjsonの動作を安定させる
            header('Content-type: application/json');
            // htmlへ渡す配列$productListをjsonに変換する
            echo makeCard($target);
            //echo json_encode($result,JSON_UNESCAPED_UNICODE);
        }catch (PDOException $e){
            exit('エラー：'.$e->getMessage());
        }
?>
<?php
/*
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../topiccard/tpcard.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        makeCard($topicList);
    ?>
</body>
</html>
*/
?>

