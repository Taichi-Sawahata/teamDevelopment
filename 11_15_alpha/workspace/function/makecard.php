<?php
    //session_start();
    $acc = $_SESSION['user_id'];
    //セッション共通してたわいけるわ！
    function makeCard($data){
        foreach($data as $array){
            $com_id = 'com_'.$array['id'];
                echo '
                <section class="tpContainer" id="tp_'.$array['id'].'">
                <div class="tpWrap">
                <div class="tpCard" onclick="com_toggle(this);" data-id="'.$com_id.'"">
                    <div class="card_l">';
                        if($array['mode']=='00'){
                            echo '<img src="img/discussion_icon.svg" width="100px">';
                        }else{
                            echo '<img src="img/tweet_icon.svg" width="100px">';
                        }
                    echo'
                    </div>
                    <div class="card_r">
                    <div class="cardHead">
                        <ul>
                            <li><span class="tp_id hidden">'.$array['id'].'</span></li>
                            <li><span class="user_name">';
                            if(isset($array['name'])){
                                echo $array['name'];
                            }else{
                                echo 'id:'.$array['user_id'];
                            }
                            
                            echo '</span></li>
                            <li><span class="star">';
                            for($i=1;$i<=5;$i++){
                                if($i<=intval($array['importance'])){
                                    echo '★';
                                }else{
                                    echo '☆';
                                }
                            }
                            echo '</span></li>
                        </ul>';
                if($array['user_id']===$_SESSION['user_id']){
                    //ユーザ自身が書き込んだ投稿の場合
                    echo '<button onclick="resolved(`tp_'.$array['id'].'`);">解決！</button>';
                }
                echo'
                    </div>
                    <div class="cardBody">
                        <span>'.$array['content'].'</span>
                    </div>
                    <div class="cardFoot">
                        <ul>
                            <li><span>'.$array['date'].'</span></li>
                            <li>タグ：<span>'.$array['tags'].'</span></li>
                        </ul>
                    </div>
                </div><!-- card-r -->
                </div><!-- tpCard -->
                </div><!-- tpWrap -->
                
        <div class="tpComment">
            <div class="comContent hidden" id="'.$com_id.'">
            <div class="comRows">';
                foreach($array['comments'] as $comment){
                if (!empty($comment)) {
                    
                    $com_val = array();
                    $com_val = preg_split("/[\/]/",$comment);
                    //var_dump ($com_val);
                    
                    
                echo'<div class="comRow">
                    <div class="comValue"><span>'.$com_val[3].'</span></div>
                    <div class="comData">
                        <ul>
                            <li>ユーザ：<span>'.$com_val[2].'</span></li>
                            <li><span>'.$com_val[1].'</span></li>
                        </ul>
                    </div>
                </div>';
                
                }
            }
              
            echo'</div><!-- comRows -->
                <div class="comForm">
                    <form action="process/post_comment.php" method="post">
                        <input type="hidden" name="topic_id" value="'.$array['id'].'">
                        <textarea name="comment"></textarea>
                        <input type="submit">
                    </form>
                </div>
        </div><!-- comContent -->
        </div><!-- tpComment -->
    </section>';
        }
    }
?>