<?php
	OB_START();
	require_once ("Includes/simplecms-config.php");
	require_once  ("Includes/connectDB.php");
	include("Includes/header.php");
	//confirm_is_admin();

if (isset($_POST['submit']))//点击“开始编辑”按钮后
{
    $pageId = $_POST['pageId'];
    $query = "SELECT Id FROM pages WHERE id = ?";//在数据库中选择用户需要查找的id
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param('d', $pageId);
    $statement->execute();
    $statement->store_result();

    if ($statement->error)
    {
        die('数据库查询失败： ' . $statement->error);
    }

    // TODO: Check for == 1 instead of > 0 when page names become unique.
    $pageExists = $statement->num_rows == 1;
    if ($pageExists)//如果页面存在
    {
        header ("Location: editpage.php?id=$pageId");//跳转页面
    }
    else if($pageId==0)
        echo("请选择留言");
    else
    {
        echo "未找到您想要编辑的留言";
    }
}
?>
<div id="main">
    <h2>编辑留言</h2>
     <?php
        if(is_admin())
          echo("您可以编辑所有留言");
         else if(!is_admin()&&logged_on())
           echo("您可以编辑您所发布过的留言.")
     ?>
     <form action="selectpagetoedit.php" method="post">
        <fieldset>
            <legend>Edit Page</legend>
            <ol>
                <li>
                    <label for="pageId">标题：</label>
                    <select id="pageId" name="pageId">//定义选择框
                        <option value="0">--选择留言--</option>//定义列表第0行
                        <?php
                        $statement = $databaseConnection->prepare("SELECT id, menulabel, username FROM pages");//在数据库中选择pages表中的id,menulabel,username
                        $statement->execute();//查找数据库

                        if($statement->error)
                        {
                            die("数据库查询失败： " . $statement->error);
                        }

                        $statement->bind_result($id, $menulabel,$username);//将数据库中的值赋给变量
                        while($statement->fetch())
                        {
                            if($username == $_SESSION['username']||$_SESSION['username']=='admin')
                                echo "<option value=\"$id\">$menulabel</option>\n";//在列表内显示
                        }
                        ?>
                    </select>
                </li>
            </ol>
            <input type="submit" name="submit" value="开始编辑" />
        </fieldset>
    </form>
    <br/>
    <a href="index.php">取消</a>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>