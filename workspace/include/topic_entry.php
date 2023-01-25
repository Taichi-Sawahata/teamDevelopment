<form action="process/post_topic.php" method="post">   
    <input type="hidden" value="<?php echo $_SESSION['user_id']; ?>" name="user_id">
    <table class="tp_entry">
    
    
    <tr>
        <th>モード</th>
        <td><select name="mode">
            <option value="00">解決したい！</option>
            <option value="01">つぶやき</option>
        </select></td>
        <td rowspan="3"><textarea name="content" cols="30" rows="6"></textarea></td>
    </tr>
    <tr>
        <th>重要度</th>
        <td><select name="importance">
            <option value="1">★☆☆☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="3">★★★☆☆</option>
            <option value="4">★★★★☆</option>
            <option value="5">★★★★★</option>

        </select></td>
    </tr>
    <tr>
        <th>タグ</th>
        <td><input type="text" name="tag"></td>
    </tr>
    
    </table>
    <input type="submit" class="btn_tp">
</form>


