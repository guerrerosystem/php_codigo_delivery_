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
<title>Perfil de administrador | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>
	
	<div class="content-wrapper">
	<?php $username = $_SESSION['user'];
	$sql_query = "SELECT password, email FROM admin 
	WHERE username ='".$username."'";

	$data = array();			
		
		$db->sql($sql_query);
		
		$res=$db->getResult();
	$previous_password = $res[0]['password'];
	$previous_email = $res[0]['email'];
	
	if(isset($_POST['btnChange'])){
		$email = $_POST['email'];
		$update_username = $_POST['username'];
		$old_password = md5($_POST['old_password']);
		$new_password = md5($_POST['new_password']);
		$confirm_password = md5($_POST['confirm_password']);
		
		$error = array();
		
		if(!empty($_POST['old_password']) || !empty($_POST['new_password']) || !empty($_POST['confirm_password'])){
		
			if(!empty($_POST['old_password'])){				
				if($old_password == $previous_password){
					if($new_password == $confirm_password){
				
						if(!empty($_POST['new_password'])){
							$sql_query = "UPDATE admin 
							SET `password` = '".$new_password."',`username`='".$update_username."'
							WHERE `username` ='".$username."'";
						}else{
							$sql_query = "UPDATE admin 
							SET `username`='".$update_username."'
							WHERE `username` ='".$username."'";
						}
						
					
						$db->sql($sql_query);
						
						$update_result = $db->getResult();
						if($username!=$update_username || !empty($_POST['new_password'])){
				?>
				<script>window.location = "logout.php";</script>
				<?php }
					}else{
						$error['confirm_password'] = " <span class='label label-danger'>¡La nueva contraseña no coincide!</span>";
					}
				}else{
					$error['old_password'] = " <span class='label label-danger'>¡Contraseña actual incorrecta!</span>";
				}
			}
		}
		
		if(empty($email)){
			$error['email'] = " <span class='label label-danger'>Email obligatorio</span>";
		}else{
			$valid_mail = "/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i";
			if (!preg_match($valid_mail, $email)){
				$error['email'] = " <span class='label label-danger'>Formato de correo electrónico incorrecto!</span>";
				$email = "";
			}else{
			
				$sql_query = "UPDATE admin 
						SET email = '".$email."'
						WHERE username ='".$username."'";
					
				
					$db->sql($sql_query);
				
					$update_result = $db->getResult();
				
			}
		}
	
		if(empty($error)){
			if($previous_email != $email){
				$error['update_user'] = " <h4><div class='alert alert-success'>
				Correo electrónico actualizado con éxito!
			</div></h4>";
			}else{
				$error['update_user'] = " <h4><div class='alert alert-info'>
				¡No has hecho cambios!
			</div></h4>";
			}

			
		}else{
			$error['update_user'] = " <h4><div class='alert alert-danger'>
			¡Ha fallado! No se pudo actualizar la contraseña. Inténtalo de nuevo
			</div></h4>";
		}
	}		

				
	?>

	<section class="content-header">
          <h1>Administrador</h1>
          <ol class="breadcrumb">
                    <li>
                        <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                    </li>
                </ol>
		<?php echo isset($error['update_user']) ? $error['update_user'] : '';?>
		<hr />
        </section>
		<section class="content">
         
		 
          <div class="row">
		  <div class="col-md-6">
             
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Editar detalles del administrador</h3>
                </div>
                <form id='change_password_form' method="post" enctype="multipart/form-data">
				<div class="box-body">
				    <div class="form-group">
						<span class="label label-primary">Si cambia el nombre de usuario o la contraseña, deberá iniciar sesión nuevamente.</span>
					</div>
                    <div class="form-group">
						<label for="exampleInputEmail1">Nombre de usuario : </label>
						<input type="text" class="form-control" name="username" id="disabledInput" value="<?php echo $username; ?>"/>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Email :</label><?php echo isset($error['email']) ? $error['email'] : '';?>
						<input type="email" class="form-control" name="email" value="<?php echo $email; ?>"/>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">contraseña actual :</label><?php echo isset($error['old_password']) ? $error['old_password'] : '';?>
						<input type="password" class="form-control" name="old_password"/>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Nueva contraseña :</label><?php echo isset($error['new_password']) ? $error['new_password'] : '';?>
						<input type="password" class="form-control" name="new_password" id="new_password"/>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">confirma nueva contraseña :</label><?php echo isset($error['confirm_password']) ? $error['confirm_password'] : '';?>
						<input type="password" class="form-control" name="confirm_password"/>
					</div>
					<div class="box-footer">
						<input type="submit" class="btn-primary btn" value="Cambiar" name="btnChange"/>
					</div>
				</div>
				</form>
			</div>
		  </div>
	</section>
	<div class="separator"> </div>
</div>
  </body>
</html>
<?php include"footer.php";?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
$('#change_password_form').validate({
	rules:{
		username:"required",
		old_password:"required",
		email:"required",
		new_password:{minlength:6},
		confirm_password:{minlength:6,equalTo : '#new_password'},
	}
});
</script>