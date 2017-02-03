<?php
	OB_START();
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 
    //confirm_is_admin();

    if (isset($_POST['submit']))
    {
        $pageId = $_POST['menulabel'];
        $query = "DELETE FROM pages WHERE id = ?";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $pageId);
        $statement->execute();
        $statement->store_result();

        if ($statement->error)
        {
            die('数据库查询失败： ' . $statement->error);
        }

        // TODO: Check for == 1 instead of > 0 when page names become unique.
        $deletionWasSuccessful = $statement->affected_rows > 0 ? true : false;
        if ($deletionWasSuccessful)//如果删除成功
        {
            header ("Location: index.php");//返回首页
        }
        else
        {
            echo "删除留言失败";
        }
    }
?>
<div id="main">
    <h2>删除留言</h2>
    <?php
        if(is_admin())
            echo("您有权限删除所有留言");
        else if(!is_admin()&&logged_on())
            echo("您有权限删除您所发布过的留言.")
    ?>
    <form action="deletepage.php" method="post">
        <fieldset>
            <legend>Delete Page</legend>
            <ol>
                <li>
                    <label for="menulabel">标题：</label>
                    <select id="menulabel" name="menulabel">
                        <option value="0">--选择留言--</option>//定义列表第0行
                        <?php
                                $statement = $databaseConnection->prepare("SELECT id, menulabel,username FROM pages");
                                $statement->execute();

                                if($statement->error)
                                {
                                    die("数据库查询失败： " . $statement->error);
                                }

                                $statement->bind_result($id, $menulabel,$username);
                                while($statement->fetch())
                                {
                                    if ($username == $_SESSION['username']||$_SESSION['username']=='admin')
                                        echo "<option value=\"$id\">$menulabel</option>\n";
                                }
                            ?>
                    </select>
                </li>
            </ol>
            <input type="submit" name="submit" value="删除" />
            <p>
                <a href="index.php">取消</a>
            </p>
        </fieldset>
    </form>
</div>
</div> <!-- End of outer-wrapper which opens in header.php -->
<?php include ("Includes/footer.php"); ?>