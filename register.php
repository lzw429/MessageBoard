<?php
    OB_START();
    require_once ("Includes/simplecms-config.php"); 
    require_once  ("Includes/connectDB.php");
    include("Includes/header.php"); 

    if (isset($_POST['submit']))//点击注册之后
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
		
        $sql = "SELECT * FROM users WHERE username = ? ";//检查当前用户名是否与已注册的用户名重复
		$statement = $databaseConnection->prepare($sql);
        $statement->bind_param('s', $username);//赋值给query里的?

        $statement->execute();
        $statement->store_result();

        if($username=='admin')//不允许申请管理员的用户名
            echo("请注意，注册该用户名非法！");
        else if ($statement->num_rows !=0)//如果数据库中已注册的用户名与当前用户名有匹配
        {
            echo("该用户名已存在.");
        }
        else if($username==''||$password=='')
            echo("请注意，用户名或密码不能为空！");
        else
        {
            $query = "INSERT INTO users (username, password) VALUES (?, SHA(?))";//获取用户名和密码，对密码进行SHA加密

            $statement = $databaseConnection->prepare($query);
            $statement->bind_param('ss', $username, $password);
            $statement->execute();
            $statement->store_result();//存储用户名和密码

            $creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
            if ($creationWasSuccessful)//如果注册成功
            {
                $userId = $statement->insert_id;

                $addToUserRoleQuery = "INSERT INTO users_in_roles (user_id, role_id) VALUES (?, ?)";
                $addUserToUserRoleStatement = $databaseConnection->prepare($addToUserRoleQuery);

                // TODO: Extract magic number for the 'user' role ID.
                $userRoleId = 2;
                $addUserToUserRoleStatement->bind_param('dd', $userId, $userRoleId);
                $addUserToUserRoleStatement->execute();
                $addUserToUserRoleStatement->close();

                $_SESSION['userid'] = $userId;
                $_SESSION['username'] = $username;
                header ("Location: index.php");
            }
            else//如果注册失败
            {
                echo "注册失败";
            }
         }
    }
?>
<div id="main">
    <h2>注册一个账户</h2>
        <form action="register.php" method="post">
            <fieldset>
                <legend>Register an account</legend>
                <ol>
                    <li>
                        <label for="username">账号:</label> 
                        <input type="text" name="username" value="" id="username" />
                    </li>
                    <li>
                        <label for="password">密码:</label>
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
<?php
    include ("Includes/footer.php");
?>