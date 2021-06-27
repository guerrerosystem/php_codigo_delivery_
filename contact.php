<?php include"header.php";?>

<html>
<head>
	<title>Contacto | <?=$settings['app_name']?> - Dashboard</title>
</head>
<body>
<div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background-image: url(images/content/brdcrm_bg.png);">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-4 col-sm-6">
				<div class="page_title">
					<h2>Contactenos</h2>
				</div>
			</div>
			<div class="col-lg-6 col-md-8 col-sm-6">
				<ul class="breadcrumb">
					<li><a href="index.php">Pagina principal</a></li>
					<li><i class="fa fa-chevron-left"></i></li>
					<li><a href="contact.php">Contáctenos </a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="ed_heading_top">
					<h3>Formulario de contacto</h3>
				</div>
			</div>
			<form method="post">
			<div class="ed_contact_form ed_toppadder60">
				<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<input type="text" id="uname" name="uname" class="form-control"  placeholder="તમારું નામ">
				</div>
				<div class="form-group">
					<input type="email" id="umail" name="umail" class="form-control"  placeholder="Tu correo electrónico">
				</div>
				<div class="form-group">
					<input type="text" id="sub" name="sub" class="form-control"  placeholder="Tema">
				</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="form-group">
					<textarea id="msg" name="msg" class="form-control" rows="6" placeholder="Mensaje "></textarea>
				</div>
				<button type="submit" id="ed_submit" name="submit" class="btn ed_btn ed_orange pull-right">Enviar </button>
				<p id="err"></p>
				</div>
			</div>
			</form>
			<?php
				if(isset($_POST['submit']))
				{
    $email_to = "jaydeepjgiri@yahoo.com";
    $firstname = $_POST["uname"];   
    $email_from = $_POST["umail"];
    $message = $_POST["msg"];
    $email_subject =$_POST["sub"];
    $headers = "From: " . $email_from . "\n";
    $headers .= "Reply-To: " . $email_from . "\n";
    $message = "Name: ". $firstname . "\r\nMessage: " . $message;
    ini_set("sendmail_from", $email_from);
    $sent = mail($email_to, $email_subject, $message, $headers, "-f".$email_from);
    if ($sent)
    {
        echo "<script>alert('Tu mensaje enviado con éxito');top.location='contact.php';</script>";   
    }     
    else    
    {
        echo "Ha habido un error al enviar su mensaje. Por favor intente mas tarde.";
    }
}


			?>
		</div>
	</div>
</div>

<div class="ed_event_single_contact_address ed_toppadder70 ed_bottompadder70">
	<div class="container">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="ed_heading_top ed_bottompadder70">
					<h3>Contacto y búsqueda</h3>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="row">
					<div class="ed_event_single_address_info ed_toppadder50 ed_bottompadder50">
						<h4 class="ed_bottompadder30">Datos de contacto</h4>
						<p class="ed_bottompadder40 ed_toppadder10">Siempre puede comunicarse con nosotros a través de los siguientes datos de contacto. Haremos todo lo posible para llegar a usted lo más posible..</p>
						<p>Telefono: <span>972805092</span></p>
						<p>Email: <a href="#">edifanio.97@gmail.com</a></p>
						<p>WEB: <a href="https://millaguerrero.blogspot.com/">https://millaguerrero.blogspot.com/</a></p>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="row">
					<div class="ed_event_single_address_map">
						<div id="map"></div>
					</div>
				</div>
			</div>
	</div>
</div>

<?php include"footer.php";?>
</body>
</html>


