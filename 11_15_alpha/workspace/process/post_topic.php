<?php 
session_start();
$room = $_SESSION['room_id'];
//$_SESSION['user_id'] = '掃除';
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
        $db = new PDO("mysql:host=localhost;dbname=$room;
        charset=utf8",'root','');
        $stmt = $db->prepare(
          "INSERT INTO topic(date,user_id,content,mode,importance)
          VALUES(now(),:user_id,:content,:mode,:importance)"
        );
       $stmt->bindValue(':user_id',$user_id,PDO::PARAM_STR);
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
    header('Location:../room.php');
    exit();

 }catch(PDOException $e){
       exit('エラー:'.$e->getMessage());
       
    }
}


?>