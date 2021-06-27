<?php
	header("Expires: on, 01 Jan 1970 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	session_start();
	
	
	$currentTime = time() + 25200;
	$expired = 3600;
	
	
	if(!isset($_SESSION['user'])){
		header("location:index.php");
	}
	
	
	if($currentTime > $_SESSION['timeout']){
		session_destroy();
		header("location:index.php");
	}
	

	unset($_SESSION['timeout']);
	$_SESSION['timeout'] = $currentTime + $expired;
	
?>

<?php include"header.php";?>
<html>
<head>
<title>Productos | <?=$settings['app_name']?> - Dashboard</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
</body>
     
      <div class="content-wrapper">
        <?php include('public/products-table.php'); ?>
      </div>
  </body>
</html>
<?php include"footer.php";?>