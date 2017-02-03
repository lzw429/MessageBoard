<?php 
	OB_START();
    require_once ("Includes/simplecms-config.php"); 
    require_once ("Includes/connectDB.php");
    include("Includes/header.php");         
?>
<div id="main">
	<h3>开始使用这个网站</h3>
    <ol class="round">
        <li class="one">
            <h5>注册并登录您的账户 </h5>
            <p>您也可以匿名发布留言</p>
        </li>
        <li class="two">
            <p>登录之后</p>
            <p>您发布的留言将自动署名</p>
        </li>
        <li class="three">
            <p>您登录后发表的留言<br>可被您再编辑或删除</p>
         </li>
    </ol>
</div>
</div><!-- End of outer-wrapper which opens in header.php -->
<?php 
    include ("Includes/footer.php");
 ?>