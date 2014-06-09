<?php 
require_once('app/config.php');

if(!$user->is_logged_in()){
	header('Location: login.php');
}

$response = array();

//verificam daca am primit un fisier
//requestul se va face folosind javascript si un formular care are targhetul intr-un iframe
if(!empty($_FILES)){
	//upload photo
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["photo"]["name"]);
	$extension = end($temp);
	$newName = '';

	if ((($_FILES["photo"]["type"] == "image/gif")
	|| ($_FILES["photo"]["type"] == "image/jpeg")
	|| ($_FILES["photo"]["type"] == "image/jpg")
	|| ($_FILES["photo"]["type"] == "image/pjpeg")
	|| ($_FILES["photo"]["type"] == "image/x-png")
	|| ($_FILES["photo"]["type"] == "image/png"))
	&& ($_FILES["photo"]["size"] < 4500000)
	&& in_array($extension, $allowedExts)) {
	  if ($_FILES["photo"]["error"] > 0) {
		$response['error'] = "Return Code: " . $_FILES["photo"]["error"];
	  } else {
		  $newName = microtime(true).'.'.$extension;
		  move_uploaded_file($_FILES["photo"]["tmp_name"],'images/' .$user->data['uid'].'/'. $newName);
		  $response['src'] = $newName;
		  $response['uid'] = $user->data['uid'];
	  }
	} else {
	  $response['error'] = "Invalid file";
	}
}else{
	$response['error'] = 'Invalid request.';
}

print json_encode($response);

?>