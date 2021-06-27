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
<head>Imprimir factura para la ordenr</head>
<title>Informe de factura<?=$settings['app_name']?> - Dashboard</title>
<body>
     
      <div class="content-wrapper">
        <?php include('public/invoice-print.php'); ?>
      </div>
  </body>
</html>
<?php include"footer.php";?>
  		
    		