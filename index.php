<?php
require_once('app/config.php');

//verificam daca utilizatorul este logat
if(!$user->is_logged_in()){
	header('Location: login.php');
}

//selectam toate contactele
$xCard = new xCard('data/xCards/'.$user->data['uid'].'.xml');
$cards = $xCard->get_cards();
require_once('app/layout.php');
?>
