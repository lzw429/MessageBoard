<?php
	require_once ("Includes/session.php");
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
    <head>
        <meta charset="utf-8" />
        <title>留言板.lzw429</title>
        <link href="/Styles/Site.css" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
    </head>
    <body>
        <div class="outer-wrapper">
        <header>
            <div class="content-wrapper">
                <div class="float-left">
                    <p class="site-title"><a href="/index.php">欢迎留言</a></p>
                </div>
                <div class="float-right">
                    <section id="login">
                        <ul id="login">
                        <?php
							echo '<li><a href="/addpage.php">添加留言</a></li>' . "\n";
							if (logged_on())//如果已登录
							{
								echo '<li><a href="/selectpagetoedit.php">编辑留言</a></li>' . "\n";
								echo '<li><a href="/deletepage.php">删除留言</a></li>' . "\n";
								echo '<li><a href="/logoff.php">注销</a></li>' . "\n";
								//if(is_admin())
							}
							else//如果未登录
							{
								echo '<li><a href="/logon.php">登录</a></li>' . "\n";
								echo '<li><a href="/register.php">注册</a></li>' . "\n";
							}
						?>
                        </ul>
						<?php
							if (logged_on()) 
							{
								echo "<div class=\"welcomeMessage\">欢迎使用, <strong>{$_SESSION['username']}</strong></div>\n";
							} 
						?>
                    </section>
                </div>
                <div class="clear-fix"></div>
            </div>
            <section class="navigation" data-role="navbar">
                <nav>
                    <ul id="menu">
                        <li><a href="/index.php">首页</a></li>
                        <?php
                            $statement = $databaseConnection->prepare("SELECT id, menulabel FROM pages");
                            $statement->execute();
                            if($statement->error)
                            {
                                die("数据库查询失败： " . $statement->error);
                            }
                            $statement->bind_result($id, $menulabel);
                            while($statement->fetch())
                            {
                                echo "<li><a href=\"/page.php?pageid=$id\">$menulabel</a></li>\n";
                            }
                        ?>
                    </ul>
                </nav>
			</section>
        </header>
	</body>
</html>