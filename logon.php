<?php
	OB_START();
    require_once ("Includes/session.php");
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    include ("Includes/header.php");

    if (isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT id, username FROM users WHERE username = ? AND password = SHA(?) LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('ss', $username, $password);//赋值给query里的?

        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows == 1)//验证成功
        {
            $statement->bind_result($_SESSION['userid'], $_SESSION['username']);//登录
            $statement->fetch();
            header ("Location: index.php");
        }
        else
        {
            echo "用户名与密码不匹配";
        }
    }
?>
<div id="main">
    <h2>登录</h2>
        <form action="logon.php" method="post">
            <fieldset>
            <legend>Log on</legend>
            <ol>
                <li>
                    <label for="username">账号：</label> 
                    <input type="text" name="username" value="" id="username" />
                </li>
                <li>
                    <label for="password">密码：</label>
                    <input type="password" name="password" value="" id="password" />
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