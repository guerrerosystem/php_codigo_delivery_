<?php 
session_start();
ini_set('display_errors', 1);

require_once 'includes/crud.php';
$db_con=new Database();
$db_con->connect();
require_once 'includes/functions.php';
require_once('includes/firebase.php');
require_once ('includes/push.php');


$fnc = new functions;

include_once('includes/custom-functions.php');
    
$fn = new custom_functions;
$permissions = $fn->get_permissions($_SESSION['id']);

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){	
	
	if(isset($_POST['title']) and isset($_POST['message'])) {
		if($permissions['notifications']['create']==0){
			$response['error']=true;
			$response['message']='<p class="alert alert-danger">No tienes permiso para enviar notificaciones</p>';
			echo(json_encode($response));
			return false;

		}
		
		$title = $db_con->escapeString($_POST['title']);
		$message = $db_con->escapeString($_POST['message']);
		$type = $db_con->escapeString($_POST['type']);
		$id = ($type != 'default')?$_POST[$type]:"0";
		
		$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$url .= $_SERVER['SERVER_NAME'];
		$url .= $_SERVER['REQUEST_URI'];
		$server_url = dirname($url).'/';
		
		$push = null;
		$include_image = (isset($_POST['include_image']) && $_POST['include_image'] == 'on') ? TRUE : FALSE;
		if($include_image){
			
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$extension = explode(".", $_FILES["image"]["name"]);
			$extension = end($extension);
			if(!(in_array($extension, $allowedExts))){
				$response['error']=true;
				$response['message']='Image type is invalid';
				echo json_encode($response);
				return false;
			}
			$target_path = 'upload/notifications/';
			$filename = microtime(true).'.'. strtolower($extension);
			$full_path = $target_path."".$filename;
			if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
				$response['error']=true;
				$response['message']='Image type is invalid';
				echo json_encode($response);
				return false;
			}
			$sql = "INSERT INTO `notifications`(`title`, `message`,  `type`, `type_id`, `image`) VALUES 
			('".$title."','".$message."','".$type."','".$id."','".$full_path."')";
		}else{
			$sql = "INSERT INTO `notifications`(`title`, `message`, `type`, `type_id`) VALUES 
			('".$title."','".$message."','".$type."','".$id."')";
		}
		$db_con->sql($sql);
		$db_con->getResult();
		
		if($include_image){
			$push = new Push(
				$_POST['title'],
				$_POST['message'],
				$server_url.''.$full_path,
				$type,
				$id
			);
		}else{
			
			$push = new Push(
				$_POST['title'],
				$_POST['message'],
				null,
				$type,
				$id
			);
		}


		$mPushNotification = $push->getPush();
		
		
		$devicetoken = $fnc->getAllTokens();
		
	
		$firebase = new Firebase(); 

		
		$firebase->send($devicetoken, $mPushNotification);
		$response['error'] = false;

		$response["message"] = "<span class='label label-success'>Notificación enviada con éxito!</span>";
	}else{
		$response['error']=true;
		$response['message']='Faltan parámetros';
	}
}else{
	$response['error']=true;
	$response['message']='Solicitud no válida';
}

echo(json_encode($response));

?>
