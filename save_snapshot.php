<?php
require_once('app/config.php');

if(!$user->is_logged_in()){
	header('Location: login.php');
}

$response = array();

//verificam daca am primit o fotagrafie
//requestul se va face prin ajax iar fotografia va fi encodata base64
//fotografia este facuta utilizand getUserMedia din html5
if(!empty($_POST['foto'])){
	$newName = microtime(true).'.jpg';
	$fp = fopen('images/' .$user->data['uid'].'/'. $newName,'w');
	fwrite($fp,base64_decode(str_replace('data:image/jpeg;base64,','',$_POST['foto'])));//decodam fotografia si o salvam in fisier
	$response['src'] = $newName;
	$response['uid'] = $user->data['uid'];
}else{
	$response['error'] = 'Invalid request.';
}

print json_encode($response);

//print base64_encode(file_get_contents('images/' .$user->data['uid'].'/1401894792.8913.jpg'));
?>
