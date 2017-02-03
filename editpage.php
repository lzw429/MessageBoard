<?php
	OB_START();
	require_once ("Includes/session.php");
	require_once ("Includes/simplecms-config.php");
	require_once ("Includes/connectDB.php");
	include("Includes/header.php");
	//confirm_is_admin();

	$pageId = null;
	$menulabel = null;
	$content = null;
	if(isset($_GET['id']))//获取留言标题和内容
	{
		$pageId = $_GET['id'];
		$query = "SELECT menulabel, content FROM pages WHERE id = ?";
		$statement = $databaseConnection->prepare($query);
		$statement->bind_param('d', $pageId);
		$statement->execute();
		$statement->store_result();

		if ($statement->error)
		{
			die('数据库查询失败： ' . $statement->error);
		}

		$pageExists = $statement->num_rows == 1;
		if ($pageExists)
		{
			$statement->bind_result($menulabel, $content);
			$statement->fetch();
		}
		else
		{
			header("Location: index.php");
		}
	}
	else if (isset($_POST['submit']))//更改留言标题和内容
	{
		$pageId = $_POST['pageId'];
		$menulabel = $_POST['menulabel'];
		$content = $_POST['content'];
		$query = "UPDATE pages SET menulabel = ?, content = ? WHERE Id = ?";

		$statement = $databaseConnection->prepare($query);
		$statement->bind_param('ssd', $menulabel, $content, $pageId);
		$statement->execute();
		$statement->store_result();

		if ($statement->error)
		{
			die('数据库查询失败： ' . $statement->error);
		}

		$creationWasSuccessful = $statement->affected_rows == 1 ? true : false;
		if ($creationWasSuccessful)
		{
			header ("Location: index.php");
		}
		else
		{
			echo '编辑留言失败';
		}
	}
	else
	{
		header ("Location: index.php");
	}
?>
	<div id="main">

		<h1>编辑留言</h1>
		<form action="editpage.php" method="post">
			<fieldset>
					<legend>Edit Page</legend>
					<ol>
						<li>
							<input type="hidden" id="pageId" name="pageId" value="<?php echo $pageId; ?>" />
							<label for="menulabel">标题：</label> 
							<input type="text" name="menulabel" value="<?php echo $menulabel; ?>" id="menulabel" />
						</li>
						<li>
							<label for="content">内容：</label>
							<textarea name="content" id="content"><?php echo $content; ?></textarea>
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
