<?php
	
	
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?php include"header.php";?>
<html>
<head>
<title>Clientes | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>

      <div class="content-wrapper">
        <?php include('public/customers-table.php'); ?>
      </div>
  </body>
</html>
<?php include"footer.php";?>

