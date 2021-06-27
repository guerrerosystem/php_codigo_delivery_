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
	include"header.php";?>
<html>
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha256-2kJr1Z0C1y5z0jnhr/mCu46J3R6Uud+qCQHA39i1eYo=" crossorigin="anonymous" />
<title>Configuraciones de la tambo| <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>
     
      <div class="content-wrapper">
        <?php include('public/setting-form.php'); ?>
      </div>
  </body>
</html>

<?php include"footer.php";?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js" integrity="sha256-CgrKEb54KXipsoTitWV+7z/CVYrQ0ZagFB3JOvq2yjo=" crossorigin="anonymous"></script>