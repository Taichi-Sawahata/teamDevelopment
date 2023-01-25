
<header>
   <div id="navArea">
    <nav>
      <div class="inner">
         <ul>
         <li><a href="./humberger/roomNameChange.php">部屋名変更</a></li>
          <li><a href="./humberger/roomMemberDelete.php">ユーザーの退出</a></li>
          <li><a href="./humberger/roomMemberUpdate.php">ユーザーを追加</a></li>
          <li><a href="./humberger/roomNameChange.php">ユーザー名変更</a></li>
          <li><a href="./humberger/logout.php">ログアウト</a></li>
         </ul>
      </div>
    </nav>
   
   
   <div class="toggle-btn">
      <span></span>
      <span></span>
      <span></span>
   </div>

   <div id="mask"></div>
   
       <h1><?php echo $_SESSION['room_name']; ?></h1>
       </div>
   </header>