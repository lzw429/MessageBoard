<?php 
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 
?>

<div id="main">
    <?php
        $pageid = $_GET['pageid'];
        $query = 'SELECT menulabel, content ,username ,datetime FROM pages WHERE id = ? LIMIT 1';//从数据库的表头中设置变量
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('s', $pageid);
        $statement->execute();
        $statement->store_result();
        if ($statement->error)
        {
            die('数据库查询失败： ' . $statement->error);
        }

        if ($statement->num_rows == 1)
        {
            $statement->bind_result($menulabel, $content, $username,$datetime);
            $statement->fetch();
            if($username=='')
                $username='匿名用户';
            echo "<h2>$menulabel</h2><p>作者:$username 时间:$datetime</p><p>$content</p>";
        }
        else
        {
            echo '未找到页面';
        }
    ?>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>