<?php 
require_once('app/config.php');

//verificam daca utilizatorul este logat
if(!$user->is_logged_in()){
	header('Location: login.php');
}

$response = array();
//verificam daca exista un request
if(!empty($_POST['uid'])){
	$xCard = new xCard('data/xCards/'.$user->data['uid'].'.xml');
	$card = $xCard->query('/vcards/vcard[uid/uri = "'.$_POST['uid'].'"]');
	$card->item(0)->parentNode->removeChild($card->item(0));//stergem contactul
	$xCard->save();
	$response['succes'] = 1;
}else{
	$response['error'] = 'A aparut o eroare.';
}

print json_encode($response);//encodam raspunsul pentru javascript
?>