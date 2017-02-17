<?php
    session_start();
    require_once  ("Includes/connectDB.php");
    function logged_on()
    {
        return isset($_SESSION['userid']);//返回是否有账户登录
    }
    function confirm_is_admin() 
    {
        if (!logged_on())//如果未登录
        {
            header ("Location: logon.php");//返回登录页面
        }

        if (!is_admin())//如果已登录但非管理员
        {
            header ("Location: index.php");//返回主页
        }
    }
    function is_admin()
    {
        global $databaseConnection;
        $query = "SELECT user_id FROM users_in_roles UIR INNER JOIN roles R on UIR.role_id = R.id WHERE R.name = 'admin' AND UIR.user_id = ? LIMIT 1";
        $statement = $databaseConnection->prepare($query);
        $statement->bind_param('d', $_SESSION['userid']);
        $statement->execute();
        $statement->store_result();
        return $statement->num_rows == 1;
    }
?>