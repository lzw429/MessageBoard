<?php
	OB_START();
    date_default_timezone_set('prc');//将默认时区设置为中华人民共和国
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    include("Includes/header.php"); 
    //所有用户均可添加留言//confirm_is_admin();

    if (isset($_POST['submit']))//点击提交后
    {
        $menulabel = $_POST['menulabel'];
        $content = $_POST['content'];
		if(logged_on())
			$username = $_SESSION['username'];
		else $username = '';
        $datetime = date('Y-m-d H:i:s',time());//time()返回时间戳
        if($menulabel!='' && $content!='')//如果标题和内容都已填写
        {
            $query = "INSERT INTO pages (menulabel, content, username, datetime) VALUES (?, ?, ?, ?)";
            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ssss', $menulabel, $content, $username ,$datetime);//将获得的数据写入数据库的表中
            $statement->execute();
            $statement->store_result();//检查数据库储存状态

            if ($statement->error)//如果数据库储存错误
            {
                die('数据库查询失败： ' . $statement->error);//返回信息，退出当前脚本
            }

            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;//判断添加页面是否成功
            if ($creationWasSuccessful)//如果添加页面成功
            {
                header ("Location: index.php");//返回首页
            }
            else//如果添加页面失败
            {
                echo '添加留言失败';
            }
        }
        else
            echo'请填写标题和内容';
    }
?>
<div id="main">
    <h2>添加留言</h2>
        <form action="addpage.php" method="post">
            <fieldset>
            <legend>Add Page</legend>
            <ol>
                <li>
                    <label for="menulabel">标题:</label> 
                    <input type="text" name="menulabel" value="" id="menulabel" />
                </li>
                <li>
                    <label for="content">内容：</label>
                    <textarea name="content" id="content"></textarea>
                </li>
            </ol>
            <input type="submit" name="submit" value="提交" />
            <p>
                <a href="index.php">取消</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>

