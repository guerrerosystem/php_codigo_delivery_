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
<?php include"header.php";?>
<html>
<head>
<title>Detalles de producto | <?=$settings['app_name']?> - Dashboard</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="UTF-8">
</head>
<body>
      
      <div class="content-wrapper">
        <?php include('public/product-data.php'); ?>
      </div>
  </body>
</html>
<?php include"footer.php";?>