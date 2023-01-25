<?php 
session_start();
//$_SESSION['user_id'] = '掃除';
$dbname = $_SESSION['room_id']; 
if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
        $user_id = $_POST["user_id"];
        $importance = $_POST["importance"];
        $mode = $_POST["mode"];
        $tags = $_POST["tag"];
        $content =$_POST["content"];
   
         // var_dump($user_id);
            // var_dump($user_name);
            // var_dump($user);
            // var_dump( $p_name);
        try {
        $db = new PDO("mysql:host=localhost;dbname=$dbname;
        charset=utf8",'root','');
        $stmt = $db->prepare(
          "INSERT INTO topic(date,user_id,content,mode,importance)
          VALUES(now(),:user_id,:content,:mode,:importance)"
        );
       $stmt->bindValue(':user_id',$user_id,PDO::PARAM_STR);
       //$stmt->bindValue(':tag',$tags,PDO::PARAM_STR); 
       $stmt->bindValue(':mode',$mode,PDO::PARAM_STR); 
       $stmt->bindValue(':importance',$importance,PDO::PARAM_INT); 
       $stmt->bindValue(':content',$content,PDO::PARAM_STR); 
       $stmt->execute();
     $primary = $db->lastInsertId();
    //    echo $primary;


      $tags_array=explode(',',$tags);
    
      for($i=0;$i<count($tags_array);$i++){
        $stmt= $db->prepare("
        INSERT INTO tags(topic_id,value)
        VALUES(:topic_id,:value) ");
        $stmt->bindValue(':topic_id',$primary,PDO::PARAM_STR);
        $stmt->bindValue(':value',$tags_array[$i],PDO::PARAM_STR);
        $stmt->execute();
      }
    

 }catch(PDOException $e){
       exit('エラー:'.$e->getMessage());
       
    }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<section class="kakikomi">
        <div>
            <form action="" method="post">
                <div><input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" name="user_id"></div>
                <div>重要度<input type="number" min="0" max="5" name="importance"></div>
                <div>
                    <select name="mode">
                        モード
                        <option value="00">解決したい</option>
                        <option value="01">つぶやき</option>
                    </select>
                </div>
                <div>タグ<input type="text" name="tag"></div>
                <div>テキスト<input type="text" name="content"></div>
                <div><input type="submit"></div>
            </form>
        </div>
    </section>
</body>
</html>