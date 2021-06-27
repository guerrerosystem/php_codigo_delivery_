<?php
	
	ob_start();
	
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
<title>Agregar repartidor | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>
<?php include"footer.php";?>
   
      <div class="content-wrapper">
        <?php include('public/delivery-boy-table.php'); ?>
      </div><!-- /.content-wrapper -->
  </body>
</html>

    	