<?php session_start();
    ob_start(); 
    include_once('includes/crud.php');
    $db = new Database;
    include_once('includes/custom-functions.php');
    $fn = new custom_functions();
    $db->connect();
    date_default_timezone_set('Asia/Kolkata');
    $sql = "SELECT * FROM settings";
    $db->sql($sql);
    $res = $db->getResult();
    $settings = json_decode($res[5]['value'],1);
    $logo = $fn->get_settings('logo');
    
    ?>
<!DOCTYPE html>
<html>
  <head>
  
  <title>Login</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/ico" href="<?='dist/img/'.$logo?>">
	<title>Administrador Login - <?=$settings['app_name']?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

	<link rel="stylesheet" type="text/css" href="log/vendor/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="log/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="log/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

	<link rel="stylesheet" type="text/css" href="log/vendor/animate/animate.css">

	<link rel="stylesheet" type="text/css" href="log/vendor/css-hamburgers/hamburgers.min.css">

	<link rel="stylesheet" type="text/css" href="log/vendor/animsition/css/animsition.min.css">

	<link rel="stylesheet" type="text/css" href="log/vendor/select2/select2.min.css">

	<link rel="stylesheet" type="text/css" href="log/vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" type="text/css" href="log/css/util.css">
	<link rel="stylesheet" type="text/css" href="log/css/main.css">
  </head>
<body background="images/t.jpg"no-repeat>
   
       <?php include 'public/login-form.php'; ?>
  </body>
</html>