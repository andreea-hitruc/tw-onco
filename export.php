<?php
require_once('app/config.php');

//verificam daca utilizatorul este logat
if(!$user->is_logged_in()){
	header('Location: login.php');
}

$pageTitle = 'Exporta contacte';

$xCard = new xCard('data/xCards/'.$user->data['uid'].'.xml');
$export = true;

//verificam formatul exportului
if(!empty($_GET['csv'])){
	$download = 'temp/'.$xCard->export_csv();
}else if(!empty($_GET['vcard'])){
	$download = 'temp/'.$xCard->export_vcard();
}else if(!empty($_GET['atom'])){
	$download = 'data/xCards/'.$user->data['uid'].'.xml';
}

require_once('app/layout.php');
?>