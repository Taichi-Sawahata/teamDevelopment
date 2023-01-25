<?php
  session_start();
  //ログイン・非ログイン判定include
  $room = $_SESSION['room_id'];
  include('include/access_fee.php');
  $dsn = "mysql:host=localhost;dbname=$room;charset=utf8";
  $user = "root";
  try{
    $db = new PDO($dsn,$user);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $db -> prepare("SELECT * FROM users WHERE user_id = :user");
    $stmt -> bindParam(':user',$_SESSION['user_id'],PDO::PARAM_STR);
    if($stmt->execute()){
      $row = $stmt -> fetch();
      $_SESSION['user_name'] = $row['name'];
    }

  }catch (PDOException $e){
    exit('エラー：'.$e->getMessage());
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= $_SESSION['room_name']; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="topiccard/tpcard.css">
    <link rel="stylesheet" href="../TOP/top.css">
    <style>
      *{
        font-family: 'Sawarabi Gothic', sans-serif;
      }
      .hidden{
        display:none;
      }
      #topic_post_box table{
        width:100%;
      }
    </style>
    <script src="../TOP/top.js"></script>
    <script>
      'use strict';
      let ct = 0;
      let clicked = "";
      //とりあえずroomに直接書き込んで動かした。多分名前宣言範囲の問題がありそう。
      function callTopic(){
      let load_tp = new XMLHttpRequest();
      load_tp.open('POST','function/load_all_topic.php');
      load_tp.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded');
      load_tp.responseType = "text";
      load_tp.addEventListener('load',function(){
          let data = load_tp.response;
          //console.log(data);//OK
          document.getElementById("topic_area").insertAdjacentHTML('beforeend',data);
          ct = ct + 5;
      });
      load_tp.send(`ct=${ct}`);
      };
      function c_toggle(place){
        console.log(place);
        let target = document.getElementById(place);
        target.classList.toggle("hidden");
      }
      function com_toggle(place){
        c_toggle(place.dataset.id);
        if(clicked == place.dataset.id){
          clicked = "";
        }else if(clicked == ""){
          clicked = place.dataset.id;
        }else{
          c_toggle(clicked);
          clicked = place.dataset.id;
        }
        
        //let target = document.getElementById(place);
        //target.classList.toggle("hidden");
      }
      function resolved(tp_place){
        //メモ：なんかpost動いてない//varとappendくっつけたら動いた
        let tp = tp_place.slice(3);
        console.log(tp);
        var formData = new FormData();
	      formData.append('tp',tp);
        //console.log(formData);
        let be_resolve = new XMLHttpRequest();
        be_resolve.open('POST','function/be_resolve.php');
        //be_resolve.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        be_resolve.send(formData);
        //c_toggle(tp_place);
      }
      window.addEventListener('DOMContentLoaded',function(){
        callTopic();
      });
    </script>
</head>
<body>

   <?php include('include/header.php'); ?>
   <main>
    
    <section id="topic_wrap">
      <div class="topic_post_wrap">
      <div class="tp_post_trigger" onclick="c_toggle('topic_post_box');"><img src="img/plus.svg"></div>
        <section id="topic_post_box" class="hidden">
          <form action="process/post_topic.php" method="post">
              <table>
                
              <input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
              <tr><td colspan="2">
                <p>重要度：<input type="number" min="0" max="5" name="importance">
                    モード：<select name="mode">
                        <option value="00">解決したい</option>
                        <option value="01">つぶやき</option>
                    </select>
                </p>
              </td></tr>
              <tr>
                <td>タグ</td>
                <td><input type="text" name="tag"></td></tr>
              <tr><td>テキスト</td><td><textarea name="content"></textarea></td></tr>
              <tr style="text-align:center;"><td colspan="2"><input type="submit"></td></tr>
              </table>
          </form>
        </section>
      </div>
      <section id="topic_area">
      </section>
      <div class="topic_load" onclick="callTopic();">次の5件を表示</div>
    </section>
   </main>
</body>
</html>