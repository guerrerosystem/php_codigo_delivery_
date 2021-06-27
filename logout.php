<?php

	session_start();	
	unset($_SESSION['user']);
	unset($_SESSION['id']);
	unset($_SESSION['role']);
	unset($_SESSION['timeout']);

	header("location:index.php");
?>